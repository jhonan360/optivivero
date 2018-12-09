<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AlmacenDatos;
use App\Secciones;
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
        //var_dump($seccionesTabla);exit();
        //return Response::json(array('dato' => $array,'table' => $table));

        $data = array('datos' => $datosAlmacen,'grafica'=>json_encode($grafica,true),'promedios'=>$seccionesTabla,'fechas'=>array($fechaIni,$fechaFin));
		//return view('pdf.documento_equivalente', $data);
		PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif','isJavascriptEnabled'=>'true']);
		$pdf = PDF::loadView('report.sensorReport', $data);

		//$namefile='Documento Equivalente Nº '.$reporteDE->id.'.pdf';
		$namefile='Prueba Nº 1.pdf';
		return $pdf->setPaper('A4')->stream($namefile);

    	return view('report.sensorReport', $data);
    }
}
