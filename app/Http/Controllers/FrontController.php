<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Wpaj_user;
use Redirect;
use MikeMcLin\WpPassword\Facades\WpPassword;

class FrontController extends Controller
{

    public function index()
    {
        if(empty(Session::has('loggedin_user_id')))
        {
            return redirect()->to('login_user')->send();
        }
        else
        {
            return view('front.home');            
        }
    }
    
    public function login_user()
    {
        if(empty(Session::has('loggedin_user_id')))
        {
            return view('front.login_user');
        }
        else
        {
            return redirect('dashboard'); 
        }
    }
    
    public function logout_user()
        {
            Session::flush();
            setcookie ("member_login","");
            //return redirect('login_user');            
            header("Location: https://www.prepnme.com/wp-login.php?action=logout");
        }

    public function checklogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $login_type = 0;
        $check_username = Wpaj_user::where('user_email', $request->username)->first();
        if($check_username)
        {
            $login_type = 1;
        }
        else
        {
            $check_username = Wpaj_user::where('user_login', $request->username)->first();
            if($check_username)
            {
                $login_type = 1;
            }
        }

        if($login_type==1)
        {
            $check_password = WpPassword::check($request->password, $check_username->user_pass);
            if($check_password)
            {
                Session::put('loggedin_user_id', $check_username->ID);
                Session::put('user_login', $check_username->user_login);
                Session::put('user_email', $check_username->user_email);
                if(!empty($request->remember)) 
                {
                    setcookie ("member_login", $request->remember,time()+ (10 * 365 * 24 * 60 * 60));
                } 
                else 
                {
                    if(isset($_COOKIE["member_login"])) 
                    {
                        setcookie ("member_login","");
                    }
                }

                Session::flash('message', 'You are logged in successfully.');
                return redirect('dashboard');
            }
            else
            {
                Session::flash('error', 'Username or Password is wrong.');
                return redirect()->back(); 
            } 
        }
        else
        {
            Session::flash('error', 'Username or Password is wrong.');
            return redirect()->back();
        }
        
    }

    public function check_take_test($id)
    {
        if($id)
        {
            $userid_string = base64_decode($id);
            $userid_array = explode("-", $userid_string);

            if(count($userid_array)==2)
            {
                $user_id = $userid_array[1];
                $check_username = Wpaj_user::where('ID', $user_id)->first();
                if($check_username)
                {
                    $login_type = 1;
                    Session::put('loggedin_user_id', $check_username->ID);
                    Session::put('user_login', $check_username->user_login);
                    Session::put('user_email', $check_username->user_email);
                    Session::flash('message', 'You are logged in successfully.');
                    return redirect('dashboard');
                }
                else
                {
                    Session::flash('error', 'Something went wrong, Please log in again to take the test.');
                    return redirect('login_user'); 
                }

            }
            else
            {
                return redirect('login_user'); 
            }
        }
    }

    
}
