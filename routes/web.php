
<?php
use Illuminate\Support\Facades\Input;
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

Auth::routes();

Route::get('/', function () {
  return view('layouts.index');
})->name('home');


Route::get('/registration','Auth\RegisterController@getRegister')->name('get.register');
Route::get('/registration/confirmation','Auth\RegisterController@confirmRegistration')
    ->name('get.register.confirmation');
Route::post('/registration','Auth\RegisterController@requestRegister')->name('post.register');


Route::get('/courses','CourseController@getCoursesView')->name('get.courses');
Route::post('/courses','CourseController@createCourse')->name('post.course.create');
Route::post('/courses/join','CourseController@joinCourse')->name('post.course.join');


Route::group(['middleware' => ['course_access']],function(){
    Route::get('/courses/{course_id}','CourseController@getCourseDashboardView')->name('get.courses.dashboard');
});

Route::group(['middleware' => ['course_admin']],function(){
    Route::post('/courses/{course_id}/upload-module','ModuleController@uploadModule')
        ->name('post.module.upload');
    Route::post('/courses/{course_id}/post','PostingController@createPosting')
        ->name('post.posting');
});

