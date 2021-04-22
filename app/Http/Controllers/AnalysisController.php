<?php

namespace App\Http\Controllers;

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
use App\Elementary_percentile_score;
use App\Wpaj_usermeta;
use App\Standard_deviation;
use App\Middle_upper_scaled_score;
use App\Median_score;
use App\Z_table;
use App\Elementary_total_percentile;
use Mail;
use Charts;
use DB;

class AnalysisController extends Controller
{
    public function index($userid, $testid, $sectionid)
	{
		if(empty(Session::has('loggedin_user_id')))
		{
			return redirect()->to('login_user')->send();
		}
		else
		{
			if(!empty($userid) && !empty($testid))
			{
				$user_id = base64_decode($userid);
				$test_id = base64_decode($testid);
				$section_id = base64_decode($sectionid);

				$tests = Test::find($test_id);

				$quan_scaled = 0;
                $reading_scaled = 0;
                $verbal_scaled = 0;

				$user_sections = User_taken_section::leftjoin("sections", "user_taken_sections.section_id", "=", "sections.id")
				->where("user_taken_sections.user_id", $user_id)
				->where("user_taken_sections.test_id", $test_id)
				->get();
				foreach($user_sections as $row)
				{
					if(strpos($row->section, 'Quantitative') !== false && $row->status==2) 
					{
						$quan_scaled = 1;
					}
					if(strpos($row->section, 'Verbal') !== false && $row->status==2) 
					{
						$verbal_scaled = 1;
					}
					if(strpos($row->section, 'Reading') !== false && $row->status==2) 
					{
						$reading_scaled = 1;
					}					
				}	

				$check_both_quan_sec = User_taken_section::leftjoin("sections", "user_taken_sections.section_id", "=", "sections.id")
						->where("user_taken_sections.test_id", $test_id)
						->where("user_taken_sections.user_id", $user_id)
						->where("sections.section", "Like", "%Quantitative%")
						->select("user_taken_sections.status")
						->get();
				if($check_both_quan_sec)
				{
					foreach($check_both_quan_sec as $row_both)
					{
						if($row_both->status==1)
							$quan_scaled = 0;
					}
				}	
				
				$max_id = Wpaj_pmpro_memberships_user::where('user_id', $user_id)->max('id');
				if($max_id)
				$membership_id = Wpaj_pmpro_memberships_user::select('membership_id')->where('id', $max_id)->first();

				if($membership_id)
					$membership_level = Wpaj_pmpro_membership_level::select('membership_type_id')->where("id", $membership_id->membership_id)->first();

				$grade = Wpaj_usermeta::where('user_id', $user_id)
					->where('meta_key', "mytheme_phone")
					->first();
					
				$total_questions = \App\Helpers\Helper::get_test_questions_count($test_id);

				$verbal_raw_score = 0;
				$verbal_raw_score_display = 0;
				$verbal_scaled_score = 0;
				$verbal_percentile_score = 0;
				
				$verbal_correct_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 2)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 1)
				->count();

				$verbal_wrong_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 2)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 0)
				->count();

				$verbal_raw_score = ($verbal_correct_questions*1) - ($verbal_wrong_questions*0.25);
				$verbal_raw_score_display = $verbal_raw_score;

				$quantative_raw_score = 0;
				$quantative_raw_score_display = 0;
				$quantative_scaled_score = 0;
				$quantative_percentile_score = 0;

				$quantative_correct_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 3)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 1)
				->count();

				$quantative_wrong_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 3)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 0)
				->count();

				$quantative_raw_score = ($quantative_correct_questions*1) - ($quantative_wrong_questions*0.25);
				$quantative_raw_score_display = $quantative_raw_score;

				$reading_raw_score = 0;
				$reading_raw_score_display = 0;
				$reading_scaled_score = 0;
				$reading_percentile_score = 0;
				$reading_correct_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 4)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 1)
				->count();

				$reading_wrong_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 4)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 0)
				->count();
				
				$reading_raw_score = ($reading_correct_questions*1) - ($reading_wrong_questions*0.25);
				$reading_raw_score_display = $reading_raw_score;
				$total_scaled_score = 0;
				$total_percentile_score = 0;

				if($grade['meta_value']==3 || $grade['meta_value']==4)
				{
					if($verbal_scaled==1)
					{
						$verbal_scaled_score = \App\Helpers\Helper::get_scaled_score($verbal_raw_score, 2);
						$verbal_percentile_score = Elementary_percentile_score::select('verbal')
						->where("grade_id", $grade['meta_value'])
						->where("scaled_score", round($verbal_scaled_score))
						->first();
					}				

					if($quan_scaled==1)
					{
						$quantative_scaled_score = \App\Helpers\Helper::get_scaled_score($quantative_raw_score, 3);

						$quantative_percentile_score = Elementary_percentile_score::select('quantative')
						->where("grade_id", $grade['meta_value'])
						->where("scaled_score", round($quantative_scaled_score))
						->first();
					}	

					if($reading_scaled==1)
					{
						$reading_scaled_score = \App\Helpers\Helper::get_scaled_score($reading_raw_score, 4);

						$reading_percentile_score = Elementary_percentile_score::select('reading')
						->where("grade_id", $grade['meta_value'])
						->where("scaled_score", round($reading_scaled_score))
						->first();
					}					

					$total_scaled_score = $verbal_scaled_score+$quantative_scaled_score+$reading_scaled_score;

					$total_scaled_score = round( $total_scaled_score / 10 )* 10;

					$total_percentile_score = Elementary_total_percentile::select('total')
					->where("scaled_score", $total_scaled_score)
					->first();

					if(!$total_percentile_score)
					{
						$total_percentile_score = Elementary_total_percentile::select('total')
						->where("scaled_score",  ">=", $total_scaled_score)
						->first();
					}
				}
				else
				{
					/*echo $quan_scaled;
                echo $reading_scaled;
                echo $verbal_scaled;*/
					if($verbal_raw_score!=0)
						$verbal_raw_score = round( $verbal_raw_score / 5 )* 5;

					if($quantative_raw_score!=0)
						$quantative_raw_score = round( $quantative_raw_score / 5 )* 5;

					if($reading_raw_score!=0)
						$reading_raw_score = round( $reading_raw_score / 5 )* 5;

					if($grade['meta_value']==5 || $grade['meta_value']==6 || $grade['meta_value']==7)
						$grade_type = 1;
					elseif ($grade['meta_value']==8 || $grade['meta_value']==9 || $grade['meta_value']==10 || $grade['meta_value']==11) 
						$grade_type = 2;

					$standard_deviation = Standard_deviation::where("grade", $grade['meta_value'])->first();
					$median = Median_score::where("grade", $grade['meta_value'])->first();

					if($verbal_scaled==1)
					{
						$verbal_scaled_score = \App\Helpers\Helper::get_middle_upper_scaled_score($verbal_raw_score, 2, $grade_type);
						$verbal_standard_deviation = $standard_deviation['verbal'];
						$verbal_median = $median['verbal'];
						$verbal_z = ($verbal_scaled_score - $verbal_median)/$verbal_standard_deviation;

						if($verbal_z <= -2.5)
							$verbal_z = -2.5;
						elseif ($verbal_z > 2.51) 
							$verbal_z = 2.51;

						$verbal_percentile_score = Z_table::select('percentile')
						->where("z_value", $verbal_z)
						->first();

						if(!$verbal_percentile_score)
						{
							$verbal_percentile_score = Z_table::select('percentile')
							->where("z_value",  ">=", $verbal_z)
							->first();
						}
					}

					if($quan_scaled==1)
					{
						$quantative_scaled_score = \App\Helpers\Helper::get_middle_upper_scaled_score($quantative_raw_score, 3, $grade_type);
						$quantative_standard_deviation = $standard_deviation['quantitative']; 
						$quantative_median = $median['quantitative']; 
						$quantative_z = ($quantative_scaled_score - $quantative_median)/$quantative_standard_deviation;
						
						if($quantative_z <= -2.5)
							$quantative_z = -2.5;
						elseif ($quantative_z > 2.51) 
							$quantative_z = 2.51;

						$quantative_percentile_score = Z_table::select('percentile')
						->where("z_value", $quantative_z)
						->first();

						if(!$quantative_percentile_score)
						{
							$quantative_percentile_score = Z_table::select('percentile')
							->where("z_value",  ">=", $quantative_z)
							->first();
						}
					}

					if($reading_scaled==1)
					{
						$reading_scaled_score = \App\Helpers\Helper::get_middle_upper_scaled_score($reading_raw_score, 4, $grade_type);
						$reading_standard_deviation = $standard_deviation['reading']; 
						$reading_median = $median['reading'];
						$reading_z = ($reading_scaled_score - $reading_median)/$reading_standard_deviation;
					
						if($reading_z <= -2.5)
							$reading_z = -2.5;
						elseif ($reading_z > 2.51) 
							$reading_z = 2.51;

						$reading_percentile_score = Z_table::select('percentile')
						->where("z_value", round($reading_z))
						->first();

						if(!$reading_percentile_score)
						{
							$reading_percentile_score = Z_table::select('percentile')
							->where("z_value",  ">=", $reading_z)
							->first();
						}
					}

					$total_scaled_score = $verbal_scaled_score+$quantative_scaled_score+$reading_scaled_score;

					$total_standard_deviation = $standard_deviation['total']; 

					$total_median = $median['total']; 

					$total_z = ($total_scaled_score - $total_median)/$total_standard_deviation;

					if($total_z <= -2.5)
						$total_z = -2.5;
					elseif ($total_z > 2.51) 
						$total_z = 2.51;

					$total_percentile_score = Z_table::select('percentile')
					->where("z_value", round($total_z))
					->first();

					if(!$total_percentile_score)
					{
						$total_percentile_score = Z_table::select('percentile')
						->where("z_value",  ">=", $total_z)
						->first();
					}
					/*echo $verbal_raw_score."/".$quantative_raw_score."/".$reading_raw_score;
					echo "<br>";
					echo $verbal_scaled_score."/".$quantative_scaled_score."/".$reading_scaled_score;
					echo "<br>";
					echo $verbal_standard_deviation."/".$quantative_standard_deviation."/".$reading_standard_deviation;
					echo "<br>";
					echo $verbal_median."/".$quantative_median."/".$reading_median;*/
					
				}
				$sections = Test_section_mapping::leftjoin("sections", "test_section_mappings.section_id", "=", "sections.id")
				->select('test_section_mappings.test_id', 'sections.id as id', 'sections.section', 'sections.duration_in_mins')
				->where('test_id', $test_id)
				->where('section', "NOT LIKE", "%Writing%")
				->orderBy('sections.section', 'ASC')
				->get(); 

				$categories = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
				->leftjoin("categories", "questions.excel_category_id", "=", "categories.id")
				->where("section_questions.section_id", $section_id)				
				->where("questions.is_active",1)				
				->select(DB::raw('COUNT(questions.id) as counts'), 'categories.category', 'categories.id as category_id')
				->groupBy('questions.excel_category_id')
				->get();

				$easy_correct_ans = 0;
		        $easy_wrong_ans = 0;
		        $easy_unanswered_ans = 0;

				$medium_correct_ans = 0;
		        $medium_wrong_ans = 0;
		        $medium_unanswered_ans = 0;

				$diff_correct_ans = 0;
		        $diff_wrong_ans = 0;
		        $diff_unanswered_ans = 0;

		        $res_count = 0;

				if($section_id && $section_id!=0 )
				{

			        $easy_correct_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 1)
					->where('questions.difficulty_level', 1)
					->count();

					$easy_wrong_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 0)
					->where('questions.difficulty_level', 1)
					->count();

					$easy_unanswered_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->whereNull('user_test_answers.is_correct')
					->where('questions.difficulty_level', 1)
					->count();

					if(!$easy_correct_ans && !$easy_wrong_ans)
					{
						$easy_unanswered_ans = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
						->where('questions.difficulty_level', 1)
						->where('section_questions.section_id', $section_id)
						->count();						
					}


					$medium_correct_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 1)
					->where('questions.difficulty_level', 2)
					->count();

					$medium_wrong_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 0)
					->where('questions.difficulty_level', 2)
					->count();

					$medium_unanswered_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->whereNull('user_test_answers.is_correct')
					->where('questions.difficulty_level', 2)
					->count();
					
					if(!$medium_correct_ans && !$medium_wrong_ans)
					{

						$medium_unanswered_ans = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
						->where('questions.difficulty_level', 2)
						->where('section_questions.section_id', $section_id)
						->count();
					}

					$diff_correct_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 1)
					->where('questions.difficulty_level', 3)
					->count();

					$diff_wrong_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 0)
					->where('questions.difficulty_level', 3)
					->count();

					$diff_unanswered_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->whereNull('user_test_answers.is_correct')
					->where('questions.difficulty_level', 3)
					->count();
					
					if(!$diff_correct_ans && !$diff_wrong_ans)
					{
						$diff_unanswered_ans = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
						->where('questions.difficulty_level', 3)
						->where('section_questions.section_id', $section_id)
						->count();
					}					
					$res_count = \App\Helpers\Helper::get_user_section_count($section_id, Session::get('loggedin_user_id'));
					}
				}
				return view('front.dashboard.analysis', ['test_id'=> $test_id, 'sections'=> $sections, 'easy_correct_ans'=> $easy_correct_ans, 'easy_wrong_ans'=> $easy_wrong_ans, 'easy_unanswered_ans'=> $easy_unanswered_ans, 'medium_correct_ans'=> $medium_correct_ans, 'medium_wrong_ans'=> $medium_wrong_ans, 'medium_unanswered_ans'=> $medium_unanswered_ans, 'diff_correct_ans'=> $diff_correct_ans,'diff_wrong_ans'=> $diff_wrong_ans,'diff_unanswered_ans'=> $diff_unanswered_ans, 'res_count'=> $res_count, 'user_id'=> $user_id, 'categories'=> $categories, 'verbal_scaled_score'=> $verbal_scaled_score, 'quantative_scaled_score'=> $quantative_scaled_score, 'reading_scaled_score'=> $reading_scaled_score, 'verbal_raw_score_display'=> $verbal_raw_score_display, 'verbal_raw_score'=> $verbal_raw_score, 'quantative_raw_score'=> $quantative_raw_score, 'quantative_raw_score_display'=> $quantative_raw_score_display, 'reading_raw_score_display'=> $reading_raw_score_display, 'reading_raw_score'=> $reading_raw_score, 'verbal_percentile_score'=> $verbal_percentile_score, 'quantative_percentile_score'=> $quantative_percentile_score, 'reading_percentile_score'=> $reading_percentile_score, 'tests'=> $tests, 'grade'=> $grade['meta_value'], 'total_percentile_score'=> $total_percentile_score]); 
			}
		}

public function view_result($userid, $testid, $sectionid, $qstid, $type, $values)
{
	if(empty(Session::has('loggedin_user_id')))
	{
		return redirect()->to('login_user')->send();
	}
	else
	{
	if(!empty($userid) && !empty($testid) && !empty($sectionid) && !empty($type) && !empty($values))
	{
		$user_id = base64_decode($userid);
		$test_id = base64_decode($testid);
		$section_id = base64_decode($sectionid);		
		$type_id = base64_decode($type);
		$value_id = base64_decode($values);

		$remaining_time_mins = 0;
		$remaining_time_secs = 0;
		$taken_test_id = 0;

		$check_taken_test = User_taken_section::where('user_id', $user_id)
		->where('test_id', $test_id)
		->where('section_id', $section_id)
		->where('status', 2)
		->first();

		$sec_qst = Section_question::where('section_id', $section_id)->get();

		$section = Section::find($section_id);
		$next_array = array();
		if(count($sec_qst))
		{
			if($type_id==1)
			{
				//die("here");
				$qst_count = Section_question::where('section_id', $section_id)->count();

				if($qstid==1)
				{
					$qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
						->select('questions.*', 'user_test_answers.question_id as question_id', 'user_test_answers.user_answer_id', 'user_test_answers.user_answer', 'user_test_answers.question_count')
						->where('user_test_answers.user_id', $user_id)
						->where('user_test_answers.section_id', $section_id)
						->where('questions.difficulty_level', $value_id)
						->first();
				}
				else
				{	
					$qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
						->select('questions.*', 'user_test_answers.question_id as question_id', 'user_test_answers.user_answer_id', 'user_test_answers.user_answer', 'user_test_answers.question_count')
						->where('user_test_answers.user_id', $user_id)
						->where('user_test_answers.section_id', $section_id)
						->where('user_test_answers.question_count', $qstid)
						->first();
				}

				$all_qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where('user_test_answers.user_id',$user_id)
				->where('user_test_answers.section_id', $section_id)
				->where('questions.difficulty_level', $value_id)
				->get();

				foreach ($all_qst as $row) 
				{
					array_push($next_array, $row->question_count);
				}

				$answers = array();
				if($qst)
				{
					$answers = Answer::where('question_id', $qst->question_id)->get();
				}			
			}
			elseif($type_id==2)
			{
				//die("there");
				$qst_count = Section_question::where('section_id', $section_id)->count();

				if($qstid==1)
				{
					$qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
						->select('questions.*', 'user_test_answers.question_id as question_id', 'user_test_answers.user_answer_id', 'user_test_answers.user_answer')
						->where('user_test_answers.user_id', $user_id)
						->where('user_test_answers.section_id', $section_id)
						->where('questions.excel_category_id', $value_id)
						->first();
				}
				else
				{
					$qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
						->select('questions.*', 'user_test_answers.question_id as question_id', 'user_test_answers.user_answer_id', 'user_test_answers.user_answer')
						->where('user_test_answers.user_id', $user_id)
						->where('user_test_answers.section_id', $section_id)
						->where('user_test_answers.question_count', $qstid)
						->first();
				}
				

				$all_qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where('user_test_answers.user_id',$user_id)
				->where('user_test_answers.section_id', $section_id)
				->where('questions.excel_category_id', $value_id)
				->get();

				foreach ($all_qst as $row) 
				{
					array_push($next_array, $row->question_count);
				}

				$answers = array();
				if($qst)
				{
					$answers = Answer::where('question_id', $qst->question_id)->get();
				}
			}
			else
			{
				//die("there");
				$qst_count = Section_question::where('section_id', $section_id)->count();

				$qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->select('questions.*', 'user_test_answers.question_id as question_id', 'user_test_answers.user_answer_id', 'user_test_answers.user_answer')
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.question_count', $qstid)
					->first();
				

				$all_qst = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where('user_test_answers.user_id',$user_id)
				->where('user_test_answers.section_id', $section_id)
				->get();

				foreach ($all_qst as $row) 
				{
					array_push($next_array, $row->question_count);
				}

				$answers = array();
				if($qst)
				{
					$answers = Answer::where('question_id', $qst->question_id)->get();
				}
			}

			$max_id = Wpaj_pmpro_memberships_user::where('user_id', $user_id)->max('id');
			if($max_id)
				$membership_id = Wpaj_pmpro_memberships_user::select('membership_id')->where('id', $max_id)->first();	

			if($membership_id)
				$membership_level = Wpaj_pmpro_membership_level::where("id", $membership_id->membership_id)->first();


			return view('front.dashboard.test_result', ['test_id'=> $test_id, 'section_id'=> $section_id, 'user_id'=> $user_id, 'section' =>$section, 'membership_level' =>$membership_level, 'qst' =>$qst , 'answers' =>$answers, 'qst_count' =>$qst_count, 'all_qst' =>$all_qst, 'next_array' =>$next_array]);
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

	public function admin_analysis($userid, $testid, $sectionid)
	{
			if(!empty($userid) && !empty($testid))
			{
				$user_id = base64_decode($userid);
				$test_id = base64_decode($testid);
				$section_id = base64_decode($sectionid);

				$tests = Test::find($test_id);

				$quan_scaled = 0;
                $reading_scaled = 0;
                $verbal_scaled = 0;

				$user_sections = User_taken_section::leftjoin("sections", "user_taken_sections.section_id", "=", "sections.id")
				->where("user_taken_sections.user_id", $user_id)
				->where("user_taken_sections.test_id", $test_id)
				->get();
				foreach($user_sections as $row)
				{
					if(strpos($row->section, 'Quantitative') !== false && $row->status==2) 
					{
						$quan_scaled = 1;
					}
					if(strpos($row->section, 'Verbal') !== false && $row->status==2) 
					{
						$verbal_scaled = 1;
					}
					if(strpos($row->section, 'Reading') !== false && $row->status==2) 
					{
						$reading_scaled = 1;
					}					
				}			

				$max_id = Wpaj_pmpro_memberships_user::where('user_id', $user_id)->max('id');
				if($max_id)
				$membership_id = Wpaj_pmpro_memberships_user::select('membership_id')->where('id', $max_id)->first();

				if($membership_id)
					$membership_level = Wpaj_pmpro_membership_level::select('membership_type_id')->where("id", $membership_id->membership_id)->first();

				$grade = Wpaj_usermeta::where('user_id', $user_id)
					->where('meta_key', "mytheme_phone")
					->first();
					
				$total_questions = \App\Helpers\Helper::get_test_questions_count($test_id);

				$verbal_raw_score = 0;
				$verbal_raw_score_display = 0;
				$verbal_scaled_score = 0;
				$verbal_percentile_score = 0;
				
				$verbal_correct_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 2)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 1)
				->count();

				$verbal_wrong_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 2)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 0)
				->count();

				$verbal_raw_score = ($verbal_correct_questions*1) - ($verbal_wrong_questions*0.25);
				$verbal_raw_score_display = $verbal_raw_score;

				$quantative_raw_score = 0;
				$quantative_raw_score_display = 0;
				$quantative_scaled_score = 0;
				$quantative_percentile_score = 0;
				$quantative_correct_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 3)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 1)
				->count();

				$quantative_wrong_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 3)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 0)
				->count();

				$quantative_raw_score = ($quantative_correct_questions*1) - ($quantative_wrong_questions*0.25);
				$quantative_raw_score_display = $quantative_raw_score;

				$reading_raw_score = 0;
				$reading_raw_score_display = 0;
				$reading_scaled_score = 0;
				$reading_percentile_score = 0;
				$reading_correct_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 4)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 1)
				->count();

				$reading_wrong_questions =  User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
				->where("questions.category_id", 4)
				->where("user_test_answers.user_id", $user_id)
				->where("user_test_answers.test_id", $test_id)
				->where("user_test_answers.is_correct", 0)
				->count();
				
				$reading_raw_score = ($reading_correct_questions*1) - ($reading_wrong_questions*0.25);
				$reading_raw_score_display = $reading_raw_score;
				$total_scaled_score = 0;
				$total_percentile_score = 0;

				if($grade['meta_value']==3 || $grade['meta_value']==4)
				{
					if($verbal_scaled==1)
					{
						$verbal_scaled_score = \App\Helpers\Helper::get_scaled_score($verbal_raw_score, 2);
						$verbal_percentile_score = Elementary_percentile_score::select('verbal')
						->where("grade_id", $grade['meta_value'])
						->where("scaled_score", round($verbal_scaled_score))
						->first();
					}				

					if($quan_scaled==1)
					{
						$quantative_scaled_score = \App\Helpers\Helper::get_scaled_score($quantative_raw_score, 3);

						$quantative_percentile_score = Elementary_percentile_score::select('quantative')
						->where("grade_id", $grade['meta_value'])
						->where("scaled_score", round($quantative_scaled_score))
						->first();
					}	

					if($reading_scaled==1)
					{
						$reading_scaled_score = \App\Helpers\Helper::get_scaled_score($reading_raw_score, 4);

						$reading_percentile_score = Elementary_percentile_score::select('reading')
						->where("grade_id", $grade['meta_value'])
						->where("scaled_score", round($reading_scaled_score))
						->first();
					}					

					$total_scaled_score = $verbal_scaled_score+$quantative_scaled_score+$reading_scaled_score;

					$total_scaled_score = round( $total_scaled_score / 10 )* 10;

					$total_percentile_score = Elementary_total_percentile::select('total')
					->where("scaled_score", $total_scaled_score)
					->first();

					if(!$total_percentile_score)
					{
						$total_percentile_score = Elementary_total_percentile::select('total')
						->where("scaled_score",  ">=", $total_scaled_score)
						->first();
					}
				}
				else
				{
					/*echo $quan_scaled;
                echo $reading_scaled;
                echo $verbal_scaled;*/
					if($verbal_raw_score!=0)
						$verbal_raw_score = round( $verbal_raw_score / 5 )* 5;

					if($quantative_raw_score!=0)
						$quantative_raw_score = round( $quantative_raw_score / 5 )* 5;

					if($reading_raw_score!=0)
						$reading_raw_score = round( $reading_raw_score / 5 )* 5;

					if($grade['meta_value']==5 || $grade['meta_value']==6 || $grade['meta_value']==7)
						$grade_type = 1;
					elseif ($grade['meta_value']==8 || $grade['meta_value']==9 || $grade['meta_value']==10 || $grade['meta_value']==11) 
						$grade_type = 2;

					$standard_deviation = Standard_deviation::where("grade", $grade['meta_value'])->first();
					$median = Median_score::where("grade", $grade['meta_value'])->first();

					if($verbal_scaled==1)
					{
						$verbal_scaled_score = \App\Helpers\Helper::get_middle_upper_scaled_score($verbal_raw_score, 2, $grade_type);
						$verbal_standard_deviation = $standard_deviation['verbal'];
						$verbal_median = $median['verbal'];
						$verbal_z = ($verbal_scaled_score - $verbal_median)/$verbal_standard_deviation;

						if($verbal_z <= -2.5)
							$verbal_z = -2.5;
						elseif ($verbal_z > 2.51) 
							$verbal_z = 2.51;

						$verbal_percentile_score = Z_table::select('percentile')
						->where("z_value", $verbal_z)
						->first();

						if(!$verbal_percentile_score)
						{
							$verbal_percentile_score = Z_table::select('percentile')
							->where("z_value",  ">=", $verbal_z)
							->first();
						}
					}

					if($quan_scaled==1)
					{
						$quantative_scaled_score = \App\Helpers\Helper::get_middle_upper_scaled_score($quantative_raw_score, 3, $grade_type);
						$quantative_standard_deviation = $standard_deviation['quantitative']; 
						$quantative_median = $median['quantitative']; 
						$quantative_z = ($quantative_scaled_score - $quantative_median)/$quantative_standard_deviation;
						
						if($quantative_z <= -2.5)
							$quantative_z = -2.5;
						elseif ($quantative_z > 2.51) 
							$quantative_z = 2.51;

						$quantative_percentile_score = Z_table::select('percentile')
						->where("z_value", $quantative_z)
						->first();

						if(!$quantative_percentile_score)
						{
							$quantative_percentile_score = Z_table::select('percentile')
							->where("z_value",  ">=", $quantative_z)
							->first();
						}
					}

					if($reading_scaled==1)
					{
						$reading_scaled_score = \App\Helpers\Helper::get_middle_upper_scaled_score($reading_raw_score, 4, $grade_type);
						$reading_standard_deviation = $standard_deviation['reading']; 
						$reading_median = $median['reading'];
						$reading_z = ($reading_scaled_score - $reading_median)/$reading_standard_deviation;
					
						if($reading_z <= -2.5)
							$reading_z = -2.5;
						elseif ($reading_z > 2.51) 
							$reading_z = 2.51;

						$reading_percentile_score = Z_table::select('percentile')
						->where("z_value", round($reading_z))
						->first();

						if(!$reading_percentile_score)
						{
							$reading_percentile_score = Z_table::select('percentile')
							->where("z_value",  ">=", $reading_z)
							->first();
						}
					}

					$total_scaled_score = $verbal_scaled_score+$quantative_scaled_score+$reading_scaled_score;

					$total_standard_deviation = $standard_deviation['total']; 

					$total_median = $median['total']; 

					$total_z = ($total_scaled_score - $total_median)/$total_standard_deviation;

					if($total_z <= -2.5)
						$total_z = -2.5;
					elseif ($total_z > 2.51) 
						$total_z = 2.51;

					$total_percentile_score = Z_table::select('percentile')
					->where("z_value", round($total_z))
					->first();

					if(!$total_percentile_score)
					{
						$total_percentile_score = Z_table::select('percentile')
						->where("z_value",  ">=", $total_z)
						->first();
					}
					/*echo $verbal_raw_score."/".$quantative_raw_score."/".$reading_raw_score;
					echo "<br>";
					echo $verbal_scaled_score."/".$quantative_scaled_score."/".$reading_scaled_score;
					echo "<br>";
					echo $verbal_standard_deviation."/".$quantative_standard_deviation."/".$reading_standard_deviation;
					echo "<br>";
					echo $verbal_median."/".$quantative_median."/".$reading_median;*/
					
				}
				$sections = Test_section_mapping::leftjoin("sections", "test_section_mappings.section_id", "=", "sections.id")
				->select('test_section_mappings.test_id', 'sections.id as id', 'sections.section', 'sections.duration_in_mins')
				->where('test_id', $test_id)
				->where('section', "NOT LIKE", "%Writing%")
				->orderBy('sections.section', 'ASC')
				->get(); 

				$categories = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
				->leftjoin("categories", "questions.excel_category_id", "=", "categories.id")
				->where("section_questions.section_id", $section_id)
				->where("questions.is_active", 1)
				->select(DB::raw('COUNT(questions.id) as counts'), 'categories.category', 'categories.id as category_id')
				->groupBy('questions.excel_category_id')
				->get();

				$easy_correct_ans = 0;
		        $easy_wrong_ans = 0;
		        $easy_unanswered_ans = 0;

				$medium_correct_ans = 0;
		        $medium_wrong_ans = 0;
		        $medium_unanswered_ans = 0;

				$diff_correct_ans = 0;
		        $diff_wrong_ans = 0;
		        $diff_unanswered_ans = 0;

		        $res_count = 0;

				if($section_id && $section_id!=0 )
				{

			        $easy_correct_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 1)
					->where('questions.difficulty_level', 1)
					->count();

					$easy_wrong_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 0)
					->where('questions.difficulty_level', 1)
					->count();

					$easy_unanswered_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->whereNull('user_test_answers.is_correct')
					->where('questions.difficulty_level', 1)
					->count();

					if(!$easy_correct_ans && !$easy_wrong_ans)
					{
						$easy_unanswered_ans = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
						->where('questions.difficulty_level', 1)
						->where('section_questions.section_id', $section_id)
						->count();						
					}


					$medium_correct_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 1)
					->where('questions.difficulty_level', 2)
					->count();

					$medium_wrong_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 0)
					->where('questions.difficulty_level', 2)
					->count();

					$medium_unanswered_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->whereNull('user_test_answers.is_correct')
					->where('questions.difficulty_level', 2)
					->count();
					
					if(!$medium_correct_ans && !$medium_wrong_ans)
					{

						$medium_unanswered_ans = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
						->where('questions.difficulty_level', 2)
						->where('section_questions.section_id', $section_id)
						->count();
					}

					$diff_correct_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 1)
					->where('questions.difficulty_level', 3)
					->count();

					$diff_wrong_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->where('user_test_answers.is_correct', 0)
					->where('questions.difficulty_level', 3)
					->count();

					$diff_unanswered_ans = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
					->where('user_test_answers.user_id', $user_id)
					->where('user_test_answers.section_id', $section_id)
					->whereNull('user_test_answers.is_correct')
					->where('questions.difficulty_level', 3)
					->count();
					
					if(!$diff_correct_ans && !$diff_wrong_ans)
					{
						$diff_unanswered_ans = Section_question::leftjoin("questions", "section_questions.question_id", "=", "questions.id")
						->where('questions.difficulty_level', 3)
						->where('section_questions.section_id', $section_id)
						->count();
					}					
					$res_count = \App\Helpers\Helper::get_user_section_count($section_id, Session::get('loggedin_user_id'));
					}
				}
				return view('front.dashboard.admin_analysis', ['test_id'=> $test_id, 'sections'=> $sections, 'easy_correct_ans'=> $easy_correct_ans, 'easy_wrong_ans'=> $easy_wrong_ans, 'easy_unanswered_ans'=> $easy_unanswered_ans, 'medium_correct_ans'=> $medium_correct_ans, 'medium_wrong_ans'=> $medium_wrong_ans, 'medium_unanswered_ans'=> $medium_unanswered_ans, 'diff_correct_ans'=> $diff_correct_ans,'diff_wrong_ans'=> $diff_wrong_ans,'diff_unanswered_ans'=> $diff_unanswered_ans, 'res_count'=> $res_count, 'user_id'=> $user_id, 'categories'=> $categories, 'verbal_scaled_score'=> $verbal_scaled_score, 'quantative_scaled_score'=> $quantative_scaled_score, 'reading_scaled_score'=> $reading_scaled_score, 'verbal_raw_score_display'=> $verbal_raw_score_display, 'verbal_raw_score'=> $verbal_raw_score, 'quantative_raw_score'=> $quantative_raw_score, 'quantative_raw_score_display'=> $quantative_raw_score_display, 'reading_raw_score_display'=> $reading_raw_score_display, 'reading_raw_score'=> $reading_raw_score, 'verbal_percentile_score'=> $verbal_percentile_score, 'quantative_percentile_score'=> $quantative_percentile_score, 'reading_percentile_score'=> $reading_percentile_score, 'tests'=> $tests, 'grade'=> $grade['meta_value'], 'total_percentile_score'=> $total_percentile_score]); 
			}
}
