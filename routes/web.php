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

Route::get('/', 'HomeController@index')->name('home');
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
$modules = \App\Module::names(); // fetch all module names
$modulegroups = \App\Modulegroup::names();

/*
 *
 * Resources / RESTful routes.
 * ***************************************************************************
 * Resources automatically generates index, create, store, show, edit, update,
 * destroy routes. Based on the modules table all these routes are created.
 * In addition to above we also need a 'restore' as we have soft delete
 * enabled for our solution.
 *
 * prefix    :
 * filter    : before [auth] - only authenticated users can access these routes
 *        : before [resource.route.permission.check] - checks permission using Sentry.
 *****************************************************************************/

Route::middleware(['auth'])->group(function () use ($modules, $modulegroups) {

    # default routes for all modules
    foreach ($modules as $module) {
        $Controller = ucfirst($module) . "Controller";
        Route:: get($module . "/{".str_singular($module)."}/restore", $Controller . "@restore")->name($module . '.restore');
        Route:: get($module . "/grid", $Controller . "@grid")->name($module . '.grid');
        Route:: get($module . "/getJson", $Controller . "@getJson")->name($module . '.getJson');
        Route:: get($module . "/report", $Controller . "@report")->name($module . '.report');
        Route:: get($module . "/{".str_singular($module)."}/changes", $Controller . "@changes")->name($module . '.changes');
        Route::resource($module, $Controller);
    }

    # default routes for all modulegroups
    foreach ($modulegroups as $modulegroup) {
        Route::get("$modulegroup", 'ModulegroupsController@modulegroupIndex')->name($modulegroup . '.index');
    }

    # route for updating an existing upload file
    Route::post('update_upload', 'UploadsController@updateExistingUpload')->name('uploads.update_last_upload');

    /**
     * Generate download request of a file.
     * Files are stored in a physical file system. To hide the urls from the user following URL generates a download
     * request that initiates download of the file matching the uuid.
     */
    Route::get('download/{uuid}', 'UploadsController@download')->name('get.download');

});

Route::get('test', function(){
    echo dbTableExists('modules');
    return 'test';
});


