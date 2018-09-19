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

Route::get('/', 'PostsController@index')->name('index');

Route::post('/store', 'PostsController@store')->name('store');

Route::get('/get/{id}', 'PostsController@edit')->name('edit');

Route::put('/update/{id}', 'PostsController@update')->name('update');

Route::delete('destroy/{id}', 'PostsController@destroy')->name('destroy');

Route::get('/view/{id}', 'PostsController@view')->name('view');

Route::get('/download/{id}', 'PostsController@download')->name('download');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');

Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

Route::get('/test', 'pdfParserController@index');