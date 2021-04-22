<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section_question;
use App\Section;
use App\Question_type;
use App\Question;
use App\Category;
use DB;

class SectionQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sections = Section_question::leftjoin("sections", "section_questions.section_id", "=", "sections.id")
        ->leftjoin("test_section_mappings", "test_section_mappings.section_id", "=", "sections.id")
        ->leftjoin("tests", "test_section_mappings.test_id", "=", "tests.id")
        ->select('sections.id','sections.section','test_section_mappings.test_id','tests.test_name')
        ->groupBy("sections.id")
        ->where('tests.is_active',1)
        ->orderBy("sections.section", "ASC")
        ->get();

        return view('sections_question.index', ['sections' => $sections]);
    }

    public function add()
    {
    	$section_question_array = array();
    	$section_questions = Section_question::select('section_id')
    	->groupBy('section_id')
    	->get();
		if(count($section_questions))
		{
			foreach ($section_questions as $row) 
			{
			  array_push($section_question_array, $row->section_id);
			}
		}

        $sections = Section::select('sections.id','sections.section')
        ->whereNotIn('id', $section_question_array)
        ->orderBy("sections.section", "ASC")
        ->get();
        $category = Category::orderBy("category", "ASC")->get();

        return view('sections_question.add', ['sections' => $sections, 'category' => $category]);
    }

    public function get_questions(Request $request)
    {
         $sub = Question::where('excel_category_id', $request->id)
            ->select('id', 'question', 'difficulty_level')
            ->orderBy('question', 'ASC')
            ->get();
            $data = array();
        for($i=0;$i<count($sub);$i++){
           $data[] = array('id'=>$sub[$i]->id,'question'=>$sub[$i]->question,'difficulty_level'=>$sub[$i]->difficulty_level);
        }
        $output  = $data;
        echo json_encode($output);
    }

    public function get_section_questions(Request $request)
    {
         $sub = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
         	->where('section_id', $request->id)
            ->select('questions.question')
            ->orderBy('questions.question', 'ASC')
            ->get();
            $data = array();
        for($i=0;$i<count($sub);$i++){
           $data[] = array('question'=>$sub[$i]->question);
        }
        $output  = $data;
        echo json_encode($output);
    }

    public function insert(Request $request)
    {
        $request->validate([
            'sections' => 'required'
        ]);
        if(!empty($request->question_ids))
        {
        	$qst_ids = explode(",", $request->question_ids);
        	if($qst_ids)
        	{
	        	foreach($qst_ids as $rows)
	        	{
		        	$section_qst = new Section_question;
			        $section_qst->section_id = $request->sections;
			        $section_qst->question_id = $rows;
			        $section_qst->is_active = 1;
			        $section_qst->save();
		    	}
		        flash('Questions have been assigned to section successfully.')->success();
		        return redirect('section_questions'); 
	    	}
        }
        else
        {
        	flash('Please select the questions for section.')->error();
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if($id)
        {
	    	$sections = Section::select('sections.id','sections.section')
	        ->where('id', $id)
	        ->get();
            
            $sub = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
            ->where('section_id', $id)
            ->select('questions.question', 'questions.id')
            ->orderBy('questions.question', 'ASC')
            ->get();

            $category = Category::orderBy("category", "ASC")->get();
            return view('sections_question.edit', ['sections' => $sections, 'sub' => $sub,'category' => $category]);
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
            'sections' => 'required'
        ]);
        if(!empty($request->question_ids))
        {
            $old_questions = array();
            $diff_qst_ids = array();

            $check_question = Section_question::select('question_id')->where('section_id', $request->sections)->get();

            foreach($check_question as $rows_qst)
            {
                array_push($old_questions, $rows_qst->question_id);
            }

            $qst_ids = explode(",", $request->question_ids);

            $diff_qst_ids  = array_diff($old_questions, $qst_ids);
            
            foreach($diff_qst_ids as $row_diff)
            {
                Section_question::where('section_id', $request->sections)
                ->where('question_id', $row_diff)
                ->delete();
            }

            if($qst_ids)
            {
                foreach($qst_ids as $rows)
                {
                    $check_question = Section_question::where('section_id', $request->sections)
                    ->where('question_id', $rows)
                    ->first();
                    if(!$check_question)
                    {
                        $section_qst = new Section_question;
                        $section_qst->section_id = $request->sections;
                        $section_qst->question_id = $rows;
                        $section_qst->is_active = 1;
                        $section_qst->save();
                    }
                }
                flash('Questions have been updated to section successfully.')->success();
                return redirect('section_questions'); 
            }
        }
        else
        {
            flash('Please select the questions for section.')->error();
            return redirect()->back();
        }
    }

}
