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
    return redirect('gallery');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('category_list', 'HomeController@category_list');
Route::get('category_add', 'HomeController@category_add');
Route::post('category_save', 'HomeController@category_save');
Route::get('category_edit', 'HomeController@category_edit');
Route::post('category_update', 'HomeController@category_update');
Route::get('category_delete', 'HomeController@category_delete');
Route::get('gallery', 'HomeController@gallery');
Route::get('flicker', 'HomeController@flicker');
