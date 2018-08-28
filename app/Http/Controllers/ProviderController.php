<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function inicio()
    {
        return view('provider.pendientes');
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
}
