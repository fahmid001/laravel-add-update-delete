<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
Route::group(['middleware' => ['web']], function () {
    #Branch Section
    Route::get('branch', 'BranchController@index');
    Route::get('details-branch/{id}', array('uses' => 'BranchController@details'));
    Route::get('add-branch', 'BranchController@add');
    Route::post('branch-store', 'BranchController@store');
    Route::get('delete-branch/{id}', array('as' => 'post', 'uses' => 'BranchController@destroy'));
    Route::get('edit-branch/{id}', array('as' => 'post', 'uses' => 'BranchController@edit'));
    Route::post('branch-update', array('as' => 'post', 'uses' => 'BranchController@update'));
    Route::get('getdistrictList', array('as' => 'post', 'uses' => 'BranchController@getdistrictList'));
    Route::get('getupazilaList', array('as' => 'post', 'uses' => 'BranchController@getupazilaList'));
});
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


