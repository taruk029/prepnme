<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Section;
use App\Test_section_mapping;
use App\Test;
use DB;

class SectionController extends Controller
{
   public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sections = Test_section_mapping::leftjoin("sections", "test_section_mappings.section_id", "=", "sections.id")
        ->leftjoin("tests", "test_section_mappings.test_id", "=", "tests.id")
        ->select('sections.*', DB::raw('(CASE WHEN difficulty_level = 1 THEN "EASY" WHEN difficulty_level = 2 THEN "MEDIUM" WHEN difficulty_level = 3 THEN "HARD" ELSE "EASY" END) AS difficulty_level'), 'tests.test_name')
        ->orderBy("id", "DESC")
        ->get();
        return view('sections.index', ['sections' => $sections]);
    }

    public function add()
    {
        return view('sections.add');
    }

    public function insert(Request $request)
    {
        $request->validate([
            'section' => 'required|string|unique:sections|max:255',
            'duration_in_mins' => 'required|numeric',
            'difficulty_level' => 'required'
        ]);
        $section = new Section;
        $section->section = $request->section;
        $section->duration_in_mins = $request->duration_in_mins;
        $section->difficulty_level = $request->difficulty_level;
        $section->description = $request->description;
        $section->is_active = 1;
        if($section->save())
        {
            flash('Section has been added successfully.')->success();
            return redirect('sections'); 
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
            $section = Section::find($id);
            return view('sections.edit', ['section' => $section]);
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
            'section' => 'required|string|max:255',
            'duration_in_mins' => 'required|numeric',
            'difficulty_level' => 'required'
        ]);
        if($request->id)
        {
            $section = Section::find($request->id);
            $section->section = $request->section;
            $section->duration_in_mins = $request->duration_in_mins;
            $section->difficulty_level = $request->difficulty_level;
            $section->description = $request->description;
            if($section->save())
            {
                flash('Section has been updated successfully.')->success();
                return redirect('sections'); 
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
