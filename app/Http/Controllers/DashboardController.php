<?php

namespace App\Http\Controllers;
set_time_limit(0);
use Illuminate\Http\Request;
use Session;
use App\Wpaj_user;
use App\Test;
use App\Section;
use App\User_taken_section;
use App\Section_question;
use App\Answer;
use App\User_test_answer;
use App\Question;
use Redirect;
use View;
use App\Test_section_mapping;
use App\Wpaj_pmpro_memberships_user;
use App\Wpaj_pmpro_membership_level;
use Mail;

class DashboardController extends Controller
{

public function index()
{
if(empty(Session::has('loggedin_user_id')))
{
	return redirect()->to('login_user')->send();
}
else
{
$user_id = 0;
$sections = array();
if(Session::has('loggedin_user_id'))
$user_id = Session::get('loggedin_user_id');

$max_id = Wpaj_pmpro_memberships_user::where('user_id', $user_id)->max('id');
if($max_id)
$membership_id = Wpaj_pmpro_memberships_user::select('membership_id')->where('id', $max_id)->first();
$tests = array();
$upgrade_membership = array();
if($membership_id)
{
	if($membership_id->membership_id==13 || $membership_id->membership_id==12 || $membership_id->membership_id==11)
	{
		if($membership_id->membership_id==13 || $membership_id->membership_id==12) 
		{
			if($membership_id->membership_id==13)
			{
				$memberships = array('11', '12', '13');
				$tests = Test::select('id', 'test_name')
				->where('is_active', 1)
				->whereIn('membership_level_id', $memberships)
				->get();
			}
			if($membership_id->membership_id==12)
			{
				$memberships = array('11', '12');
				$tests = Test::select('id', 'test_name')
				->where('is_active', 1)
				->whereIn('membership_level_id', $memberships)
				->get();				
				$upgrade_membership = Wpaj_pmpro_membership_level::where("id", 13)->get();
			}
		}
		else
		{
			$tests = Test::select('id', 'test_name')
			->where('is_active', 1)
			->where('membership_level_id', $membership_id->membership_id)
			->get();
			$upgrade_membership = Wpaj_pmpro_membership_level::whereIn("id", array('12', '13'))->get();
		}
	}
	if($membership_id->membership_id==7 || $membership_id->membership_id==8 || $membership_id->membership_id==9)
	{
		if($membership_id->membership_id==9 || $membership_id->membership_id==8) 
		{
			if($membership_id->membership_id==9)
			{
				$memberships = array('7', '8', '9');
				$tests = Test::select('id', 'test_name')
				->where('is_active', 1)
				->whereIn('membership_level_id', $memberships)
				->get();
			}
			if($membership_id->membership_id==8)
			{
				$memberships = array('7', '8');
				$tests = Test::select('id', 'test_name')
				->where('is_active', 1)
				->whereIn('membership_level_id', $memberships)
				->get();
				$upgrade_membership = Wpaj_pmpro_membership_level::where("id", 9)->get();
			}
		}
		else
		{
			$tests = Test::select('id', 'test_name')
			->where('is_active', 1)
			->where('membership_level_id', $membership_id->membership_id)
			->get();
			$upgrade_membership = Wpaj_pmpro_membership_level::whereIn("id", array('8', '9'))->get();
		}
	}
	if($membership_id->membership_id==4 || $membership_id->membership_id==5 || $membership_id->membership_id==16)
	{
		if($membership_id->membership_id==5 || $membership_id->membership_id==4) 
		{
			if($membership_id->membership_id==5)
			{
				$memberships = array('4', '5', '16');
				$tests = Test::select('id', 'test_name')
				->where('is_active', 1)
				->whereIn('membership_level_id', $memberships)
				->get();
			}
			if($membership_id->membership_id==4)
			{
				$memberships = array('4', '16');
				$tests = Test::select('id', 'test_name')
				->where('is_active', 1)
				->whereIn('membership_level_id', $memberships)
				->get();
				$upgrade_membership = Wpaj_pmpro_membership_level::where("id", 5)->get();
			}
		}
		else
		{
			$tests = Test::select('id', 'test_name')
			->where('is_active', 1)
			->where('membership_level_id', $membership_id->membership_id)
			->get();
			$upgrade_membership = Wpaj_pmpro_membership_level::whereIn("id", array('4', '5'))->get();
		}
	}
	if($membership_id->membership_id==1 || $membership_id->membership_id==2 || $membership_id->membership_id==15)
	{
		if($membership_id->membership_id==2 || $membership_id->membership_id==1) 
		{
			if($membership_id->membership_id==2)
			{
				$memberships = array('1', '2', '15');
				$tests = Test::select('id', 'test_name')
				->where('is_active', 1)
				->whereIn('membership_level_id', $memberships)
				->get();
			}
			if($membership_id->membership_id==1)
			{
				$memberships = array('1','15');
				$tests = Test::select('id', 'test_name')
				->where('is_active', 1)
				->whereIn('membership_level_id', $memberships)
				->get();
				$upgrade_membership = Wpaj_pmpro_membership_level::where("id", 2)->get();
			}
		}
		else
		{
			$tests = Test::select('id', 'test_name')
			->where('is_active', 1)
			->where('membership_level_id', $membership_id->membership_id)
			->get();
			$upgrade_membership = Wpaj_pmpro_membership_level::whereIn("id", array('1', '2'))->get();
		}
	}

	$test_ids = array();
	foreach($tests as $rows)
	{
		array_push($test_ids, $rows->id);
	}

	if($test_ids)
	{
		foreach($test_ids as $rowst)
		{
			$sections = Test_section_mapping::leftjoin("sections", "test_section_mappings.section_id", "=", "sections.id")
			->select('test_section_mappings.test_id', 'sections.id as id', 'sections.section', 'sections.duration_in_mins')
			->whereIn('test_id', $test_ids)
			->orderBy('sections.section', 'ASC')
			->get(); 
		}
	}
} 
return view('front.dashboard.home', ['user_id'=> $user_id, 'tests'=> $tests, 'sections' =>$sections, 'upgrade_membership' =>$upgrade_membership]); 
} 
}

public function usertest($userid, $testid, $sectionid, $qstid)
{
	if(empty(Session::has('loggedin_user_id')))
	{
		return redirect()->to('login_user')->send();
	}
	else
	{
	if(!empty($userid) && !empty($testid) && !empty($sectionid))
	{
		$user_id = base64_decode($userid);
		$test_id = base64_decode($testid);
		$section_id = base64_decode($sectionid);

		$remaining_time_mins = 0;
		$remaining_time_secs = 0;
		$taken_test_id = 0;
		$check_taken_test = User_taken_section::where('user_id', $user_id)
		->where('test_id', $test_id)
		->where('section_id', $section_id)
		->whereIn('status', [0,1])
		->first();

		$sec_qst = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
		->where('section_questions.section_id', $section_id)
		->where('questions.is_active', 1)
		->get();
		if(count($sec_qst))
		{
			$section = Section::find($section_id);
			if(!$check_taken_test)
			{
				$check_taken_test_completed = User_taken_section::where('user_id', $user_id)
				->where('test_id', $test_id)
				->where('section_id', $section_id)
				->where('status', 2)
				->first();
				//echo $check_taken_test_completed; die;
				if(!$check_taken_test_completed)
				{
					$time = new User_taken_section;
					$time->user_id = $user_id;
					$time->test_id = $test_id;
					$time->section_id = $section_id;
					$time->remaining_time_minutes = $section->duration_in_mins;
					$time->remaining_time_seconds = "00";
					$time->status = 0;
					$time->save();
					
					$count = 1;
					foreach($sec_qst as $row)
					{
						$check_qst_available = User_test_answer::where('user_id',$user_id)
						->where('section_id', $section_id)
						->where('question_id', $row->question_id)
						->first();
						if(!$check_qst_available)
						{
							$user_ans = new User_test_answer;
							$user_ans->question_count = $count;
							$user_ans->user_id = $user_id;
							$user_ans->test_id = $test_id;
							$user_ans->section_id = $section_id;
							$user_ans->question_id = $row->question_id;
							$user_ans->come_back_later = 0;
							$user_ans->save();
							$count++;
						}
					}
					//echo $time->id;
					$taken_test_id = $time->id;
					$remaining_time_mins = $section->duration_in_mins;
					if(isset($_COOKIE[$taken_test_id])) 
			        {
			        	$time = explode(':', $_COOKIE[$taken_test_id]);
			        	//print_r($time);die;
						$update_time = User_taken_section::find($taken_test_id);
						$update_time->remaining_time_minutes = $time[0];
						$update_time->remaining_time_seconds = $time[1];
						$update_time->save();
			        }
			        else
			        {
						setcookie($taken_test_id, $remaining_time_mins.":".$remaining_time_secs,time()+ (10 * 365 * 24 * 60 * 60));
			        }
		    	}
		        else
		        {
		        	return redirect('outoftime/'.$userid."/".$testid."/".$sectionid);
		        }
			} 
			else
			{
				$sec_qst = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
				->where('section_questions.section_id', $section_id)
				->where('questions.is_active', 1)
				->get();			
				
				$previous_count = $check_qst_available = User_test_answer::where('user_id',$user_id)
				->where('section_id', $section_id)
				->count();

				$count = $previous_count+1;
				foreach($sec_qst as $row)
				{
					$check_qst_available = User_test_answer::where('user_id',$user_id)
					->where('section_id', $section_id)
					->where('question_id', $row->question_id)
					->first();
					if(!$check_qst_available)
					{
						$user_ans = new User_test_answer;
						$user_ans->question_count = $count;
						$user_ans->user_id = $user_id;
						$user_ans->test_id = $test_id;
						$user_ans->section_id = $section_id;
						$user_ans->question_id = $row->question_id;
						$user_ans->come_back_later = 0;
						$user_ans->save();
						$count++;
					}
				}
				
				$taken_test_id = $check_taken_test->id;

				$check_pause_test = User_taken_section::where('user_id', $user_id)
				->where('test_id', $test_id)
				->where('section_id', $section_id)
				->where('status', 1)
				->first();
				if($check_pause_test)
				{
					$remaining_time_mins = $check_pause_test['remaining_time_minutes'];
					$remaining_time_secs =$check_pause_test['remaining_time_seconds'];
					setcookie($check_pause_test['id'], $remaining_time_mins.":".$remaining_time_secs,time()+ (10 * 365 * 24 * 60 * 60));

					$check_pause_test->status = 0;
					$check_pause_test->save();
				}
				else
				{
					if(isset($_COOKIE[$check_taken_test['id']])) 
			        {			        	
			        	$time = explode(':', $_COOKIE[$check_taken_test['id']]);
						$update_time = User_taken_section::find($check_taken_test['id']);
						if(count($time)>=2)
						{
							$update_time->remaining_time_minutes = $time[0];
							$update_time->remaining_time_seconds = $time[1];
							$remaining_time_mins = $time[0];
							$remaining_time_secs = $time[1];
						}
						else
						{
							$update_time->remaining_time_minutes = $section->duration_in_mins;
							$update_time->remaining_time_seconds = "00";
							$remaining_time_mins = $section->duration_in_mins;
							$remaining_time_secs = "00";
						}
						$update_time->save();
			        }
				}
				
			} 

			$qst_count = Section_question::where('section_id', $section_id)->count();

			$qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
			->select('questions.*', 'user_test_answers.question_id as question_id', 'user_test_answers.user_answer_id', 'user_test_answers.user_answer')
			->where('user_id', $user_id)
			->where('section_id', $section_id)
			->where('question_count', $qstid)
			->first();

			$all_qst = User_test_answer::where('user_id',$user_id)
			->where('section_id', $section_id)
			->get();

			/*dd($all_qst);die;*/
			$answers = array();
			if($qst)
			{
				$answers = Answer::where('question_id', $qst->question_id)->get();
			}

			/*$max_id = Wpaj_pmpro_memberships_user::where('user_id', $user_id)->max('id');
			if($max_id)
				$membership_id = Wpaj_pmpro_memberships_user::select('membership_id')->where('id', $max_id)->first();	

			if($membership_id)
				$membership_level = Wpaj_pmpro_membership_level::where("id", $membership_id->membership_id)->first();*/

				$test = Test::find($test_id);
			return view('front.dashboard.tests', ['test'=> $test, 'taken_test_id'=> $taken_test_id, 'test_id'=> $test_id, 'section_id'=> $section_id, 'user_id'=> $user_id, 'section' =>$section, 'remaining_time_mins' =>$remaining_time_mins, 'remaining_time_secs' =>$remaining_time_secs, 'qst' =>$qst , 'answers' =>$answers, 'qst_count' =>$qst_count, 'all_qst' =>$all_qst]);
		}
		else
		{
			Session::flash('error', 'No questions are available in this section.');
            return redirect()->back();
		} 
		}
		else
		{
			return redirect()->back();
		}
	}
	}

public function savetimer(Request $request)
{
	$id = $request->id;
	$time = explode(':', $request->time);
	$update_time = User_taken_section::find($id);
	$update_time->remaining_time_minutes = $time[0];
	$update_time->remaining_time_seconds = $time[1];
	$update_time->save();
	echo 1;
}

public function next_question(Request $request)
{
	$qst = Section_question::select('question_id')
			->where('section_id', $request->section_id)
			->get();

	$qst_array = array();
	$check_qst_array = array();
	$diff_qst_array = array();

	foreach ($qst as $value) 
	{
			array_push($qst_array, $value->question_id);
	}	

	$check_qst = User_test_answer::where("user_id", $request->user_id)->where("section_id", $request->section_id)->get();

	foreach ($check_qst as $val) 
	{
			array_push($check_qst_array, $val->question_id);
	}

	$result=array_diff($qst_array,$check_qst_array);

	foreach ($result as $valr) 
	{
			array_push($diff_qst_array, $valr);
	}

	$qst = Question::select('questions.*', 'questions.id as question_id')
			->whereIn('id', $diff_qst_array)
			->limit(1)
			->get();

	return view('front.dashboard.load_test', ['qst'=> $qst]);
}

public function come_back_later(Request $request)
{
	$user_id = $request->user_id;
	$section_id = $request->section_id;
	$question_id = $request->question_id;
	$count_id = $request->count_id;
	$qst = User_test_answer::where('user_id', $user_id)
	->where('section_id', $section_id)
	->where('question_count', $count_id)
	->where('question_id', $question_id)
	->first();
	$qst->come_back_later = 1;
	$qst->save();
	echo 1;
}
public function set_answer(Request $request)
{
	$user_id = $request->user_id;
	$section_id = $request->section_id;
	$question_id = $request->question_id;
	$answer_id = $request->answer_id;


	$is_correct = 0;
	$ans = Answer::select('id')->where('question_id', $question_id)->where('is_correct', 1)->first();
	if($ans->id == $answer_id)
		$is_correct = 1;
	else
		$is_correct = 0;

	$qst = User_test_answer::where('user_id', $user_id)
	->where('section_id', $section_id)
	->where('question_id', $question_id)
	->first();

	$qst->user_answer_id = $request->answer_id;
	$qst->is_correct = $is_correct;
	$qst->save();
	echo 1;
}

public function out_of_time($userid, $testid, $sectionid)
{
	$test_id = base64_decode($testid);
	$section_id = base64_decode($sectionid);
	$user_id = Session::get('loggedin_user_id'); 
	
	$check_user = Wpaj_user::where('ID', $user_id)->first();

	$section = Section::find($section_id);

	$tests = Test::find($test_id);

	$qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
	->where('user_test_answers.user_id', $user_id)
	->where('user_test_answers.section_id', $section_id)
	->select("questions.question", "user_test_answers.user_answer")
	->where('questions.question_type_id', 1)
	->get();


	if(count($qst))
	{
		foreach($qst as $rowess)
		{
			$email_data['to'] = "admin@prepnme.com";
			$email_data['username'] = $check_user['display_name'];
			$email_data['user_login'] = $check_user['user_login'];
            $email_data['question'] =  $rowess->question;
            $email_data['user_answer'] =  $rowess->user_answer;
            $email_data['section'] =  $section->section;
            $email_data['tests'] =  $tests->test_name;
            try {
            	
            	Mail::send('emails.essay_mail', $email_data, function($message) use ($email_data) 
	            {
	                $message->to($email_data['to'], 'Essay Question Answer')->subject
	                ("Essay Question Answer");
	                $message->from('admin@prepnme.com','PrepNMe');
	            });
            } catch (\Exception $e) {
            	$err = $e;
            }
            
		}
	}
	$check_taken_test = User_taken_section::where('user_id', $user_id)
	->where('test_id', $test_id)
	->where('section_id', $section_id)
	->whereIn('status', array('0', '1'))
	->first();

	if($check_taken_test)
	{
		$check_taken_test->remaining_time_minutes = 0;
		$check_taken_test->remaining_time_seconds = 0;
		$check_taken_test->status = 2;
		$check_taken_test->save();
	}
	
	$max_id = Wpaj_pmpro_memberships_user::where('user_id', $user_id)->max('id');
	if($max_id)
		$membership_id = Wpaj_pmpro_memberships_user::select('membership_id')->where('id', $max_id)->first();

	if($membership_id)
			$membership_level = Wpaj_pmpro_membership_level::where("id", $membership_id->membership_id)->first();

	$section = Section::find($section_id);
	return view('front.dashboard.outoftime', ['membership_level'=> $membership_level, 'section'=> $section ]);
}

public function endsection($testid, $sectionid)
{
	$test_id = base64_decode($testid);
	$section_id = base64_decode($sectionid);
	$user_id = Session::get('loggedin_user_id');

	$check_taken_test = User_taken_section::where('user_id', $user_id)
	->where('test_id', $test_id)
	->where('section_id', $section_id)
	->where('status', 0)
	->first();

	if($check_taken_test)
	{
		$check_taken_test->status = 1;
		$check_taken_test->save();
	}

	$max_id = Wpaj_pmpro_memberships_user::where('user_id', $user_id)->max('id');
	if($max_id)
		$membership_id = Wpaj_pmpro_memberships_user::select('membership_id')->where('id', $max_id)->first();

	if($membership_id)
			$membership_level = Wpaj_pmpro_membership_level::where("id", $membership_id->membership_id)->first();

	$section = Section::find($section_id);
	$tests = Test::find($test_id);
	return view('front.dashboard.end_section', ['user_id'=> $user_id, 'membership_level'=> $membership_level, 'section'=> $section, 'tests'=> $tests ]);
}


public function pauseSection($testid, $sectionid)
{
	$test_id = base64_decode($testid);
	$section_id = base64_decode($sectionid);
	$user_id = Session::get('loggedin_user_id');

	$check_taken_test = User_taken_section::where('user_id', $user_id)
	->where('test_id', $test_id)
	->where('section_id', $section_id)
	->where('status', 0)
	->first();

	if($check_taken_test)
	{
		$check_taken_test->status = 1;
		$check_taken_test->save();
	}

	$max_id = Wpaj_pmpro_memberships_user::where('user_id', $user_id)->max('id');
	if($max_id)
		$membership_id = Wpaj_pmpro_memberships_user::select('membership_id')->where('id', $max_id)->first();

	if($membership_id)
			$membership_level = Wpaj_pmpro_membership_level::where("id", $membership_id->membership_id)->first();

	$section = Section::find($section_id);
	$tests = Test::find($test_id);
	return view('front.dashboard.pause_section', ['membership_level'=> $membership_level, 'section'=> $section, 'tests'=> $tests ]);
}

public function pause($testid, $sectionid)
{
	$test_id = base64_decode($testid);
	$section_id = base64_decode($sectionid);
	$user_id = Session::get('loggedin_user_id');
	
	$check_taken_test = User_taken_section::where('user_id', $user_id)
	->where('test_id', $test_id)
	->where('section_id', $section_id)
	->where('status', 0)
	->first();

	if($check_taken_test)
	{
		$check_taken_test->status = 1;
		$check_taken_test->save();
	}
	return redirect('dashboard');
}

public function end($testid, $sectionid)
{
	$test_id = base64_decode($testid);
	$section_id = base64_decode($sectionid);
	$user_id = Session::get('loggedin_user_id');
	
	$qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
	->where('user_test_answers.user_id', $user_id)
	->where('user_test_answers.section_id', $section_id)
	->select("questions.question", "user_test_answers.user_answer")
	->where('questions.question_type_id', 1)
	->get();

	$check_user = Wpaj_user::where('ID', $user_id)->first();

	$section = Section::find($section_id);

	$tests = Test::find($test_id);
	if(count($qst))
	{
		foreach($qst as $rowess)
		{
			$email_data['to'] = "admin@prepnme.com";
			$email_data['cc'] = "omer.cheema2010@gmail.com";
			$email_data['cc'] = "cpthareja@intellemind.com";
			$email_data['username'] = $check_user['display_name'];
			$email_data['user_login'] = $check_user['user_login'];
            $email_data['question'] =  $rowess->question;
            $email_data['user_answer'] =  $rowess->user_answer;
            $email_data['section'] =  $section->section;
            $email_data['tests'] =  $tests->test_name;
            try
            {
	            Mail::send('emails.essay_mail', $email_data, function($message) use ($email_data) 
	            {
	                $message->to($email_data['to'], 'Essay Question Answer')
	                ->subject("Essay Question Answer");
	                $message->from('admin@prepnme.com','PrepNMe');
	                $message->bcc($email_data['cc']);
	            });
        	}
            catch(\Exception $e)
            {
            	$err = $e;
            }
		}
	}
	
	$check_taken_test = User_taken_section::where('user_id', $user_id)
	->where('test_id', $test_id)
	->where('section_id', $section_id)
	->whereIn('status', array('0', '1'))
	->first();

	if($check_taken_test)
	{
		$check_taken_test->status = 2;
		$check_taken_test->save();
	}
	return redirect('analysis/'.base64_encode($user_id)."/".base64_encode($test_id)."/".base64_encode(0));
}


public function save_essay(Request $request)
{
	$user_id = $request->user_id;
	$section_id = $request->section_id;
	$question_id = $request->question_id;
	$count_id = $request->count_id;
	$qst = User_test_answer::where('user_id', $user_id)
	->where('section_id', $section_id)
	->where('question_count', $count_id)
	->where('question_id', $question_id)
	->first();
	$qst->user_answer = $request->essay_ans;
	$qst->save();
	echo 1;
}
}
