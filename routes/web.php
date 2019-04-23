
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


Route::get('/', function () {
  return view('home');
});

Route::get('/registration','Auth\RegisterController@getRegister')->name('get.register');
Route::get('/registration/confirmation','Auth\RegisterController@confirmRegistration')
    ->name('get.register.confirmation');
Route::post('/registration','Auth\RegisterController@requestRegister')->name('post.register');


Route::resource('mhs','MhsController');
Route::resource('dosen','DosenController');
Route::resource('matkul','MatkulController');

