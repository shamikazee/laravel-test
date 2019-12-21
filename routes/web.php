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

//category routes

Route::get('categories','CategoryController@index');
Route::post('categories','CategoryController@create');
Route::get('categories/{slug}','CategoryController@show');
Route::put('categories/{slug}','CategoryController@update');
Route::delete('categories/{slug}','CategoryController@destroy');

//course routes

Route::get('courses','CourseController@index');
Route::post('courses','CourseController@create');
Route::get('courses/{slug}','CourseController@show');
Route::put('courses/{slug}','CourseController@update');
Route::delete('courses/{slug}','CourseController@destroy');

//upload image

Route::post('upload','ImageController@create');
