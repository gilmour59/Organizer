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

Route::get('/test', function () {
    return response()->file('C:\Users\Gil\Pictures\level3helmet.jpg');
})->name('test');

//ALL SEARCH NEEDS CHANGE
/* 
Route::get('/', 'SearchController@index');

Route::get('/search', 'SearchController@action')->name('search.action'); 

Route::get('/view', 'SearchController@view')->name('search.view'); 
*/

Route::get('/', 'PostsController@index')->name('index');

Route::post('/store', 'PostsController@store')->name('store');

Route::put('/update/{id}', 'PostsController@update')->name('update');

Route::delete('destroy/{id}', 'PostsController@destroy')->name('destroy');