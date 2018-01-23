<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    $user =$request->user();
    return response()->json($user);
})->middleware(['jwt.refresh'])->name('user_info');


Route::group(['prefix' => "", 'namespace' => 'Admin'], function () {
    Route::get('permission_list', 'PermissionController@permission_list')->name('permission_list');
    Route::post('permission_save', 'PermissionController@permission_save')->name('permission_save');
    Route::post('permission_remove/{id}', 'PermissionController@permission_remove')->name('permission_save');

    Route::get('user_list', 'PermissionController@user_list')->name('user_list');
    Route::post('user_save', 'PermissionController@user_save')->name('user_save');
    Route::post('user_remove/{id}', 'PermissionController@user_remove')->name('user_save');

    Route::get('role_list', 'PermissionController@role_list')->name('role_list');
    Route::post('role_save', 'PermissionController@role_save')->name('role_save');
    Route::post('role_remove/{id}', 'PermissionController@role_remove')->name('role_save');

    Route::get('category_list', 'CategoryController@category_list')->name('category_list');
    Route::post('category_save', 'CategoryController@category_save')->name('category_save');
    Route::post('category_remove/{id}', 'CategoryController@category_remove')->name('category_save');

    Route::get('pattern_all', 'CategoryController@pattern_all')->name('pattern_all');
    Route::get('pattern_list', 'CategoryController@pattern_list')->name('pattern_list');
    Route::post('pattern_save', 'CategoryController@pattern_save')->name('pattern_save');
    Route::post('pattern_remove/{id}', 'CategoryController@pattern_remove')->name('pattern_save');
});
