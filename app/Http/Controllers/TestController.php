<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;
use App\Plan;
use App\Wpaj_pmpro_membership_level;
use App\Grade;
use App\Test_section_mapping;
use App\Section;
use App\Question;
use App\Answer;
use App\Section_question;
use App\Category;
use DB;
use Excel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tests = Test::select('tests.*', DB::raw('(CASE WHEN user_category = 1 THEN "Free" WHEN user_category = 2 THEN "Premium" ELSE "Free" END) AS user_category'))
        ->where("is_active", 1)
        ->orderBy("id", "DESC")
        ->get();
        return view('tests.index', ['tests' => $tests]);
    }

    public function add()
    {
        $membership_level = Wpaj_pmpro_membership_level::orderBy("id", "ASC")->get();
        return view('tests.add', ['membership_level' => $membership_level]);
    }

    public function insert(Request $request)
    {
        /*$request->validate([
            'test_name' => 'required|string|unique:tests'
        ]);*/
        $check_test = Test::where("test_name", $request->test_name)->where("is_active", 1)->first();
        if(!$check_test)
        {
            $test = new Test;
            $test->test_name = $request->test_name;
            $test->membership_level_id = $request->membership_level;
            $test->is_active = 1;
            if($test->save())
            {
                flash('Test has been added successfully.')->success();
                return redirect('manage_tests'); 
            }
            else
            {
                flash('Please fill the form correctly.')->error();
                return redirect()->back();
            }
        }
        else
        {
            flash('This test is already available, please select other test name.')->error();
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if($id)
        {
            $membership_level = Wpaj_pmpro_membership_level::orderBy("id", "ASC")->get();
            $tests = Test::find($id);
            return view('tests.edit', ['tests' => $tests, 'membership_level' => $membership_level]);
        }
        else
        {
            flash('Something went wrong. Please try again.')->error();
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        if($request->id)
        {
            $test = Test::find($request->id);
            $test->test_name = $request->test_name;
            $test->membership_level_id = $request->membership_level;
            if($test->save())
            {
                flash('Test has been updated successfully.')->success();
                return redirect('manage_tests'); 
            }
            else
            {
                flash('Please fill the form correctly.')->error();
                return redirect()->back();
            }
        } 
        else
        {
            flash('Something went wrong. Please try again.')->error();
            return redirect()->back();
        }  
    }

    public function inactive($id)
    {
        if($id)
        {
            $test = Test::find($id);
            $test->is_active = 0;
            if($test->save())
            {
                flash('Test has been deleted successfully.')->success();
                return redirect('manage_tests'); 
            }
        } 
        else
        {
            flash('Something went wrong. Please try again.')->error();
            return redirect()->back();
        }  
    }


    public function bulkupload()
    {
        $membership_level = Wpaj_pmpro_membership_level::orderBy("id", "ASC")->get();
        $tests = Test::select('id', 'test_name')
        ->where('is_active',1)
        ->orderBy("test_name", "ASC")
        ->get();
        return view('tests.bulk_upload', ['tests' => $tests, 'membership_level' => $membership_level]);
    }

    public static function get_test_sections(Request $reuqest) 
    {
        $sections = Test_section_mapping::leftjoin("sections", "test_section_mappings.section_id", "=", "sections.id")
          ->select('sections.id', 'sections.duration_in_mins', 'sections.section', 'sections.difficulty_level' )
          ->orderBy("sections.section", "ASC")
          ->where('test_section_mappings.test_id', $reuqest->id)
          ->get();
        if(count($sections))
        {
            for($i=0;$i<count($sections);$i++)
            {
                $data[] = array('section'=>$sections[$i]->section,'duration_in_mins'=>$sections[$i]->duration_in_mins,'difficulty_level'=>$sections[$i]->difficulty_level);
            }
        $output  = $data;
        echo json_encode($output);
        }
    }

    public static function get_test_membership(Request $reuqest) 
        {
            $test = Test::where('id', $reuqest->id)
            ->select('membership_level_id')
            ->first();
            $output  = $test['membership_level_id'];
            echo json_encode($output);
        }

    public static function add_test_section(Request $request) 
    {
        $testid = 0;
        $sectionid = 0;
        if($request->id!=0 && $request->id!="-1")
        {
            $testid = $request->id;
        }
        elseif(!empty($request->test_name)) 
        {
            $check_test = Test::where("test_name", $request->test_name)->where("is_active", 1)->first();
            if(!$check_test)
            {
                $test = new Test;
                $test->test_name = $request->test_name;
                $test->membership_level_id = $request->membership_level;
                $test->is_active = 1;
                $test->save();
                $testid = $test->id;
            }
            else
            {
                $testid = $check_test['id'];
            }
        }
        else
        {
            $data = array("success"=>0, "message"=>"Please select a test or create a new test.", "testid"=>$testid);
        }

        $check_section = Test_section_mapping::leftjoin("sections", "test_section_mappings.section_id", "=", "sections.id")
          ->where('test_section_mappings.test_id', $testid)
          ->where('sections.section', $request->section)
          ->first();
        if(!$check_section)        
        {
            $section = new Section;
            $section->section = $request->section;
            $section->duration_in_mins = $request->duration_in_mins;
            $section->difficulty_level = $request->difficulty_level;
            $section->description = $request->description;
            $section->is_active = 1;
            $section->save();
            $sectionid = $section->id;

            $section_map = new Test_section_mapping;
            $section_map->test_id = $testid;
            $section_map->section_id = $sectionid;
            $section_map->is_active = 1;
            $section_map->save();

            $data = array("success"=>1, "message"=>"Section has been added successfully.", "testid"=>$testid);
        }
        else
        {
            $data = array("success"=>0, "message"=>"This section is already available in the test.", "testid"=>$testid);
        }
        $output  = $data;
        echo json_encode($output);
    }
public function add_bulk_test(Request $request) 
    {
        $testid = $request->testid;
        if(!empty($testid))
        {
           $file_name = pathinfo($request->bulk_excel->getClientOriginalName(), PATHINFO_FILENAME); 
           $extension = pathinfo($request->bulk_excel->getClientOriginalName(), PATHINFO_EXTENSION);
           
           if($extension == "xlsx" || $extension == "xls")
           {
                $log = "";
                $error = "true";
                Excel::load($request->file('bulk_excel')->getRealPath(), function ($reader) use ($request, $log, $file_name, $extension, &$error)
                {
                    /*if(!array_key_exists("question",$reader->toArray()[0][0]))
                    {*/
                    $question_log = "";
                    $question_log = "questions_".date("Ymdhis").".log";                    

                    $questionLog = new Logger($question_log);
                    $questionLog->pushHandler(new StreamHandler(storage_path('logs/'.$question_log)), Logger::INFO);
                    //die("here");
                    $row_count = 1;
                   /* echo"<pre>";
                    print_r($reader->toArray());die;*/
                    foreach ($reader->toArray() as $key => $row) 
                    {
                        if(!array_key_exists("question",$row))
                        {
                            flash('Question column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }

                        if(!array_key_exists("section_name",$row))
                        {
                            flash('Section Name column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("category",$row))
                        {
                            flash('Category column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("question_type_1_essay_2_multiple_choice",$row))
                        {
                            flash('Question Type column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("difficulty_level_1low_5medium_10high",$row))
                        {
                            flash('Difficulty Level column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("answer_1",$row))
                        {
                            flash('Answer 1 column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("answer_2",$row))
                        {
                            flash('Answer 2 column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("answer_3",$row))
                        {
                            flash('Answer 3 column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("answer_4",$row))
                        {
                            flash('Answer 4 column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("answer_5",$row))
                        {
                            flash('Answer 5 column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }
                        if(!array_key_exists("correct_answer",$row))
                        {
                            flash('Correct Answer column is not present or not in correct format in your excel')->error();
                            $error = "false";
                            break;
                        }

                        $row_count = $row_count+1;
                        $question = "";
                        if(isset($row['question']))
                        $question = $row['question'] ? $row['question']:"";
                    
                        $section_name = "";
                        if(isset($row['section_name']))
                        $section_name = $row['section_name'] ? $row['section_name']:"";
                        if(!empty($question))
                        {
                            if(!empty($section_name))
                            {
                                $category = "";
                                if(isset($row['category']))
                                {
                                    $category = $row['category'] ? $row['category']:"";

                                    $category_data = Category::select('id')->get();
                                    $category_array = array();
                                    if(count($category_data))
                                    {
                                        foreach ($category_data as $value) 
                                        {
                                            array_push($category_array , $value->id);
                                        }
                                    }
                                    if(!in_array($category, $category_array))
                                    {
                                        $category = "";
                                        $log = "' Row # ".$row_count."'could not be added because category is not correct.";
                                        $questionLog->addError("error-".$log);
                                    }
                                }
                                else
                                {
                                    $log = "' Row # ".$row_count."' could not be added because category is not present.";
                                    $questionLog->addError("error-".$log);
                                }

                                $question_type = "";
                                if(isset($row['question_type_1_essay_2_multiple_choice']))
                                {
                                    $question_type = $row['question_type_1_essay_2_multiple_choice'] ? $row['question_type_1_essay_2_multiple_choice']:"";
                                    if($question_type!=1 && $question_type!=2)
                                    {
                                        $question_type = "";
                                        $log = "' Row # ".$row_count."' could not be added because question type is not correct.";
                                        $questionLog->addError("error-".$log);
                                    }
                                }
                                else
                                {
                                    $log = "' Row # ".$row_count."' could not be added because question type is not present.";
                                    $questionLog->addError("error-".$log);
                                }
                                
                                $difficulty_level = "";
                                if(isset($row['difficulty_level_1low_5medium_10high']))
                                {
                                    $difficulty_level = $row['difficulty_level_1low_5medium_10high'] ? $row['difficulty_level_1low_5medium_10high']:"";
                                    if($difficulty_level!=1 && $difficulty_level!=2 && $difficulty_level!=3)
                                    {
                                        //$difficulty_level = "";
                                        $log = "' Row # ".$row_count."--".$difficulty_level."' could not be added because difficulty level is not correct.";
                                        $questionLog->addError("error-".$log);
                                    }
                                }
                                else
                                {
                                    $log = "' Row # ".$row_count."' could not be added because difficulty level is not present.";
                                    $questionLog->addError("error-".$log);
                                }

                                $image_url = "";
                                if(isset($row['image_url'] ))
                                    $image_url = $row['image_url'] ? $row['image_url']:"";

                                $average_time = "";
                                if(isset($row['average_time']))
                                    $average_time = $row['average_time'] ? $row['average_time']:"";

                                $resolution_description = "";
                                if(isset($row['resolution_description']))
                                    $resolution_description = $row['resolution_description'] ? $row['resolution_description']:"";
                                $is_correct_ans_found = 1;
                                if($question_type==2)
                                {
                                    $answer_1 = "";
                                    if(trim($row['answer_1'])!=='')
                                        $answer_1 = $row['answer_1'];

                                    $answer_2 = "";
                                    if(trim($row['answer_2'])!=='')
                                        $answer_2 = $row['answer_2'];

                                    $answer_3 = "";
                                    if(trim($row['answer_3'])!=='')
                                        $answer_3 = $row['answer_3'];

                                    $answer_4 = "";
                                    if(trim($row['answer_4'])!=='')
                                        $answer_4 = $row['answer_4'];

                                    $answer_5 = "";
                                    if(trim($row['answer_5'])!=='')
                                        $answer_5 = $row['answer_5'];


                                    $correct_answer = "";
                                    if(isset($row['correct_answer']))
                                        $correct_answer = $row['correct_answer'] ? $row['correct_answer']:"";
                                    else
                                    {
                                        $log = "' Row # ".$row_count."' could not be added because correct answer is not present.";
                                        $questionLog->addError("error-".$log);
                                    }
                                    
                                    if($correct_answer)
                                    {
                                        if($correct_answer=="A")
                                        {
                                            if($answer_1==="")
                                            {
                                                $log = "' Row # ".$row_count."' could not be added because correct answer is not present.";
                                                $questionLog->addError("error-".$log);
                                                $is_correct_ans_found = 0;
                                            } 
                                        }
                                        if($correct_answer=="B")
                                        {
                                            if($answer_2==="")
                                            {
                                                $log = "' Row # ".$row_count."' could not be added because correct answer is not present.";
                                                $questionLog->addError("error-".$log);
                                                $is_correct_ans_found = 0;
                                            } 
                                        }
                                        if($correct_answer=="C")
                                        {
                                            if($answer_3==="")
                                            {
                                                $log = "' Row # ".$row_count."' could not be added because correct answer is not present.";
                                                $questionLog->addError("error-".$log);
                                                $is_correct_ans_found = 0;
                                            } 
                                        }
                                        if($correct_answer=="D")
                                        {
                                            if($answer_4==="")
                                            {
                                                $log = "' Row # ".$row_count."' could not be added because correct answer is not present.";
                                                $questionLog->addError("error-".$log);
                                                $is_correct_ans_found = 0;
                                            } 
                                        }
                                        if($correct_answer=="E")
                                        {
                                            if($answer_5==="")
                                            {
                                                $log = "' Row # ".$row_count."' could not be added because correct answer is not present.";
                                                $questionLog->addError("error-".$log);
                                                $is_correct_ans_found = 0;
                                            } 
                                        }
                                    }
                                }
                                $qst_id = 0;
                                $question =  str_replace("\n","<br>",$question);                                
                                $section_id = \App\Helpers\Helper::get_section_id($section_name, $request->testid);

                                if(!$section_id)
                                {
                                    $log = "' Row # ".$row_count."' could not be added because section is not present.";
                                    $questionLog->addError("error-".$log);
                                }
                                else
                                {
                                    try 
                                    {  
                                        $check_qst = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
                                        ->leftjoin("test_section_mappings", "section_questions.section_id", "=", "test_section_mappings.section_id")
                                        ->where("questions.question", $question)
                                        ->where("section_questions.section_id", $section_id)
                                        ->where("questions.is_active", 1)
                                        ->select('section_questions.question_id as id')
                                        ->first();
                                    }
                                    catch(\Illuminate\Database\QueryException $ex){ 

                                        $log = "' Row # ".$row_count."' could not be added.";
                                        $questionLog->addError($ex->getMessage()."-error-".$log);    
                                      
                                    }
                                    if($check_qst)
                                    {
                                        $qst_id = $check_qst['id'];
                                    }   
                                    else
                                    {
                                        if(!empty($category)  && !empty($question_type)  && !empty($difficulty_level) && !empty($is_correct_ans_found))
                                        {
                                            
                                            $qst = new Question;
                                            $qst->category_id = \App\Helpers\Helper::get_category_type_id($section_name);
                                            $qst->excel_category_id = $category;
                                            $qst->question_type_id = $question_type;
                                            $qst->question = $question;
                                            $qst->difficulty_level = $difficulty_level;
                                            $qst->average_time = $average_time;
                                            $qst->image_url = $image_url;
                                            $qst->image_placement = 1;
                                            $qst->resolution_desc = $resolution_description;
                                            $qst->is_active = 1;
                                            if($qst->save())
                                            {
                                                $qst_id = $qst->id;
                                            } 
                                        }
                                    }                                       

                                    if($qst_id)
                                    {
                                        if($question_type == 2)
                                        {
                                            $check_answers = Answer::where("question_id", $qst_id)->get();
                                            if(!count($check_answers))
                                            {
                                                if($answer_1!=="")
                                                {
                                                    $ans1 = new Answer;
                                                    $ans1->question_id = $qst_id;
                                                    $ans1->answer = $answer_1;
                                                    $ans1->answer_id = "one";
                                                    if($correct_answer=="A")
                                                        $ans1->is_correct = 1;
                                                    else
                                                        $ans1->is_correct = 0;
                                                    $ans1->save();
                                                }
                                                if($answer_2!=="")
                                                {
                                                    $ans2 = new Answer;
                                                    $ans2->question_id = $qst_id;
                                                    $ans2->answer = $answer_2;
                                                    $ans2->answer_id = "two";
                                                    if($correct_answer=="B")
                                                        $ans2->is_correct = 1;
                                                    else
                                                        $ans2->is_correct = 0;                    
                                                    $ans2->save();
                                                }
                                                if($answer_3!=="")
                                                {
                                                    $ans3 = new Answer;
                                                    $ans3->question_id = $qst_id;
                                                    $ans3->answer = $answer_3;
                                                    $ans3->answer_id = "three";
                                                    if($correct_answer=="C")
                                                        $ans3->is_correct = 1;
                                                    else
                                                        $ans3->is_correct = 0;
                                                    $ans3->save();
                                                }
                                                if($answer_4!=="")
                                                {
                                                    $ans4 = new Answer;
                                                    $ans4->question_id = $qst_id;
                                                    $ans4->answer = $answer_4;
                                                    $ans4->answer_id = "four";
                                                    if($correct_answer=="D")
                                                        $ans4->is_correct = 1;
                                                    else
                                                        $ans4->is_correct = 0;
                                                    $ans4->save();
                                                }
                                                if($answer_5!=="")
                                                {
                                                    $ans5 = new Answer;
                                                    $ans5->question_id = $qst_id;
                                                    $ans5->answer = $answer_5;
                                                    $ans5->answer_id = "five";
                                                    if($correct_answer=="E")
                                                        $ans5->is_correct = 1;
                                                    else
                                                        $ans5->is_correct = 0;
                                                    $ans5->save();
                                                }
                                            }
                                        }
                                        $check_section_question = Section_question::where("section_id", $section_id)->where("question_id", $qst_id)->first();
                                        if(!$check_section_question)
                                        {
                                            $section_qst = new Section_question;
                                            $section_qst->section_id = $section_id;
                                            $section_qst->question_id = $qst_id;
                                            $section_qst->is_active = 1;
                                            $section_qst->save();
                                        }
                                    }
                                }
                            }
                            else
                            {
                                $log = "Row # ".$row_count." Section is not present in your excel file.";
                                $questionLog->addError("error-".$log);
                            }
                        }
                        else
                        {
                            if(!empty($section_name))
                            {
                                $log = "Row # ".$row_count." question is not present in your excel file.";
                                $questionLog->addError("error-".$log);
                            }
                        }
                    }

                    $fileName = "";
                    $images = $request->file('bulk_excel');
                    $fileName = $file_name."-".date('Ymdhis').'.'.$extension;
                    $images->move(base_path().'/public/test_excel/', $fileName);
                    
                    $array_log_qst = Test::find($request->testid); 
                    $array_log_qst->logs = $question_log;
                    $array_log_qst->is_bulk_uploaded = 1;
                    $array_log_qst->fileName = $fileName;
                    $array_log_qst->save();
                /*}
                else
                {
                    flash('Uploaded excel is not in correct format.')->error();
                    $error = "false";
                }*/
                 
                });
                if($error=="true")
                    return redirect("get_log/".$request->testid);
                else
                    return redirect()->back();
           }
           else
           {
                flash('Please choose files with "xls" or "xlxs" extentions only.')->error();
                return redirect()->back();
           }
        }
        else
        {
            flash('Please fill the form correctly.')->error();
            return redirect()->back();
        }
    }


    public function get_log($id)
    {
        if($id)
        {
            $log = Test::find($id);
            return view('tests.bulk_result', ['log' => $log]);
        }
    }
}
