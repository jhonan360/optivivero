<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Storage;
use File;
use \Response;
use App\TipoPlantaProveedor;
use App\Proveedores;
use App\PlantasProveedor;
use App\Solicitudes;
use App\EstadosSolicitudes;
use App\DetalleSolicitud;
class ProviderController extends Controller
{
    public function inicio()
    {
        return view('provider.pendientes');
    }
    public function plantas()
    {
        return view('provider.plantas');
    }
    public function tipoPlanta()
    {
        return view('provider.tipoPlanta');
    }
    public function realizados()
    {
        return view('provider.realizados');
    }

    public function tablePedidoPendiente(Request $request)
    {
        $array=[];
        $arrayDetalle=[];
        $solicitudes=Solicitudes::all();
        foreach ($solicitudes as $key => $solicitud) {
            $btn='<button class="btn btn-success" data-toggle="modal" data-target="#modalPendiente"  onclick="openModal('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-eye"></i></button>';
            $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->orderby('created_at','asc')->first();
            array_push($array,array(($key+1).' '.$btn,$solicitud->proveedor->razonSocial,$solicitud->user->perfilamiento->nombres,$solicitud->nombre,$solicitud->fechaHora,$solicitud->cantidadTotal,$solicitud->valorTotal,$estado->estado));
            array_push($arrayDetalle,array(DetalleSolicitud::where('idSolicitud',$solicitud->idSolicitud)->get()));

        }
        return Response::json(array('html' => $array,'matriz'=>$arrayDetalle));

    }
    public function tablePlantas(Request $request)
    {
        $array=[];
       	$id=Proveedores::where('user_id',Auth::user()->id)->first()->idProveedor;
        $plantas=PlantasProveedor::where('idProveedor',$id)->get();
        foreach ($plantas as $key => $planta) {
            $b='  <button class="btn btn-warning" style="margin-top: 2%; margin-bottom: 5%;" data-toggle="modal" data-target="#modalPlantas" type="button" onclick="modal';
            $b.="('".$planta->idPlanta."','".$planta->idTipoPlanta."','".$planta->nombre."','".$planta->valor."')".'">';
            $b.='<i class="fa fa-pencil"></i></button>';

            array_push($array,array(
                $planta->idPlanta,$planta->tipoPlanta->nombre,$planta->nombre,'$'.$planta->valor,$b));
        }
        return Response::json(array('html' => $array));
    }
    public function plantaAlmacenar(Request $request)
    {
        $idPlanta=$_POST['idPlanta'];
       	$id=Proveedores::where('user_id',Auth::user()->id)->first()->idProveedor;
        $tipoPlanta=$_POST['tipoPlanta'];
        $nombre=$_POST['nombre'];
        $valor=$_POST['valor'];
        $param=$_POST['param'];
        if ($param=='update') {
            $planta=PlantasProveedor::where('idPlanta',$idPlanta)->first();
            $planta->idTipoPlanta=$tipoPlanta;
            $planta->nombre=$nombre;
            $planta->valor=$valor;
            $planta->save();
        }else{
            $planta= new PlantasProveedor;
            $planta->idTipoPlanta=$tipoPlanta;
            $planta->idProveedor=$id;
            $planta->nombre=$nombre;
            $planta->valor=$valor;
            $planta->save();
        }
        return Response::json('ok');
    }
    public function llenarSelectTipoPlantas(Request $request)
    {
       	$id=Proveedores::where('user_id',Auth::user()->id)->first()->idProveedor;
        $tipoPlantas=TipoPlantaProveedor::where('idProveedor',$id)->get();
        $html=' <label class="control-label" for="tipoPlanta">Tipo Planta</label>
            <select id="tipoPlanta" name="tipoPlanta" class="form-control">
            <option value="0" selected disable>----</option>
            ';
            foreach ($tipoPlantas as $key => $tipoPlanta) {
                $html.='
                <option value="'.$tipoPlanta->idTipoPlanta.'" >'.$tipoPlanta->nombre.'</option>
                ';
            }
            $html.='</select>';
        return Response::json(array('html' =>  $html));
    }
    public function tableTipoPlantas(Request $request)
    {
        $array=[];
       	$id=Proveedores::where('user_id',Auth::user()->id)->first()->idProveedor;
        $tipoPlantas=TipoPlantaProveedor::where('idProveedor',$id)->get();
        foreach ($tipoPlantas as $key => $tipoPlanta) {
            $b='  <button class="btn btn-warning" style="margin-top: 2%; margin-bottom: 5%;" data-toggle="modal" data-target="#modalTipoPlantas" type="button" onclick="modal';
            $b.="('".$tipoPlanta->idTipoPlanta."','".$tipoPlanta->nombre."','".$tipoPlanta->imagen."')".'">';
            $b.='<i class="fa fa-pencil"></i></button>';

            array_push($array,array(
                $tipoPlanta->idTipoPlanta,$tipoPlanta->nombre,
                '<img src="'.asset($tipoPlanta->imagen).'" style="width: 35px;height: 35px;border-radius: 50%;overflow:hidden;" alt="user-image" class="thumb-sm rounded-circle mr-2"/>
                        ',$b));

        }
        return Response::json(array('html' => $array));
    }
    public function tipoPlantaAlmacenar(Request $request)
    {
        ini_set('memory_limit', '1000M');
        set_time_limit(50);
        $id=$_POST['idTipoPlanta'];
       	$idProveedor=Proveedores::where('user_id',Auth::user()->id)->first()->idProveedor;
        $param=$_POST['param'];
        $nombre=$_POST['nombre'];
        $file = $request->file('file');
        if ($param=='update') {
            if ($file) {
                $ruta='/source/img/tipoPlantas/'.$id.'.png';
                file_put_contents($ruta, File::get($file));
                $query='UPDATE tipoPlantaProveedor SET nombre="'.$nombre.'",imagen="'.$ruta.'" WHERE idTipoPlanta="'.$id.'"';
            }else{
                $query='UPDATE tipoPlantaProveedor SET nombre="'.$nombre.'" WHERE idTipoPlanta="'.$id.'"';

            }
            DB::connection()->getPdo()->exec($query);
        }else{
            $tipoPlanta = new TipoPlantaProveedor;
            $tipoPlanta->nombre=$nombre;
            if ($file) {
                $ruta='source/img/tipoPlantas/'.$id.'.png';
                file_put_contents($ruta, File::get($file));
            }else{
                $ruta='source/img/tipoPlantas/default.png';
            }
            $tipoPlanta->imagen=$ruta;
            $tipoPlanta->idProveedor=$idProveedor;
            $tipoPlanta->save();
        }
            return Response::json('ok');
    }
    public function tableSolicitudes(Request $request)
    {
        $idSolicitud=$_POST['id'];
        $solicitud=Solicitudes::where('idSolicitud',$idSolicitud)->first();
        $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->first();
            if($estado->estado=='Recibido'){
                $estado->estado='Leido';
                $estado->save();
            }
        $detalleSolicitudes=DetalleSolicitud::where('idSolicitud',$idSolicitud)->get();
        $suma=0;
        $html='<div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="tablePlantasModal">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($detalleSolicitudes as $key => $detalleSolicitud) {
            $html.="<tr align='center'><td>" . $detalleSolicitud->planta->nombre . "</td><td>" . $detalleSolicitud->cantidad . "</td><td>".$detalleSolicitud->valor."</td></tr>";
            $suma+=$detalleSolicitud->valor;
        }
        $html.='<tr id="total" align="center"><td scope="col" colspan="2">TOTAL</td><td scope="col">'.$suma.'</td></tr>
            </tbody>
            </table>
            <br>
            <label>Observación</label>
            <textarea rows="6" id="observacion" style="width: 100%;">'.$solicitud->observacion1.'</textarea>
            <label>Respuesta</label>
            <textarea rows="6" id="observacion" style="width: 100%;">'.$solicitud->observacion2.'</textarea>
          </div>';
        return Response::json(array('html' => $html,'solicitud'=>$solicitud));
    }
    public function tablePendientes(Request $request)
    {
        $array=[];
        $arrayDetalle=[];
        $solicitudes=Solicitudes::whereHas('EstadosSolicitudes', function ($query) {
            $query->where('estado', '<>', 'Respondido')->where('estado', '<>', 'Finalizado');
        })->get();
        foreach ($solicitudes as $key => $solicitud) {
            $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->first();
            if($estado->estado=='Enviado'){
                $estado->estado='Recibido';
                $estado->save();
            }
            $btn='<button class="btn btn-success" data-toggle="modal" data-target="#modalPendientes"  onclick="openModal('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-eye"></i></button>';
            $btn2='<button class="btn btn-success" data-toggle="modal" data-target="#modalResponder"  onclick="openModalResponder('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-cart-plus"></i></button>';
            $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->orderby('created_at','desc')->first();
            array_push($array,array(($key+1).' '.$btn,$solicitud->user->perfilamiento->nombres,$solicitud->nombre,$solicitud->fechaHora,$solicitud->cantidadTotal,$solicitud->valorTotal,$btn2));
            array_push($arrayDetalle,array(DetalleSolicitud::where('idSolicitud',$solicitud->idSolicitud)->get()));

        }
        return Response::json(array('html' => $array,'matriz'=>$arrayDetalle));
    }
    public function formResponderSolicitud(Request $request)
    {
        $idSolicitud=$_POST['id'];
        $solicitud=Solicitudes::where('idSolicitud',$idSolicitud)->first();
        $detalleSolicitudes=DetalleSolicitud::where('idSolicitud',$idSolicitud)->get();
        $suma=0;

        $html='<h3> Si la caja de texto esta vacia se va a suponer que se entregara la cantidad </h3>';
            $html.='<div class="form-row">
            ';
        foreach ($detalleSolicitudes as $key => $det) {
            $html.='<input class="form-control col-xs-auto" type="text"  id="name'.$key.'" disabled value="'.$det->planta->nombre.'">
                <input class="form-control col-xs-auto" type="number"  id="cantidad'.$key.'" disabled value="'.$det->cantidad.'">
                <input class="form-control col-xs-auto" type="number"  id="'.$det->idPlanta.'" name="'.$det->idPlanta.'"  placeholder="Ingrese cantidad a entregar">';

        }
        $html.='
            <label>Respuesta</label>
            <textarea rows="6" id="observacion" name="observacion" style="width: 100%;" required></textarea>
            <input class="form-control col-xs-auto" type="text"  id="idS" name="idS" value="'.$idSolicitud.'" style="display:none;">
            <div class="text-center"><input  class="btn btn-success" type="submit"></div>
            ';
        return Response::json(array('html' => $html,'solicitud'=>$solicitud));
    }
    public function pendienteAlmacenar(Request $request)
    {
        $array=$_POST['array'];
        $idSolicitud=$_POST['idS'];
        $observacion=$_POST['observacion'];
        $cantidadTotalPagar=0;
        $valorTotalPagar=0;
        foreach ($array as $key => $a) {
            if ($a["name"]!="observacion" && $a["name"]!="idS") {
                $detalleSolicitud=DetalleSolicitud::where('idSolicitud',$idSolicitud)->where('idPlanta',$a["name"])->first();
                if ($a["value"]=="") {
                    //$detalleSolicitud->cantidadPagar=$detalleSolicitud->cantidad;
                    $cantidadPagar=$detalleSolicitud->cantidad;
                }else{
                    //$detalleSolicitud->cantidadPagar=$a["value"];
                    $cantidadPagar=$a["value"];
                }
                $planta=PlantasProveedor::where('idPlanta',$a["name"])->first();
                //$detalleSolicitud->valorPagar=($a["value"]*$planta->valor);
                $valorPagar=($cantidadPagar*$planta->valor);

                $cantidadTotalPagar+=$cantidadPagar;
                $valorTotalPagar+=$valorPagar;
                //$detalleSolicitud->save();
                DetalleSolicitud::where('idSolicitud',$idSolicitud)->where('idPlanta',$a["name"])->update(['cantidadPagar' => $cantidadPagar,'valorPagar' => $valorPagar]);

            }
        }
        $solicitud=Solicitudes::where('idSolicitud',$idSolicitud)->first();
        $solicitud->cantidadTotalPagar=$cantidadTotalPagar;
        $solicitud->valorTotalPagar=$valorTotalPagar;
        $solicitud->observacion2=$observacion;
        $solicitud->save();
        $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->first();
        $estado->estado='Respondido';
        $estado->save();
        return Response::json('ok');
    }
    public function tableRealizados(Request $request)
    {
        $array=[];
        $arrayDetalle=[];
        $solicitudes=Solicitudes::whereHas('EstadosSolicitudes', function ($query) {
            $query->where('estado', 'Respondido')->orwhere('estado','Finalizado');
        })->get();
        foreach ($solicitudes as $key => $solicitud) {
            $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->first();
            if($estado->estado=='Enviado'){
                $estado->estado='Recibido';
                $estado->save();
            }
            $btn='<button class="btn btn-success" data-toggle="modal" data-target="#modalPendientes"  onclick="openModal('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-eye"></i></button>';
            $btn2='<button class="btn btn-success" data-toggle="modal" data-target="#modalResponder"  onclick="openModalResponder('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-cart-plus"></i></button>';
            $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->orderby('created_at','desc')->first();
            array_push($array,array(($key+1).' '.$btn,$solicitud->user->perfilamiento->nombres,$solicitud->nombre,$solicitud->fechaHora,$solicitud->cantidadTotal,$solicitud->valorTotal,$estado->estado.' '.$btn2));
            array_push($arrayDetalle,array(DetalleSolicitud::where('idSolicitud',$solicitud->idSolicitud)->get()));

        }
        return Response::json(array('html' => $array,'matriz'=>$arrayDetalle));
    }
}
