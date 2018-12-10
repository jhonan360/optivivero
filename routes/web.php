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
Route::get('/prueba', 'ApiController@prueba')->name('prueba');

Route::group(['prefix' => 'admin'], function()
{
	Route::get('/', 'AdminController@inicio')->middleware('auth');
	Route::get('/usuarios', 'AdminController@usuarios')->middleware('auth');
	Route::get('/plantas', 'AdminController@plantas')->middleware('auth');
	Route::get('/tipoPlanta', 'AdminController@tipoPlanta')->middleware('auth');
	Route::get('/pedidos', 'AdminController@pedidos')->middleware('auth');
	Route::get('/proveedores', 'AdminController@proveedores')->middleware('auth');
	Route::get('/reportes','AdminController@reportes')->middleware('auth');
	Route::get('/secciones', 'AdminController@secciones')->middleware('auth');
	Route::get('/entradas', 'AdminController@entradas')->middleware('auth');
	Route::get('/salidas', 'AdminController@salidas')->middleware('auth');
	Route::get('/ventas', 'AdminController@ventas')->middleware('auth');

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
	Route::post('/tablePedido', 'AdminController@tablePedido')->middleware('auth');
	Route::post('/tableSolicitudes', 'AdminController@tableSolicitudes')->middleware('auth');
	Route::post('/tableProveedores', 'AdminController@tableProveedores')->middleware('auth');
	Route::post('/proveedorAlmacenar', 'AdminController@proveedorAlmacenar')->middleware('auth');
	Route::post('/graficaInicio', 'AdminController@graficaInicio')->middleware('auth');
	Route::post('/pedirDatos', 'AdminController@pedirDatos')->middleware('auth');
	Route::post('/tableEntradas', 'AdminController@tableEntradas')->middleware('auth');
	Route::post('/modalEntradas', 'AdminController@modalEntradas')->middleware('auth');
	Route::post('/responderEntradas', 'AdminController@responderEntradas')->middleware('auth');
	Route::post('/tableSalidas', 'AdminController@modalSalidas')->middleware('auth');
	Route::post('/pagarVenta', 'AdminController@pagarVenta')->middleware('auth');
	Route::post('/seccionAlmacenar', 'AdminController@seccionAlmacenar')->middleware('auth');
	Route::post('/tableSeccion', 'AdminController@tableSeccion')->middleware('auth');

	//reportes
	Route::get('/sensorReport', 'ReportController@sensorReport')->middleware('auth');
	Route::get('/inventarioReport', 'ReportController@inventarioReport')->middleware('auth');

});



Route::group(['prefix' => 'user'], function()
{
	Route::get('/', 'AdminController@inicio')->middleware('auth');

	Route::get('/plantas', 'AdminController@plantas')->middleware('auth');
	Route::get('/tipoPlanta', 'AdminController@tipoPlanta')->middleware('auth');
	Route::get('/pedidos', 'AdminController@pedidos')->middleware('auth');
	Route::get('/proveedores', 'AdminController@proveedores')->middleware('auth');
	Route::get('/secciones', 'AdminController@secciones')->middleware('auth');
	Route::get('/entradas', 'AdminController@entradas')->middleware('auth');
	Route::get('/salidas', 'AdminController@salidas')->middleware('auth');
	Route::get('/ventas', 'AdminController@ventas')->middleware('auth');

});

Route::group(['prefix' => 'provider'], function()
{
	Route::get('/', 'ProviderController@inicio')->middleware('auth');
	Route::get('/plantas', 'ProviderController@plantas')->middleware('auth');
	Route::get('/tipoPlanta', 'ProviderController@tipoPlanta')->middleware('auth');
	Route::get('/realizados', 'ProviderController@realizados')->middleware('auth');

	Route::post('/tablePlantas', 'ProviderController@tablePlantas')->middleware('auth');
	Route::post('/llenarSelectTipoPlantas', 'ProviderController@llenarSelectTipoPlantas')->middleware('auth');
	Route::post('/plantaAlmacenar', 'ProviderController@plantaAlmacenar')->middleware('auth');
	Route::post('/tableTipoPlantas', 'ProviderController@tableTipoPlantas')->middleware('auth');
	Route::post('/tipoPlantaAlmacenar', 'ProviderController@tipoPlantaAlmacenar')->middleware('auth');
	Route::post('/tablePendientes', 'ProviderController@tablePendientes')->middleware('auth');
	Route::post('/tableSolicitudes', 'ProviderController@tableSolicitudes')->middleware('auth');
	Route::post('/formResponderSolicitud', 'ProviderController@formResponderSolicitud')->middleware('auth');
	Route::post('/pendienteAlmacenar', 'ProviderController@pendienteAlmacenar')->middleware('auth');
	Route::post('/tableRealizados', 'ProviderController@tableRealizados')->middleware('auth');
	//reportes
	Route::get('/sensorReport', 'ReportController@sensorReport')->middleware('auth');
	Route::get('/inventarioReport', 'ReportController@inventarioReport')->middleware('auth');

});

Route::post('/valvula','ApiController@valvula')->middleware('auth');