<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Test;
use App\Section;
use App\Test_section_mapping;
use DB;

class TestSectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $tests = Test_section_mapping::leftjoin("tests", "test_section_mappings.test_id", "=", "tests.id")
        ->select('test_section_mappings.*', 'tests.test_name')
        ->where('tests.is_active',1)
        ->groupBy('test_section_mappings.test_id')
        ->orderBy('tests.test_name')
        ->get();
        return view('test_sections.index', ['tests' => $tests]);
    }


    public function add()
    {
    	$sections = Section::orderBy("section", "ASC")->get();
    	$section_tests_array = array();
    	$section_tests = Test_section_mapping::select('test_section_mappings.test_id')
    	->groupBy('test_id')
    	->get();
		if(count($section_tests))
		{
			foreach ($section_tests as $row) 
			{
			  array_push($section_tests_array, $row->test_id);
			}
		}
    	$tests = Test::select('id', 'test_name')
    	->whereNotIn('id', $section_tests_array)
    	->orderBy("test_name", "ASC")
        ->get();
        return view('test_sections.add', ['sections' => $sections, 'tests' => $tests]);
    }


    public function insert(Request $request)
    {
        $request->validate([
            'test' => 'required'
        ]);

        if($request->section)
        {
        	foreach ($request->section as $rows) 
        	{
        		$section = new Test_section_mapping;
		        $section->test_id = $request->test;
		        $section->section_id = $rows;
		        $section->is_active = 1;
		        $section->save();
        	}
        	
	        flash('Section has been assigned successfully.')->success();
	        return redirect('tests_sections');
        }        
        else
        {
            flash('Please select the sections correctly.')->error();
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if($id)
        {
            $sections = Section::orderBy("section", "ASC")->get();
	    	$tests = Test::select('id', 'test_name')
	    	->where('id', $id)
	        ->get();
	        $section_tests_array = array();
	        $section_tests = Test_section_mapping::select('section_id')
	        ->where('test_id', $id)
	    	->get();
	    	if(count($section_tests))
			{
				foreach ($section_tests as $row) 
				{
				  array_push($section_tests_array, $row->section_id);
				}
			}
	        return view('test_sections.edit', ['sections' => $sections, 'tests' => $tests, 'section_tests_array' => $section_tests_array]);
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
            'test' => 'required'
        ]);
        if($request->section)
        {
        	$section_tests_array = array();
        	$difference = array();

        	$check_test_section = Test_section_mapping::select('section_id')
	        ->where('test_id', $request->test)
	    	->get();

	    	if(count($check_test_section))
			{
				foreach ($check_test_section as $row) 
				{
				  array_push($section_tests_array, $row->section_id);
				}
			}
			
			/* Deleting Unchecked Sections */
			$difference = array_diff($section_tests_array,$request->section);
			if(count($difference))
			{
				foreach ($difference as $diif_row) 
        		{
        			DB::table('test_section_mappings')
        			->where('test_id', $request->test)
        			->where('section_id', $diif_row)
        			->delete();
        		}
			}

			/* Inserting New Checked Sections in not present */
        	foreach ($request->section as $rows) 
        	{
        		if(!in_array($rows, $section_tests_array))
        		{
	        		$section = new Test_section_mapping;
			        $section->test_id = $request->test;
			        $section->section_id = $rows;
			        $section->is_active = 1;
			        $section->save();
		    	}
        	}
        	
	        flash('Section assignment has been updated successfully.')->success();
	        return redirect('tests_sections');
        }        
        else
        {
            flash('Please select the sections correctly.')->error();
            return redirect()->back();
        }
    }
}
