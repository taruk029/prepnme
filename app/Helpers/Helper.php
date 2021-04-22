<?php

namespace App\Helpers;
use App\Test_section_mapping;
use App\Section;
use App\Test;
use App\User_taken_section;
use App\User_test_answer;
use App\Section_question;
use App\Elementary_scaled_score;
use App\Question;
use App\Standard_deviation;
use App\Middle_upper_scaled_score;
use App\Median_score;
use App\Z_table;
use Charts;

class Helper {

    public static function get_test_sections($id) 
    {
      $sections_name = "";
      if($id)
      {
        $sections_name_array = array();
        $sections = Test_section_mapping::leftjoin("sections", "test_section_mappings.section_id", "=", "sections.id")
          ->select('sections.section')
          ->orderBy("sections.section", "ASC")
          ->where('test_section_mappings.test_id',$id)
          ->get();
        if(count($sections))
        {
          foreach ($sections as $row) 
          {
            array_push($sections_name_array, $row->section);
          }
          if($sections_name_array)
            $sections_name = implode(", ", $sections_name_array);
          //$sections_name = "<ul><li>".implode("</li><li>", $sections_name_array)."</li></ul>";
        }
      }
      return $sections_name;
    }

    public static function get_remaining_time($id, $test_id, $section_id) 
    {
      $sections_name = "";
      if(!empty($id) && !empty($test_id) && !empty($section_id))
      {
        $sections_name_array = array();
        $user_section_time = User_taken_section::select('remaining_time_minutes', 'remaining_time_seconds')          
          ->where('user_id', $id)
          ->where('test_id', $test_id)
          ->where('section_id', $section_id)
          ->whereIn('status', [0,1])
          ->first();

        $section_time = Section::select('duration_in_mins')->where('id', $section_id)->first();
        if($user_section_time)
        {
            $original_time = ($section_time->duration_in_mins*60);
            $user_remaining_time = (($user_section_time->remaining_time_minutes*60) + $user_section_time->remaining_time_seconds);
            $remaining = $original_time - $user_remaining_time;
            if($user_remaining_time<60)
              $remaining_time =1;
            else
            $remaining_time = round(($user_remaining_time/60),0,PHP_ROUND_HALF_UP);
        }
        else
        {
          $remaining_time = $section_time->duration_in_mins;
        }
      }
      return $remaining_time;
    }

    public static function get_status($id, $test_id, $section_id) 
    {
      $status = 0;
      if($id)
      {
        $sections = User_taken_section::select('status')
          ->where('user_id', $id)
          ->where('test_id', $test_id)
          ->where('section_id', $section_id)
          ->first();
        $status = $sections['status'];
      }
      return $status;
    }

  public static function get_test_id($test_name) 
      {
        $test_id = 0;
        if($test_name)
        {
          $test = Test::select('id')
            ->where('test_name', $test_name)
            ->first();
          $test_id = $test['id'];
        }
        return $test_id;
      }
   public static function get_section_id($section_name, $test_id) 
      {
        $section_id = 0;
        if($section_name)
        {
          $section = Test_section_mapping::leftjoin("sections", "test_section_mappings.section_id", "=", "sections.id")
          ->select('sections.id')
          ->where('section', $section_name)
          ->where('test_section_mappings.test_id', $test_id)
          ->first();
          $section_id = $section['id'];
        }
        return $section_id;
      } 


    public static function get_user_section_count($section_id, $user_id) 
      {
        $result_count = 0;
        if($section_id)
        {
          $section = User_test_answer::where('section_id', $section_id)
          ->where('user_id', $user_id)
          ->get();
          if(count($section))
            $result_count = 1;
          else
            $result_count = 0;
        }
        return $result_count;
      }

    public static function get_user_category_count($section_id, $user_id, $category, $is_correct) 
    {
      $result_count = 0;
      if($section_id)
      {
        if($is_correct==2)
        {
          $cats = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
          ->where('user_test_answers.section_id', $section_id)
          ->where('user_test_answers.user_id', $user_id)
          ->where('questions.excel_category_id', $category)
          ->where('questions.is_active', 1)
          ->whereNull('user_test_answers.is_correct')
          ->count();
        }
        else
        {
          $cats = User_test_answer::leftjoin("questions", "user_test_answers.question_id", "=", "questions.id")
          ->where('user_test_answers.section_id', $section_id)
          ->where('user_test_answers.user_id', $user_id)
          ->where('questions.excel_category_id', $category)
          ->where('questions.is_active', 1)
          ->where('user_test_answers.is_correct', $is_correct)
          ->count();
        }
        if($cats)
          $result_count = $cats;
      }
      return $result_count;
    }  

    public static function get_category_type_id($section_name) 
    {
      $category_id = 3;
      if(strpos($section_name, 'Writing') !== false || strpos($section_name, 'Sample') !== false)
      {
        $category_id = 1;
      }
      if(strpos($section_name, 'Verbal') !== false)
      {
        $category_id = 2;
      }
      if(strpos($section_name, 'Quantitative') !== false)
      {
        $category_id = 3;
      }
      if(strpos($section_name, 'Reading') !== false)
      {
        $category_id = 4;
      }
      return $category_id;
    }  


    public static function get_test_questions_count($test_id) 
    {
      $result_count = 0;
      if($test_id)
      {
        $tests = Test_section_mapping::select('test_section_mappings.section_id')
        ->where('test_id', $test_id)
        ->get();
        if(count($tests))
        {
          foreach($tests as $rows)
          {
            $counts = 0;
            $counts = Section_question::where('section_id', $rows->section_id)->count();
            $result_count = $result_count+$counts;
          }
        }
      }
      return $result_count;
    }  


    public static function get_scaled_score($raw_score, $score_type) 
    {
      $scaled_score = 0;
        if($raw_score < "-5")
        {
          $sc_sr = Elementary_scaled_score::where('raw_score', "-5")
          ->first();

          if($score_type==2)
            $scaled_score = $sc_sr['verbal'];

          if($score_type==3)
            $scaled_score = $sc_sr['quantitative'];

          if($score_type==4)
            $scaled_score = $sc_sr['reading'];
        }

        if($raw_score > 30)
        {
          $sc_sr = Elementary_scaled_score::where('raw_score', 30)
          ->first();

          if($score_type==2)
            $scaled_score = $sc_sr['verbal'];

          if($score_type==3)
            $scaled_score = $sc_sr['quantitative'];

          if($score_type==4)
            $scaled_score = $sc_sr['reading'];
        }

        else
        {
          $max_sc_sr = Elementary_scaled_score::where('raw_score', ">=", $raw_score)
          ->first();

          $min_sc_sr = Elementary_scaled_score::find($max_sc_sr['id']-1);

          if($max_sc_sr && $min_sc_sr)
          {
            if($score_type==2)
              $scaled_score = $min_sc_sr['verbal'] + ($raw_score - $min_sc_sr['raw_score'])* (($max_sc_sr['verbal'] - $min_sc_sr['verbal'])/($max_sc_sr['raw_score'] - $min_sc_sr['raw_score']));

            if($score_type==3)
              $scaled_score = $min_sc_sr['quantitative'] + ($raw_score - $min_sc_sr['raw_score'])*($max_sc_sr['quantitative'] - $min_sc_sr['quantitative'])/($max_sc_sr['raw_score'] - $min_sc_sr['raw_score']);

            if($score_type==4)
              $scaled_score = $min_sc_sr['reading'] + ($raw_score - $min_sc_sr['raw_score'])*($max_sc_sr['reading'] - $min_sc_sr['reading'])/($max_sc_sr['raw_score'] - $min_sc_sr['raw_score']);
          }
        }

      return $scaled_score;
      }


    public static function get_middle_upper_scaled_score($raw_score, $score_type, $grade_type) 
    {
      $scaled_score = 0;
        if($raw_score < "-5")
        {
          $raw_score =  "-5";
        }
        elseif ($raw_score > 60) {
          $raw_score = 60;
        }
        $sc_sr = Middle_upper_scaled_score::where('raw_score', $raw_score)
        ->first();

          if($grade_type==1)
          {            
            if($score_type==2)
              $scaled_score = $sc_sr['middle_verbal'];

            if($score_type==3)
              $scaled_score = $sc_sr['middle_quantative'];

            if($score_type==4)
              $scaled_score = $sc_sr['middle_reading'];
          }
          else
          {            
            if($score_type==2)
              $scaled_score = $sc_sr['upper_verbal'];

            if($score_type==3)
              $scaled_score = $sc_sr['upper_quantative'];

            if($score_type==4)
              $scaled_score = $sc_sr['upper_reading'];
          }
      return $scaled_score;
      }


      public static function get_time($id, $type) 
    {
      $remaining_time = "";
      if(!empty($id) && !empty($type))
      {
        $user_section_time = User_taken_section::select('remaining_time_minutes', 'remaining_time_seconds')          
          ->where('id', $id)
          ->first();
        if($type==1)
          $remaining_time =$user_section_time['remaining_time_minutes'];
        else
          $remaining_time =$user_section_time['remaining_time_seconds'];

      }
      return $remaining_time;
    }

    public static function get_test_status($user_id, $test_id) 
    {
      $status = 0;
      if($test_id)
      {
        $section_tests = Test_section_mapping::select('section_id')
        ->where('test_id', $test_id)
        ->count();

        $tests = User_taken_section::leftjoin("sections", "user_taken_sections.section_id", "=", "sections.id")
        ->select('user_taken_sections.section_id', 'user_taken_sections.status as section_status', 'sections.section')
        ->where('user_taken_sections.test_id', $test_id)
        ->where('user_taken_sections.user_id', $user_id)
        ->get();
        if(count($tests) == $section_tests)
        {
          foreach($tests as $rows)
          {
            if(strpos($rows->section, 'Writing') === false) 
            {
              if($rows->section_status==1 || $rows->section_status==0 )
              {
                $status = 1;
              }
            }
            else
            {
                if($rows->section_status==1 || $rows->section_status==0 )
                {
                  $status = 1;
                }
            }
          }
        }
        else
          $status = 1;
      }
      return $status;
    }
}
