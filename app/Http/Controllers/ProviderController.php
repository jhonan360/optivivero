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

    public function tablePedidoPendiente(Request $request)
    {
        $array=[];
        $arrayDetalle=[];
        $solicitudes=Solicitudes::all();
        foreach ($solicitudes as $key => $solicitud) {
            $btn='<button class="btn btn-success" data-toggle="modal" data-target="#modalPedido"  onclick="openModal('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-eye"></i></button>';
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
}
