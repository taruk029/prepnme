<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question_type;
use App\Question;
use App\Category;
use App\Answer;
use App\Test_section_mapping;
use App\Section;
use App\Section_question;
use App\User_test_answer;
use App\Test;
use DB;

class QuestionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $question_types = Question_type::orderBy("question_type", "ASC")->get();
        $questions = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
        ->leftjoin("sections", "section_questions.section_id", "=", "sections.id")
        ->leftjoin("test_section_mappings", "section_questions.section_id", "=", "test_section_mappings.section_id")
        ->leftjoin("tests", "test_section_mappings.test_id", "=", "tests.id")
        ->leftjoin("categories", "questions.excel_category_id", "=", "categories.id")
        ->leftjoin("question_types", "questions.question_type_id", "=", "question_types.id")
        ->select('questions.id as id', 'categories.category', 'question_types.question_type', 'questions.question', 'questions.average_time', 'questions.is_active as is_active',
            DB::raw('(CASE WHEN questions.difficulty_level = 1 THEN "EASY" WHEN questions.difficulty_level = 2 THEN "MEDIUM" WHEN questions.difficulty_level = 3 THEN "HARD" ELSE "EASY" END) AS difficulty_level'), 'tests.test_name', 'sections.section')
        ->where("questions.is_active",1)
        ->orderBy("id", "DESC")
        ->get();
        return view('questions.index', ['question_types' => $question_types, 'questions' => $questions]);
    }


    public function add()
    {
        $question_types = Question_type::orderBy("question_type", "ASC")->get();
        $category = Category::orderBy("category", "ASC")->get();
        return view('questions.add', ['question_types' => $question_types, 'category' => $category]);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'question_type' => 'required',
            'difficulty_level' => 'required',
            'category' => 'required',
            'question' => 'required|string|unique:questions'
        ]);

        $image_url = "";
        $images_fileName = "";
        $place_image = 0;
        if($request->hasFile('images'))
        {
            $images = $request->file('images');
            $images_fileName = pathinfo($images->getClientOriginalName(), PATHINFO_FILENAME)."-".date('Ymdhis').'.'.$images->getClientOriginalExtension();
            $images->move(base_path().'/public/question_picture/', $images_fileName);
            $image_url = url('/')."/public/question_picture/".$images_fileName;
            $place_image = $request->place_image;
        }

        $qst = new Question;
        $qst->excel_category_id = $request->category;
        $qst->question_type_id = $request->question_type;
        $qst->question = $request->question;
        $qst->difficulty_level = $request->difficulty_level;
        $qst->average_time = $request->average_time;
        $qst->image = $images_fileName;
        $qst->image_url = $image_url;
        $qst->image_placement = $place_image;
        $qst->resolution_desc = $request->description;
        $qst->is_active = 1;
        if($qst->save())
        {
            if($request->question_type==2)
            {
                if(!empty($request->one))
                {
                    $ans1 = new Answer;
                    $ans1->question_id = $qst->id;
                    $ans1->answer = $request->one;
                    $ans1->answer_id = "one";
                    if($request->correct_answer=="one")
                        $ans1->is_correct = 1;
                    else
                        $ans1->is_correct = 0;
                    $ans1->save();
                }
                if(!empty($request->two))
                {
                    $ans2 = new Answer;
                    $ans2->question_id = $qst->id;
                    $ans2->answer = $request->two;
                    $ans2->answer_id = "two";
                    if($request->correct_answer=="two")
                        $ans2->is_correct = 1;
                    else
                        $ans2->is_correct = 0;                    
                    $ans2->save();
                }
                if(!empty($request->three))
                {
                    $ans3 = new Answer;
                    $ans3->question_id = $qst->id;
                    $ans3->answer = $request->three;
                    $ans3->answer_id = "three";
                    if($request->correct_answer=="three")
                        $ans3->is_correct = 1;
                    else
                        $ans3->is_correct = 0;
                    $ans3->save();
                }
                if(!empty($request->four))
                {
                    $ans4 = new Answer;
                    $ans4->question_id = $qst->id;
                    $ans4->answer = $request->four;
                    $ans4->answer_id = "four";
                    if($request->correct_answer=="four")
                        $ans4->is_correct = 1;
                    else
                        $ans4->is_correct = 0;
                    $ans4->save();
                }
                if(!empty($request->five))
                {
                    $ans5 = new Answer;
                    $ans5->question_id = $qst->id;
                    $ans5->answer = $request->five;
                    $ans5->answer_id = "five";
                    if($request->correct_answer=="five")
                        $ans5->is_correct = 1;
                    else
                        $ans5->is_correct = 0;
                    $ans5->save();
                }
            }
            flash('Question has been added successfully.')->success();
            return redirect('questions'); 
        }
        else
        {
            flash('Please fill the form correctly.')->error();
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if($id)
        {
            $questions = Question::find($id);
            $answers = Answer::where('question_id', $id)->get();
            $question_types = Question_type::orderBy("question_type", "ASC")->get();
            $category = Category::orderBy("category", "ASC")->get();
            return view('questions.edit', ['questions' => $questions, 'answers' => $answers, 'question_types' => $question_types, 'category' => $category ]);
        }
        else
        {
            flash('Something went wrong. Please try again.')->error();
            return redirect()->back();
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'question_type' => 'required',
            'difficulty_level' => 'required',
            'category' => 'required',
            'question' => 'required|string'
        ]);

        if($request->id)
        {
            $qst = Question::find($request->id);
            $image_url = "";
            $images_fileName = "";
            $place_image = 0;
            if($request->hasFile('images'))
            {
                if(!empty($qst->image))
                {
                    $old_file = base_path().'/public/question_picture/'.$qst->image;
                    if(file_exists($old_file))
                    {
                        unlink($old_file);
                    }
                }

                $images = $request->file('images');
                $images_fileName = pathinfo($images->getClientOriginalName(), PATHINFO_FILENAME)."-".date('Ymdhis').'.'.$images->getClientOriginalExtension();
                $images->move(base_path().'/public/question_picture/', $images_fileName);
                $image_url = url('/')."/public/question_picture/".$images_fileName;
                $place_image = $request->place_image;
            }
            
            $qst->excel_category_id = $request->category;
            $qst->question_type_id = $request->question_type;
            $qst->question = $request->question;
            $qst->difficulty_level = $request->difficulty_level;
            $qst->average_time = $request->average_time;
            $qst->image = $images_fileName;
            $qst->image_url = $image_url;
            $qst->image_placement = $place_image;
            $qst->resolution_desc = $request->description;
            $qst->is_active = 1;
            if($qst->save())
            {
                if($request->question_type==2)
                {
                    if(!empty($request->one))
                    {
                        $ans1 = Answer::where('question_id', $request->id)
                        ->where('answer_id', "one")
                        ->first();

                        $ans1->answer = $request->one;
                        if($request->correct_answer=="one")
                            $ans1->is_correct = 1;
                        else
                            $ans1->is_correct = 0;
                        $ans1->save();
                    }
                    if(!empty($request->two))
                    {
                        $ans2 = Answer::where('question_id', $request->id)
                        ->where('answer_id', "two")
                        ->first();

                        $ans2->answer = $request->two;
                        if($request->correct_answer=="two")
                            $ans2->is_correct = 1;
                        else
                            $ans2->is_correct = 0;
                        $ans2->save();
                    }
                    if(!empty($request->three))
                    {
                        $ans3 = Answer::where('question_id', $request->id)
                        ->where('answer_id', "three")
                        ->first();

                        $ans3->answer = $request->three;
                        if($request->correct_answer=="three")
                            $ans3->is_correct = 1;
                        else
                            $ans3->is_correct = 0;
                        $ans3->save();
                    }
                    if(!empty($request->four))
                    {
                        $ans4 = Answer::where('question_id', $request->id)
                        ->where('answer_id', "four")
                        ->first();

                        $ans4->answer = $request->four;
                        if($request->correct_answer=="four")
                            $ans4->is_correct = 1;
                        else
                            $ans4->is_correct = 0;
                        $ans4->save();
                    }
                    if(!empty($request->five))
                    {
                        $ans5 = Answer::where('question_id', $request->id)
                        ->where('answer_id', "five")
                        ->first();

                        $ans5->answer = $request->five;
                        if($request->correct_answer=="five")
                            $ans5->is_correct = 1;
                        else
                            $ans5->is_correct = 0;
                        $ans5->save();
                    }
                }
            }
            flash('Question has been updated successfully.')->success();
            return redirect('questions'); 
        } 
        else
        {
            flash('Something went wrong. Please try again.')->error();
            return redirect()->back();
        }  
    }

    public function delete($id)
    {
        if($id)
        {
            $check_user_test_qst = User_test_answer::where("question_id",$id)->get();
            if($check_user_test_qst)
            {
                $check_qst = Question::find($id);
                if($check_qst)
                {
                    $check_qst->is_active = 0;
                    $check_qst->save();
                }
            }
            else
            {
                $check_qst = Question::find($id);
                if($check_qst)
                {
                    DB::table('questions')->delete($id);
                }
                $check_sec_qst = Section_question::where("question_id",$id)->get();
                if($check_sec_qst)
                {
                    foreach ($check_sec_qst as $key) {
                        DB::table('section_questions')->delete($key->id);
                    }
                    
                }
                $check_user_test_qst = User_test_answer::where("question_id",$id)->get();
                if($check_user_test_qst)
                {
                    foreach ($check_user_test_qst as $row) {
                        DB::table('user_test_answers')->delete($row->id);
                    }
                    
                }
            }
            flash('Question has been deleted successfully.')->success();
            return redirect('questions'); 
        }
        else
        {
            flash('Something went wrong. Please try again.')->error();
            return redirect()->back();
        }
    }
}
