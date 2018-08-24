<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Storage;
use File;
use date;
use \Response;
use App\AlmacenDatos;
use App\Parametros;
use App\Secciones;

class ApiController extends Controller
{
    public function variables(Request $request)
    {
    	$ahora=date("H:i:s");
    	$h1=Parametros::where('nombre','hora 1')->first()->dato;
    	$h2=Parametros::where('nombre','hora 2')->first()->dato;
    	$h3=Parametros::where('nombre','hora 3')->first()->dato;
    	$h4=Parametros::where('nombre','hora 4')->first()->dato;
    	$seccion=Secciones::where('idseccion',$_POST['idseccion'])->first();
    	$tomarMuestra=$seccion->tomarMuestra;
    	if ($h1==$ahora||$h2==$ahora||$h3==$ahora||$h4==$ahora||$tomarMuestra=='true') {
    		$temperatura1=$_POST['temp1'];
			$humedad=$_POST['humedad'];
	    	$almacen = new AlmacenDatos;
	    	$almacen->idSeccion=$_POST['idseccion'];
	    	$almacen->tipo='humedad';
	    	$almacen->dato=$humedad;
	    	$almacen->save();
			$almacen = new AlmacenDatos;
	    	$almacen->idSeccion=$_POST['idseccion'];
	    	$almacen->tipo='temperatura';
	    	$almacen->dato=$temperatura1;
	    	$almacen->save();
	    	if ($tomarMuestra=='true') {
	    		$seccion->tomarMuestra='false';
	    		$seccion->save();
	    	}


    	}
		
    }    
    public function prueba(Request $request)
    {
    	return date("H:i:s");
		
		$temperatura1=$_GET['temp1'];
		$humedad=$_GET['humedad'];
    	$almacen = new AlmacenDatos;
    	$almacen->idSeccion=1;
    	$almacen->tipo='humedad';
    	$almacen->dato=$humedad;
    	$almacen->save();
		$almacen = new AlmacenDatos;
    	$almacen->idSeccion=1;
    	$almacen->tipo='temperatura';
    	$almacen->dato=$temperatura1;
    	$almacen->save();
    }
}
