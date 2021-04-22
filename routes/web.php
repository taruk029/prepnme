<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

/* -------------   Front Controller --------------- */

Route::get('login_user', 'FrontController@login_user')->name('login_user');
Route::get('welcome', 'FrontController@index');
Route::get('logout_user', 'FrontController@logout_user');
Route::post('login_user', 'FrontController@checklogin');
Route::get('take_test/{id}', 'FrontController@check_take_test');


/* -------------   Dashboard Controller --------------- */
Route::get('dashboard', 'DashboardController@index');
Route::match(array('GET', 'POST'),'user_test/{userid}/{testid}/{sectionid}/{qstid}', 'DashboardController@usertest');
Route::get('save_timer', 'DashboardController@savetimer');
Route::get('next_question', 'DashboardController@next_question');
Route::get('come_back_later', 'DashboardController@come_back_later');
Route::get('set_answer', 'DashboardController@set_answer');
Route::get('outoftime/{userid}/{testid}/{sectionid}', 'DashboardController@out_of_time');
Route::get('pause_section/{testid}/{sectionid}', 'DashboardController@pauseSection');
Route::get('pause/{testid}/{sectionid}', 'DashboardController@pause');
Route::get('end_section/{testid}/{sectionid}', 'DashboardController@endsection');
Route::get('end/{testid}/{sectionid}', 'DashboardController@end');
Route::get('save_essay', 'DashboardController@save_essay');

Route::get('view_result', 'TestResultController@index');

/* -------------   Analysis Controller --------------- */

Route::get('admin_analysis/{userid}/{testid}/{section_id}', 'AnalysisController@admin_analysis');
Route::get('analysis/{userid}/{testid}/{section_id}', 'AnalysisController@index');
Route::get('result/{userid}/{testid}/{section_id}/{qstid}/{type}/{values}', 'AnalysisController@view_result');

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');



Route::group([
    'middleware' => 'auth'
], function () {
Route::get('home', 'HomeController@index')->name('home');

/* -------------   Category Controller --------------- */
Route::get('categories', 'CategoryController@index');
Route::get('add_category', 'CategoryController@add');
Route::get('edit_category/{id}', 'CategoryController@edit');
Route::post('add_category', 'CategoryController@insert');
Route::post('update_category', 'CategoryController@update');

/* -------------   QuestionType Controller --------------- */
Route::get('question_types', 'QuestionTypeController@index');
Route::get('add_question_type', 'QuestionTypeController@add');
Route::get('edit_question_type/{id}', 'QuestionTypeController@edit');
Route::post('add_question_type', 'QuestionTypeController@insert');
Route::post('update_question_type', 'QuestionTypeController@update');


/* -------------   Question Controller --------------- */
Route::get('questions', 'QuestionController@index');
Route::get('add_question', 'QuestionController@add');
Route::post('add_question', 'QuestionController@insert');
Route::get('edit_question/{id}', 'QuestionController@edit');
Route::post('update_question', 'QuestionController@update');
Route::get('delete_question/{id}', 'QuestionController@delete');


/* -------------   Test Controller --------------- */
Route::get('manage_tests', 'TestController@index');
Route::get('add_test', 'TestController@add');
Route::post('add_test', 'TestController@insert');
Route::get('edit_test/{id}', 'TestController@edit');
Route::post('update_test', 'TestController@update');
Route::get('bulk_upload', 'TestController@bulkupload');
Route::get('get_test_sections', 'TestController@get_test_sections');
Route::get('add_test_section', 'TestController@add_test_section');
Route::get('get_test_membership', 'TestController@get_test_membership');
Route::post('add_bulk_test', 'TestController@add_bulk_test');
Route::get('get_log/{id}', 'TestController@get_log');
Route::get('delete/{id}', 'TestController@inactive');

/* -------------   Section Controller --------------- */
Route::get('sections', 'SectionController@index');
Route::get('add_section', 'SectionController@add');
Route::post('add_section', 'SectionController@insert');
Route::get('edit_section/{id}', 'SectionController@edit');
Route::post('update_section', 'SectionController@update');

/* -------------   Test Section Controller --------------- */
Route::get('tests_sections', 'TestSectionController@index');
Route::get('assign_section', 'TestSectionController@add');
Route::post('assign_section', 'TestSectionController@insert');
Route::get('edit_test_section/{id}', 'TestSectionController@edit');
Route::post('update_test_section', 'TestSectionController@update');


/* -------------   Section Question  Controller --------------- */
Route::get('section_questions', 'SectionQuestionController@index');
Route::get('add_section_questions', 'SectionQuestionController@add');
Route::post('add_section_questions', 'SectionQuestionController@insert');
Route::get('edit_section_questions/{id}', 'SectionQuestionController@edit');
Route::post('update_section_questions', 'SectionQuestionController@update');
Route::get('get_questions', 'SectionQuestionController@get_questions');
Route::get('get_questions_bysection_id', 'SectionQuestionController@get_section_questions');

});
