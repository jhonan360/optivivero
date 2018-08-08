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
	Route::get('/plantas', 'AdminController@plantas')->middleware('auth');
	Route::get('/tipoPlanta', 'AdminController@tipoPlanta')->middleware('auth');
	Route::get('/pedidos', 'AdminController@pedidos')->middleware('auth');
	// otros
	Route::post('/tableUser', 'AdminController@tableUser')->middleware('auth');
	Route::post('/estadoUsuario', 'AdminController@estadoUsuario')->middleware('auth');
	Route::post('/usuarioAlmacenar', 'AdminController@usuarioAlmacenar')->middleware('auth');
	Route::post('/tablePlantas', 'AdminController@tablePlantas')->middleware('auth');
	Route::post('/llenarSelectTipoPlantas', 'AdminController@llenarSelectTipoPlantas')->middleware('auth');
	Route::post('/plantaAlmacenar', 'AdminController@plantaAlmacenar')->middleware('auth');
	Route::post('/tableTipoPlantas', 'AdminController@tableTipoPlantas')->middleware('auth');
	Route::post('/tipoPlantaAlmacenar', 'AdminController@tipoPlantaAlmacenar')->middleware('auth');
	Route::post('/hacerPedido', 'AdminController@hacerPedido')->middleware('auth');
});



Route::group(['prefix' => 'user'], function()
{
	Route::get('/', 'UserController@inicio')->middleware('auth');
});