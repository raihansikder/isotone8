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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('home', 'HomeController@index')->name('home');

Route:: get('threads', 'ThreadsController@index')->name('threads.index');
Route:: get('threads/create', 'ThreadsController@create')->name('threads.create');
Route:: get('threads/{channel}', 'ThreadsController@index')->name('channels.show');
Route:: post('threads', 'ThreadsController@store')->name('threads.store');
Route:: get('threads/{channel_slug}/{thread}', 'ThreadsController@show')->name('threads.show');
// Route::resource('threads', 'ThreadsController');
Route::post('threads/{channel_slug}/{thread}/replies', 'RepliesController@store')->name('replies.store');

/*
|--------------------------------------------------------------------------
| Spyr Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for the spyr framework.
*/
//$modules = \App\Module::remember(2)->pluck('name'); // fetch all module names

Route::get('test', function () {
    $module = \App\Module::find(1);
    Session::forget(['some','saved','saving','updating','updated']);
    $module->modulegroup_id = random_int(0,100);
    $module->save();
    return 'test';

});
