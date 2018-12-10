<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\AlmacenDatos;
use App\Secciones;
use App\Reportes;
use App\Plantas;
use stdClass;
use PDF;

class ReportController extends Controller
{
    public function sensorReport(Request $request)
    {
    	$fechaIni=$request->input('fechaIni');
    	$fechaFin=$request->input('fechaFin');
    	$datosAlmacen=AlmacenDatos::whereDate('created_at','>=',$fechaIni)->whereDate('created_at','<=',$fechaFin)->orderby('created_at','desc')->get();
    	//logica grafica

        $secciones=Secciones::all();
        $seccionesTabla=[];
        $grafica=[];
        foreach ($secciones as $key => $seccion) {
            $countTemp=0;
            $countHum=0;
            $sumHum=0;
            $sumTemp=0;

            $datos=AlmacenDatos::whereDate('created_at','>=',$fechaIni)->whereDate('created_at','<=',$fechaFin)->where('idSeccion',$seccion->idSeccion)->get();

            if (count($datos)>0) {
                foreach ($datos as $key => $dato) {
                     if ($dato->tipo=='humedad') {
                         $sumHum+=$dato->dato;
                         $countHum+=1;
                     }else {
                         $sumTemp+=$dato->dato;
                         $countTemp+=1;
                     }
                 }
                $object=new stdClass();
                $object->y=$fechaIni.", ".$fechaFin." S. ".$dato->seccion->nombre;
                $object->a=0;
                if ($sumHum!=0) {
                    $object->a=($sumHum/$countHum);
                }
                $object->b=0;
                if ($sumTemp) {
                    $object->b=($sumTemp/$countTemp);
                }
                $seccion->promTemp=$object->a;
                $seccion->promHumd=$object->b;

                array_push($seccionesTabla,$seccion);
                array_push($grafica,$object);
              }
        }
        $reporte=Reportes::where('tipo','sensores')->orderby('consecutivo','desc')->first();
        if ($reporte==null) {
            $consecutivo=1;
        }else{
            $consecutivo=$reporte->consecutivo+1;
        }
        $newReporte = Reportes::Create(['tipo'=>'sensores','consecutivo'=>$consecutivo]);
        $data = array('datos' => $datosAlmacen,'grafica'=>json_encode($grafica,true),'promedios'=>$seccionesTabla,'fechas'=>array($fechaIni,$fechaFin),'consecutivo'=>$consecutivo);
		PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('report.sensorReport', $data);
		$namefile='Reporte Sensores Nº '.$consecutivo.'.pdf';
		return $pdf->setPaper('A4')->stream($namefile);
    	//return view('report.sensorReport', $data);
    }
    public function inventarioReport(Request $request){
        $secciones=Secciones::all();
        foreach ($secciones as $key => $seccion) {
            $cantidadReal = DB::select("SELECT SUM(cantidad) AS 'count' FROM detallesecciones WHERE idSeccion='".$seccion->idSeccion."'GROUP by idSeccion");
            if ($cantidadReal==null) {
                $cantidadReal=0;
            }else{
                $cantidadReal=$cantidadReal[0]->count;
            }
            $seccion->cantidadReal=$cantidadReal;
        }
        $plantas=Plantas::all();
        $reporte=Reportes::where('tipo','plantas')->orderby('consecutivo','desc')->first();
        $consecutivo=1;
        if ($reporte!=null) {
            $consecutivo=$reporte->consecutivo+1;
        }
        $newReporte = Reportes::Create(['tipo'=>'plantas','consecutivo'=>$consecutivo]);
        $data = array('secciones' => $secciones,'consecutivo' => $consecutivo,'fecha'=>Date('d-m-Y'),'plantas'=>$plantas);
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('report.inventarioReport', $data);
        $namefile='Reporte Inventario Nº '.$consecutivo.'.pdf';
        return $pdf->setPaper('A4')->stream($namefile);

        //return view('report.inventarioReport', $data);

    }
}
