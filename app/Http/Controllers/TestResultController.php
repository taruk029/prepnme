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
use App\Wpaj_user;
use App\User_taken_section;
use DB;
use Excel;
use Mail;

class TestResultController extends Controller
{
    public function index()
    {
        $tests = User_taken_section::leftjoin("wpaj_users", "user_taken_sections.user_id", "=", "wpaj_users.ID")
        ->leftjoin("tests", "user_taken_sections.test_id", "=", "tests.id")
        ->select('wpaj_users.user_login', 'wpaj_users.user_email', 'tests.test_name', 'tests.id as test_id', 'user_taken_sections.user_id as user_id', 'user_taken_sections.created_at')
        ->where("user_taken_sections.status", 2)
        ->groupby("user_taken_sections.user_id", "user_taken_sections.test_id")
        ->orderBy("user_taken_sections.id", "DESC")
        ->get();
        return view('result.index', ['tests' => $tests]);
    }
    
    
    public function test_email()
    {
        $email_data['to'] = "taru.kanthra029@hotmail.com";
        Mail::send('emails.test_mail', $email_data, function($message) use ($email_data) 
        {
            $message->to($email_data['to'], 'Essay Question Answer')->subject
            ("Essay Question Answer");
            $message->from('admin@prepnme.com','PrepNMe');
        });
           
    }
}
