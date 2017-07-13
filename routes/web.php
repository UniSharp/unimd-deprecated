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

Auth::routes();

Route::get('/', function () {
    return redirect()->route('home');
});

Route::group(['middleware' => 'auth'], function () {
    // home
    Route::get('/home', 'HomeController@index')->name('home');
    // notes
    Route::group(['prefix' => 'note', 'as' => 'note.'], function () {
        Route::get('/', ['uses' => 'NoteController@index', 'as' => 'index']);
        Route::get('/new', ['uses' => 'NoteController@create', 'as' => 'create']);
        Route::get('{note}/edit', ['uses' => 'NoteController@edit', 'as' => 'edit']);
    });
});
