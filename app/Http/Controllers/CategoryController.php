<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
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
        $category = Category::orderBy("id", "DESC")->get();
        return view('categories.index', ['category' => $category]);
    }

    public function add()
    {
        return view('categories.add');
    }
    
    public function insert(Request $request)
    {
        $request->validate([
            'category' => 'required|string|unique:categories'
        ]);
        $cat = new Category;
        $cat->category = $request->category;
        $cat->is_active = 1;
        if($cat->save())
        {
            flash('Category has been added successfully.')->success();
            return redirect('categories'); 
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
            $category = Category::find($id);
            return view('categories.edit', ['category' => $category]);
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
            'category' => 'required|string|unique:categories'
        ]);
        if($request->id)
        {
            $cat = Category::find($request->id);
            $cat->category = $request->category;
            if($cat->save())
            {
                flash('Category has been updated successfully.')->success();
                return redirect('categories'); 
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
