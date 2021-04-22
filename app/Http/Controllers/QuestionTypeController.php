<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question_type;

class QuestionTypeController extends Controller
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
        $question_types = Question_type::orderBy("id", "DESC")->paginate(10);
        return view('question_types.index', ['question_types' => $question_types]);
    }

    public function add()
    {
        return view('question_types.add');
    }

    public function insert(Request $request)
    {
        $request->validate([
            'question_type' => 'required|string|unique:question_types'
        ]);
        $qt = new Question_type;
        $qt->question_type = $request->question_type;
        $qt->is_active = 1;
        if($qt->save())
        {
            flash('Question type has been added successfully.')->success();
            return redirect('question_types'); 
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
            $question_type = Question_type::find($id);
            return view('question_types.edit', ['question_type' => $question_type]);
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
            'question_type' => 'required|string|unique:question_types'
        ]);
        if($request->id)
        {
            $qt = Question_type::find($request->id);
            $qt->question_type = $request->question_type;
            if($qt->save())
            {
                flash('Question type has been updated successfully.')->success();
                return redirect('question_types'); 
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
}
