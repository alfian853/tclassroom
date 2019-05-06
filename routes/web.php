
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
Route::any('ViewerJS/{all?}', function(){
    return View::make('ViewerJS.index');
});

Route::get('/registration','Auth\RegisterController@getRegister')->name('get.register');
Route::get('/registration/confirmation','Auth\RegisterController@confirmRegistration')
    ->name('get.register.confirmation');
Route::post('/registration','Auth\RegisterController@requestRegister')->name('post.register');


Route::get('/list_agenda','AgendaController@getListAgenda')->name('get.agenda.list');

Route::group(['middleware' => ['auth']], function (){
    Route::group(['middleware' => ['course_access']],function(){
        Route::get('/agenda/{agenda_id}','AgendaController@getAgendaDetail')
            ->name('get.agenda.detail');
        Route::get('/agenda/{agenda_id}/pertemuan/{no_pertemuan}/materi','AgendaController@getListMateri')
            ->name('get.agenda.materi');
        Route::get('/agenda/{agenda_id}/pertemuan/{no_pertemuan}/tugas','AgendaController@getListTugas')
            ->name('get.agenda.tugas');
    });

    Route::group(['middleware' => ['course_admin']],function(){
        Route::post('/agenda/{agenda_id}/pertemuan/{no_pertemuan}/materi','AgendaController@uploadMateri')
            ->name('post.agenda.materi');
        Route::post('/agenda/{agenda_id}/pertemuan/{no_pertemuan}/tugas','AgendaController@createTugas')
            ->name('post.agenda.tugas');
        Route::post('/agenda/{agenda_id}/pertemuan/{no_pertemuan}/materi/{materi_id}/delete','AgendaController@deleteMateri')
            ->name('delete.agenda.materi');
    });
});


