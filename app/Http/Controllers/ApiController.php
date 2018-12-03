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
use App\valvula;

class ApiController extends Controller
{
    public function variables(Request $request)
    {
    	$ahora=date("H:i:s");
    	$h1=Parametros::where('nombre','hora 1')->first()->dato;
    	$h2=Parametros::where('nombre','hora 2')->first()->dato;
    	$h3=Parametros::where('nombre','hora 3')->first()->dato;
    	$h4=Parametros::where('nombre','hora 4')->first()->dato;
        $temperatura1=$_POST['temp1'];

    	$seccion=Secciones::where('idseccion',$_POST['idseccion'])->first();
    	$tomarMuestra=$seccion->tomarMuestra;
    	if ($h1==$ahora||$h2==$ahora||$h3==$ahora||$h4==$ahora||$tomarMuestra=='true') {
			$humedad=$_POST['humedad'];
	    	$almacen = new AlmacenDatos;
	    	$almacen->idSeccion=$_POST['idseccion'];
	    	$almacen->tipo='humedad'  ;
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

            
            if ($temperatura1>=$seccion->tempMax) {
                $seccion->valvula=1;
                $seccion->save();
                echo "C=".$seccion->valvula;

            }else{
                $seccion->valvula=0;
                $seccion->save();
                echo "C=".$seccion->valvula;
                if ($seccion->valvulaBoton==1) {
                    echo "C=".$seccion->valvulaBoton;
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
    public function valvula(request $request)
    {
        $seccion=Secciones::where('idseccion',$_POST['seccion'])->first();
        $estado=$seccion->valvulaBoton;
        if ($estado==0) {
            $seccion->valvulaBoton=1;
        }else{
            $seccion->valvulaBoton=0;
        }
        $seccion->save();
        return redirect('/admin');
    }
}
