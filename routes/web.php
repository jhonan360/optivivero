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
    return view('index'); // aca usted coloca la ruta del archivo
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function()
{
	Route::get('/', 'AdminController@inicio')->middleware('auth');
	Route::get('/usuarios', 'AdminController@usuarios')->middleware('auth');
	// otros
	Route::post('/tableUser', 'AdminController@tableUser')->middleware('auth');
	Route::post('/estadoUsuario', 'AdminController@estadoUsuario')->middleware('auth');
	Route::post('/usuarioAlmacenar', 'AdminController@usuarioAlmacenar')->middleware('auth');
});



Route::group(['prefix' => 'user'], function()
{
	Route::get('/', 'UserController@inicio')->middleware('auth');
});