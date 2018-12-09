<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Storage;
use File;
use stdClass;
use \Response;
use App\AlmacenDatos;
use App\Entradas;
use App\User;
use App\Perfilamiento;
use App\TipoPlanta;
use App\Plantas;
use App\PlantasProveedor;
use App\Proveedores;
use App\DetalleSolicitud;
use App\DetalleSecciones;
use App\DetalleSalida;
use App\DetalleEntradas;
use App\Solicitudes;
use App\Secciones;
use App\EstadosSolicitudes;
use App\Role;
use App\Salidas;


class AdminController extends Controller
{
    public function inicio()
    {
        $secciones=Secciones::all();
        return view('admin.inicio',['secciones' => $secciones]);
    }
    public function usuarios()
    {
        return view('admin.usuarios');
    }
    public function plantas()
    {
        return view('admin.plantas');
    }
    public function tipoPlanta()
    {
        return view('admin.tipoPlanta');
    }
    public function proveedores()
    {
        return view('admin.proveedores');
    }
    public function reportes()
    {
        return view('admin.reportes');
    }
    public function secciones()
    {
        $tipoPlantas=TipoPlanta::all();
        return view('admin.secciones')->with('tipoPlantas', $tipoPlantas);
    }
    public function entradas()
    {
        return view('admin.entradas');
    }
    public function pedidos()
    {
        $plantas=PlantasProveedor::all();
        $proveedores=Proveedores::all();
        return view('admin.pedidos',['plantas' => $plantas,'proveedores' => $proveedores]);
    }
    public function salidas()
    {
        $salidas=Salidas::all();
        $detalleSalida=DetalleSalida::all();
        return view('admin.salidas',['salidas' => $salidas,'detalleSalida' => $detalleSalida]);
    }
    public function ventas()
    {
        $plantas=Plantas::all();
        $detalleSalida=DetalleSalida::all();
        return view('admin.ventas',['plantas' => $plantas,'detalleSalida' => $detalleSalida]);
    }
    public function tableUser(Request $request)
    {
    	$array=[];
    	$html='';
        $idRolP=Role::where('nombre','Proveedor')->first()->idRol;
        $idRolS=Role::where('nombre','SuperAdmin')->first()->idRol;
        $idRolA=Role::where('nombre','Auditor')->first()->idRol;
    	$users=User::where('idRol','<>',$idRolP)->where('idRol','<>',$idRolS)->where('idRol','<>',$idRolA)->get();
    	foreach ($users as $key => $user) {
    		$chk="";
            if ($user->estado=='true') {
                    $chk="checked";
                }
            if ($user->role->nombre=='User') {
                $a='<label class="switch" >';
                $a.='<input type="checkbox" '.$chk.' id="chk'.$key.'" name="chk'.$key.'" onclick="switchEstado(this.name,';
                $a.="'".$user->id."'";
                $a.=')"><span class="slider round"></span>
                </label>';
            }else{
                $a='';
            }
            $b='  <button class="btn btn-warning" style="margin-top: 2%; margin-bottom: 5%;" data-toggle="modal" data-target="#modalUsuarios" type="button" onclick="modal';
            $b.="('".$user->email."','".$user->perfilamiento->cedula."','".$user->perfilamiento->nombres."','".$user->perfilamiento->apellidos."','".$user->perfilamiento->telefono."','".$user->perfilamiento->direccion."')".'">';
            $b.='<i class="fa fa-pencil"></i></button>';

    		array_push($array,array(
    			$user->perfilamiento->nombres.' '.$user->perfilamiento->apellidos,$user->email,$user->role->nombre,$user->perfilamiento->cedula,$user->perfilamiento->telefono,$user->perfilamiento->direccion,
    			'<img src="'.asset($user->perfilamiento->imagen).'" style="width: 35px;height: 35px;border-radius: 50%;overflow:hidden;" alt="user-image" class="thumb-sm rounded-circle mr-2"/>',$a,$b));

    	}
    	return Response::json(array('html' => $array));
    }
    public function estadoUsuario(Request $request)
    {
        $id=$_POST['id'];
        $estado=$_POST['estado'];
        $user=User::where('id',$id)->first();
        $user->estado=$estado;
        $user->save();
        return Response::json(array('html' => $user));

    }

    public function usuarioAlmacenar(Request $request)
    {
        ini_set('memory_limit', '1000M');
        set_time_limit(50);
        $email=$_POST['email'];
        $password=bcrypt($_POST['password']);
        $param=$_POST['param'];
        $cedula=$_POST['cedula'];
        $nombres=$_POST['nombres'];
        $apellidos=$_POST['apellidos'];
        $telefono=$_POST['telefono'];
        $direccion=$_POST['direccion'];
        $file = $request->file('file');
        if ($param=='update') {
            $user=User::where('email',$email)->first();
            $id=$user->id;
            if ($_POST['password']!='') {
                $user->password=$password;
            }
            $user->save();

            if ($file) {
                $ruta='source/img/users/'.$id.'.png';
                file_put_contents($ruta, File::get($file));
                $query='UPDATE perfilamiento SET nombres="'.$nombres.'",apellidos="'.$apellidos.'",telefono="'.$telefono.'",direccion="'.$direccion.'",imagen="'.$ruta.'" WHERE user_id="'.$id.'"';
            }else{
                $query='UPDATE perfilamiento SET nombres="'.$nombres.'",apellidos="'.$apellidos.'",telefono="'.$telefono.'",direccion="'.$direccion.'" WHERE user_id="'.$id.'"';
            }
            DB::connection()->getPdo()->exec($query);
        }else{
            $user = new User;
            $user->email=$email;
            $user->idRol=1;
            $user->password=$password;
            $user->save();
            $user=User::where('email',$email)->first();
            $id=$user->id;
            if ($file) {
                $ruta='source/img/users/'.$id.'.png';
                file_put_contents($ruta, File::get($file));
            }else{
                $ruta='source/img/users/default.png';
            }
            $perfilamiento = new Perfilamiento;
            $perfilamiento->user_id=$user->id;
            $perfilamiento->cedula=$cedula;
            $perfilamiento->nombres=$nombres;
            $perfilamiento->apellidos=$apellidos;
            $perfilamiento->telefono=$telefono;
            $perfilamiento->direccion=$direccion;
            $perfilamiento->imagen=$ruta;
            $perfilamiento->save();
        }
            return Response::json('ok');
    }
    public function llenarSelectTipoPlantas(Request $request)
    {
        $tipoPlantas=TipoPlanta::all();
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
    public function tablePlantas(Request $request)
    {
        $array=[];
        $plantas=Plantas::all();
        foreach ($plantas as $key => $planta) {
            $b='  <button class="btn btn-warning" style="margin-top: 2%; margin-bottom: 5%;" data-toggle="modal" data-target="#modalPlantas" type="button" onclick="modal';
            $b.="('".$planta->idPlanta."','".$planta->idTipoPlanta."','".$planta->nombre."','".$planta->cantidad."','".$planta->valor."')".'">';
            $b.='<i class="fa fa-pencil"></i></button>';

            $c=money_format('%.0n',$planta->valor);

            //array_push($array,array($planta->idPlanta,$planta->tipoPlanta->nombre,$planta->nombre,$planta->cantidad,'$'.$planta->valor,$b));
            array_push($array,array($planta->idPlanta,$planta->tipoPlanta->nombre,$planta->nombre,$planta->cantidad,$c,$b));

        }
        return Response::json(array('html' => $array));

    }
    public function plantaAlmacenar(Request $request)
    {
        $idPlanta=$_POST['idPlanta'];
        $tipoPlanta=$_POST['tipoPlanta'];
        $nombre=$_POST['nombre'];
        $valor=$_POST['valor'];
        $param=$_POST['param'];
        if ($param=='update') {
            $planta=Plantas::where('idPlanta',$idPlanta)->first();
            $planta->idTipoPlanta=$tipoPlanta;
            $planta->nombre=$nombre;
            $planta->valor=$valor;
            $planta->save();
        }else{
            $planta= new Plantas;
            $planta->idTipoPlanta=$tipoPlanta;
            $planta->nombre=$nombre;
            $planta->cantidad=0;
            $planta->valor=$valor;
            $planta->save();
        }
        return Response::json('ok');
    }
    public function tableTipoPlantas(Request $request)
    {
        $array=[];
        $tipoPlantas=TipoPlanta::all();
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
        $param=$_POST['param'];
        $nombre=$_POST['nombre'];
        $file = $request->file('file');
        if ($param=='update') {
            if ($file) {
                $ruta='source/img/tipoPlantas/'.$id.'.png'; //Ruta de la imagen sin slash
                file_put_contents($ruta, File::get($file));
                $query='UPDATE tipoPlanta SET nombre="'.$nombre.'",imagen="'.$ruta.'" WHERE idTipoPlanta="'.$id.'"';
            }else{
                $query='UPDATE tipoPlanta SET nombre="'.$nombre.'" WHERE idTipoPlanta="'.$id.'"';

            }
            DB::connection()->getPdo()->exec($query);
        }else{
            $tipoPlanta = new TipoPlanta;
            $tipoPlanta->nombre=$nombre;
            if ($file) {
                $ruta='source/img/tipoPlantas/'.$id.'.png';
                file_put_contents($ruta, File::get($file));
            }else{
                $ruta='source/img/tipoPlantas/default.png';
            }
            $tipoPlanta->imagen=$ruta;
            $tipoPlanta->save();
        }
            return Response::json('ok');
    }
    public function hacerPedido(Request $request){
        $nombre=$_POST['nombre'];
        $idProveedor=$_POST['idProveedor'];
        $observacion=$_POST['observacion'];
        $tableContent=$_POST['tableContent'];
        $cantidadTotal=0;
        $valorTotal=0;
        for ($i=0; $i <count($tableContent); $i++) {
            $cantidadTotal+=$tableContent[$i]['cantidad'];
            $valorTotal+=$tableContent[$i]['valor'];
        }
        $solicitud= new Solicitudes;
        $solicitud->user_id=Auth::user()->id;
        $solicitud->idProveedor=$idProveedor;
        $solicitud->nombre=$nombre;
        $solicitud->fechaHora=Date('Y-m-d H:i:s');
        $solicitud->cantidadTotal=$cantidadTotal;
        $solicitud->valorTotal=$valorTotal;
        $solicitud->observacion1=$observacion;
        $solicitud->save();
        $idSolicitud=$solicitud->idSolicitud;
        for ($i=0; $i <count($tableContent); $i++) {
            $detalleSolicitud= new DetalleSolicitud;
            $detalleSolicitud->idSolicitud=$idSolicitud;
            $detalleSolicitud->idPlanta=$tableContent[$i]['id'];
            $detalleSolicitud->cantidad=$tableContent[$i]['cantidad'];
            $detalleSolicitud->valor=$tableContent[$i]['valor'];
            $detalleSolicitud->save();
        }
        $estado= new EstadosSolicitudes;
        $estado->idSolicitud=$idSolicitud;
        $estado->estado='Enviado';
        $estado->fechaHora=Date('Y-m-d H:i:s');
        $estado->save();

        return Response::json('ok');
    }
    public function tablePedido(Request $request)
    {
        $array=[];
        $arrayDetalle=[];
        $solicitudes=Solicitudes::all();
        foreach ($solicitudes as $key => $solicitud) {
            $btn='<button class="btn btn-success" data-toggle="modal" data-target="#modalPedido"  onclick="openModal('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-eye"></i></button>';
            $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->orderby('created_at','desc')->first();
            array_push($array,array(($key+1).' '.$btn,$solicitud->proveedor->razonSocial,$solicitud->user->perfilamiento->nombres,$solicitud->nombre,$solicitud->fechaHora,$solicitud->cantidadTotal,$solicitud->valorTotal,$estado->estado));
            array_push($arrayDetalle,array(DetalleSolicitud::where('idSolicitud',$solicitud->idSolicitud)->get()));

        }
        return Response::json(array('html' => $array,'matriz'=>$arrayDetalle));
    }
    public function tableSolicitudes(Request $request)
    {
        $idSolicitud=$_POST['id'];
        $solicitud=Solicitudes::where('idSolicitud',$idSolicitud)->first();
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
    public function tableProveedores(Request $request)
    {
        $array=[];
        $idRol=Role::where('nombre','Proveedor')->first()->idRol;
        $users=User::where('idRol',$idRol)->get();
        foreach ($users as $key => $user) {
            $proveedor=$user->proveedor;
            $chk="";
            if ($user->estado=='true') {
                    $chk="checked";
                }
            $a='<label class="switch" >';
            $a.='<input type="checkbox" '.$chk.' id="chk'.$key.'" name="chk'.$key.'" onclick="switchEstado(this.name,';
            $a.="'".$user->id."'";
            $a.=')"><span class="slider round"></span>
            </label>';
            $b='  <button class="btn btn-warning" style="margin-top: 2%; margin-bottom: 5%;" data-toggle="modal" data-target="#modalProveedor" type="button" onclick="modal';
            $b.="('".$user->email."','".$proveedor->nit."','".$proveedor->razonSocial."','".$proveedor->telefono."','".$proveedor->direccion."')".'">';
            $b.='<i class="fa fa-pencil"></i></button>';

            array_push($array,array(($key+1),$proveedor->nit,$proveedor->razonSocial,$proveedor->telefono,$proveedor->direccion,$user->email,
                '<img src="'.asset($user->perfilamiento->imagen).'" style="width: 35px;height: 35px;border-radius: 50%;overflow:hidden;" alt="user-image" class="thumb-sm rounded-circle mr-2"/>
                        ',$a,$b));
        }
        return Response::json(array('html' => $array));
    }
    public function proveedorAlmacenar(Request $request)
    {
        ini_set('memory_limit', '1000M');
        set_time_limit(50);
        $email=$_POST['email'];
        $password=bcrypt($_POST['password']);
        $param=$_POST['param'];
        $nit=$_POST['nit'];
        $razonSocial=$_POST['razonSocial'];
        $telefono=$_POST['telefono'];
        $direccion=$_POST['direccion'];
        $file = $request->file('file');
        if ($param=='update') {
            $user=User::where('email',$email)->first();
            $id=$user->id;
            if ($_POST['password']!='') {
                $user->password=$password;
            }
            $user->save();

            if ($file) {
                $ruta='source/img/users/'.$id.'.png';
                file_put_contents($ruta, File::get($file));
                $query='UPDATE perfilamiento SET nombres="'.$razonSocial.'",apellidos="'.$razonSocial.'",telefono="'.$telefono.'",direccion="'.$direccion.'",imagen="'.$ruta.'" WHERE user_id="'.$id.'"';
            }else{
                $query='UPDATE perfilamiento SET nombres="'.$razonSocial.'",apellidos="'.$razonSocial.'",telefono="'.$telefono.'",direccion="'.$direccion.'" WHERE user_id="'.$id.'"';
            }
            DB::connection()->getPdo()->exec($query);
            $query='UPDATE proveedores SET razonSocial='.$razonSocial.',telefono='.$telefono.',direccion='.$direccion.' WHERE user_id="'.$id.'"';

        }else{
            $idRol=Role::where('nombre','Proveedor')->first()->idRol;
            $user = new User;
            $user->email=$email;
            $user->idRol=$idRol;
            $user->password=$password;
            $user->save();
            $user=User::where('email',$email)->first();
            $id=$user->id;
            if ($file) {
                $ruta='source/img/users/'.$id.'.png';
                file_put_contents($ruta, File::get($file));
            }else{
                $ruta='source/img/users/default.png';
            }
            $perfilamiento = new Perfilamiento;
            $perfilamiento->user_id=$user->id;
            $perfilamiento->cedula=$nit;
            $perfilamiento->nombres=$razonSocial;
            $perfilamiento->apellidos=$razonSocial;
            $perfilamiento->telefono=$telefono;
            $perfilamiento->direccion=$direccion;
            $perfilamiento->imagen=$ruta;
            $perfilamiento->save();

            $proveedor= new Proveedores;
            $proveedor->user_id=$id;
            $proveedor->nit=$nit;
            $proveedor->razonSocial=$razonSocial;
            $proveedor->telefono=$telefono;
            $proveedor->direccion=$direccion;
            $proveedor->save();
        }
            return Response::json('ok');
    }
    public function graficaInicio(Request $request)
    {
        $fecha=$_POST['fecha'];
        if ($fecha=='hoy') {
            $fecha=date("Y-m-d");
        }
        $secciones=Secciones::all();
        $array=[];
        $select='SELECT almacenDatos.created_at,secciones.nombre,tipo,dato FROM almacenDatos,secciones WHERE almacenDatos.idSeccion=secciones.idSeccion AND DATE(almacenDatos.created_at)='."'".$fecha."'";
        $table = DB::select($select);
        foreach ($secciones as $key => $seccion) {
            $countTemp=0;
            $countHum=0;
            $sumHum=0;
            $sumTemp=0;

            $datos=AlmacenDatos::whereDate('created_at',$fecha)->where('idSeccion',$seccion->idSeccion)->get();

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
                $object->y=$fecha." S. ".$dato->seccion->nombre;
                $object->a=0;
                if ($sumHum!=0) {
                    $object->a=($sumHum/$countHum);
                }
                $object->b=0;
                if ($sumTemp) {
                    $object->b=($sumTemp/$countTemp);
                }
                array_push($array,$object);
              }
        }
        return Response::json(array('dato' => $array,'table' => $table));


    }
    public function pedirDatos(Request $request)
    {
        $idSeccion=$_POST['seccion'];
        if($idSeccion=='all'){
            $secciones=Secciones::all();
        }else{
            $secciones=Secciones::where('idSeccion',$idSeccion)->get();
        }
        foreach ($secciones as $key => $seccion) {
            $seccion->tomarMuestra='true';
            $seccion->save();
        }
        return Response::json(array('html' => $idSeccion));
    }
    public function tableEntradas(Request $request)
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $array=[];
        $arrayDetalle=[];
        $solicitudes=Solicitudes::whereHas('EstadosSolicitudes', function ($query) {
            $query->where('estado', 'Respondido');
        })->get();
        foreach ($solicitudes as $key => $solicitud) {
            $btn='<button class="btn btn-success" data-toggle="modal" data-target="#modalPedido"  onclick="openModal('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-eye"></i></button>';
            $btn2='<button class="btn btn-success" data-toggle="modal" data-target="#modalPedidoResponder"  onclick="openModal2('."'".$solicitud->idSolicitud."'".')"><i class="fa fa-eye"></i></button>';
            $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->orderby('created_at','desc')->first();
            array_push($array,array(($key+1).' '.$btn,$solicitud->proveedor->razonSocial,$solicitud->user->perfilamiento->nombres,$solicitud->nombre,$solicitud->fechaHora,$solicitud->cantidadTotalPagar,money_format('%.0n',$solicitud->valorTotalPagar),$estado->estado));
            array_push($arrayDetalle,array(DetalleSolicitud::where('idSolicitud',$solicitud->idSolicitud)->get()));
        }
        return Response::json(array('html' => $array,'matriz'=>$arrayDetalle));
    }
    public function modalEntradas(Request $request)
    {
        setlocale(LC_MONETARY, 'en_US.UTF-8');
        $idSolicitud=$_POST['id'];
        $solicitud=Solicitudes::where('idSolicitud',$idSolicitud)->first();
        $detalleSolicitudes=DetalleSolicitud::where('idSolicitud',$idSolicitud)->get();
        $suma=0;
        $html='<div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="tablePlantasModal">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Cantidad Anterior</th>
                                        <th scope="col">Cantidad A Entregar</th>
                                        <th scope="col">Valor Anterior</th>
                                        <th scope="col">Valor </th>
                                        <th scope="col">Precio De Venta </th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($detalleSolicitudes as $key => $detalleSolicitud) {
            $html.="<tr align='center'><td>" . $detalleSolicitud->planta->nombre . "</td><td>" . $detalleSolicitud->cantidad. "</td><td>".$detalleSolicitud->cantidadPagar."</td><td>" . money_format('%.0n',$detalleSolicitud->valor). "</td><td>".money_format('%.0n',$detalleSolicitud->valorPagar)."</td>";
            $planta = Plantas::where('nombre','like','%'.$detalleSolicitud->planta->nombre.'%')->first();
            if ($planta==null) {
                $html.='<td> <input type="number" name="'.$detalleSolicitud->idPlanta.'" id="'.$detalleSolicitud->idPlanta.'" required></td></tr>';
            }else{
                $html.='<td>'.money_format('%.0n',$planta->valor).'</td></tr>';
            }
            $suma+=$detalleSolicitud->valorPagar;
        }
        $html.='<tr id="total" align="center"><td scope="col" colspan="4">TOTAL</td><td scope="col">'.money_format('%.0n',$suma).'</td><td></td></tr>
            </tbody>
            </table>
            <br>
            <label>Observación Pedido</label>
            <textarea rows="6" id="observacion" style="width: 100%;" disabled>'.$solicitud->observacion1.'</textarea>
            <label>Respuesta</label>
            <textarea rows="6"  style="width: 100%;" disabled>'.$solicitud->observacion2.'</textarea>
            <label>Observación Entrada</label>
            <textarea rows="6" id="observacion" style="width: 100%;"></textarea>
            <input id="id" name="id" style="display:none;" value="'.$idSolicitud.'">
            <div class="text-center"><input type="submit" id="confirmarPedido" class="btn btn-success" value="Confirmar Entrada"></div>
          </div>';
        return Response::json(array('html' => $html,'solicitud'=>$solicitud));
    }
    public function responderEntradas(Request $request)
    {
        $idSolicitud=$_POST['id'];
        $observacion=$_POST['observacion'];
        $array=$_POST['array'];
        $solicitud=Solicitudes::where('idSolicitud',$idSolicitud)->first();
        $detalleSolicitudes=DetalleSolicitud::where('idSolicitud',$idSolicitud)->get();
        $plantas=Plantas::all();
        $plantasNombre=[];
        foreach ($plantas as $key => $planta) {
            array_push($plantasNombre,strtoupper($planta->nombre));
        }
        $entrada = new Entradas;
        $entrada->idSolicitud=$idSolicitud;
        $entrada->user_id=Auth::user()->id;
        $entrada->fechaHora=Date('Y-m-d H:i:s');
        $entrada->cantidadTotal=0;
        $entrada->valorTotal=0;
        $entrada->observacion=$observacion;
        $entrada->save();
        $cantidadTotal=0;
        $valorTotal=0;
        foreach ($detalleSolicitudes as $key => $detalle) {
            $cantidadTotal+=$detalle->cantidadPagar;
            $valorTotal+=$detalle->valorPagar;
            if (in_array(strtoupper($detalle->planta->nombre), $plantasNombre)) {
                $planta = Plantas::where('nombre','like','%'.$detalle->planta->nombre.'%')->first();
                $detalleEntrada= new DetalleEntradas;
                $detalleEntrada->idPlanta=$planta->idPlanta;
                $detalleEntrada->idEntrada=$entrada->idEntrada;
                $detalleEntrada->cantidad=$detalle->cantidad;
                $detalleEntrada->valor=$detalle->valor;
                $detalleEntrada->save();
                $planta->cantidad+=$detalle->cantidad;
                $planta->save();
            }else{
                $plantaP= PlantasProveedor::where('nombre','like','%'.$detalle->planta->nombre.'%')->first();
                $tipoP=TipoPlanta::where('nombre',$plantaP->tipoPlanta->nombre)->first();
                if ($tipoP==null) {
                    $tipoP = new TipoPlanta;
                    $tipoP->nombre=$plantaP->tipoPlanta->nombre;
                    $tipoP->save();
                }
                $planta = new Plantas;
                $planta->idTipoPlanta=$tipoP->idTipoPlanta;
                $planta->nombre=$detalle->planta->nombre;
                $planta->cantidad=$detalle->cantidad;
                foreach ($array as $key => $a) {
                    if ($a['name']==$detalle->idPlanta) {
                        $planta->valor=$a['value'];
                    }
                }
                $planta->save();
                $detalleEntrada= new DetalleEntradas;
                $detalleEntrada->idPlanta=$planta->idPlanta;
                $detalleEntrada->idEntrada=$entrada->idEntrada;
                $detalleEntrada->cantidad=$detalle->cantidadPagar;
                $detalleEntrada->valor=$detalle->valorPagar;
                $detalleEntrada->save();
                $planta->cantidad+=$detalle->cantidadPagar;
                $planta->save();
            }
        }
        $entrada->cantidadTotal=$cantidadTotal;
        $entrada->valorTotal=$valorTotal;
        $entrada->save();
        $mensaje="";
        $detalleEntradas= DetalleEntradas::where('idEntrada',$entrada->idEntrada)->get();
        foreach ($detalleEntradas as $key => $dentrada) {
            $testigo=true;
            $cantidad=$dentrada->cantidad;
            $cantidadDis=0;

            $secciones=Secciones::where('vacio','true')->Where('idTipoPlanta',$dentrada->planta->idTipoPlanta)->get();
            $mensaje.=" Iteracion".$key." cantidad ".$cantidad." secciones".count($secciones);
            foreach ($secciones as $key2 => $seccion) {

                if($cantidad>0){
                    $cantidadRealPlanta = DB::select("SELECT SUM(cantidad) As 'count'  FROM detallesecciones WHERE idSeccion='".$seccion->idSeccion."' AND idPlanta='".$dentrada->idPlanta."' GROUP by idSeccion");
                    if ($cantidadRealPlanta==null) {
                        $cantidadRealPlanta=0;
                    }else{
                        $cantidadRealPlanta=$cantidadRealPlanta[0]->count;

                    }
                    $cantidadRealSeccion = DB::select("SELECT SUM(cantidad) AS 'count' FROM detallesecciones WHERE idSeccion='".$seccion->idSeccion."'GROUP by idSeccion");
                    if ($cantidadRealSeccion!=null) {
                        $cantidadRealSeccion=$cantidadRealSeccion[0]->count;
                        $cantidadDis=$seccion->espacioTotal-$cantidadRealSeccion;
                    }else{
                        $cantidadDis=$seccion->espacioTotal;
                    }
                    $mensaje.=" Iteracion".$key." ".$key2;

                    $detalleS=DetalleSecciones::where('idPlanta',$dentrada->idPlanta)->where('idSeccion',$seccion->idSeccion)->first();
                    if ($cantidadDis>=$cantidad) {
                        /*DetalleSecciones::updateOrCreate(
                            ['idPlanta'=>$dentrada->idPlanta,'idSeccion'=>$seccion->idSeccion,'cantidad'=>$cantidadRealPlanta+$cantidad]
                        );*/
                        if ($detalleS!=null) {
                            $detalleS=DetalleSecciones::where('idPlanta',$dentrada->idPlanta)->where('idSeccion',$seccion->idSeccion)->update(['cantidad' => $cantidadRealPlanta+$cantidad]);
                        }else{
                            DetalleSecciones::Create(
                            ['idPlanta'=>$dentrada->idPlanta,'idSeccion'=>$seccion->idSeccion,'cantidad'=>$cantidadRealPlanta+$cantidad]
                            );
                        }
                        if ($cantidadDis==$cantidad) {
                            $cantidad=0;
                            $seccion->vacio='false';
                            $seccion->save();
                        }else{
                            $cantidad-=$cantidadDis;
                        }
                        //falta colocar fecha de actualizacion
                    }else{
                        /*DetalleSecciones::updateOrCreate(
                            [
                                'idPlanta'=>$dentrada->idPlanta,'idSeccion'=>$seccion->idSeccion,'cantidad'=>$cantidadRealPlanta+$cantidadDis
                            ]
                        );*/
                        if ($detalleS!=null) {
                            $detalleS=DetalleSecciones::where('idPlanta',$dentrada->idPlanta)->where('idSeccion',$seccion->idSeccion)->update(['cantidad' => $cantidadRealPlanta+$cantidadDis]);
                        }else{
                            DetalleSecciones::Create(
                                [
                                'idPlanta'=>$dentrada->idPlanta,'idSeccion'=>$seccion->idSeccion,'cantidad'=>$cantidadRealPlanta+$cantidadDis
                                ]
                            );
                        }
                        $cantidad-=$cantidadDis;
                    }
                    //dd($cantidad);
                    //if ($cantidad==0) {
                        //talvez aca se edita seccion
                        //var_dump(" break ");exit();
                        //break;
                    //}
                }
            }
        }
        $estado=EstadosSolicitudes::where('idSolicitud',$solicitud->idSolicitud)->first();
        $estado->estado='Finalizado';
        $estado->save();
        return Response::json(array('html' => $mensaje));
    }
    public function modalSalidas(Request $request)
    {
        $idSalida=$_POST['id'];
        $detalleSalidas=DetalleSalida::where('idSalidas',$idSalida)->get();
        $html='<div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="tableSalidasModal">
                                <thead>
                                    <tr>
                                        <th scope="col">Planta</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        foreach ($detalleSalidas as $key => $detalleSalida) {
            $html.="<tr align='center'><td>" . $detalleSalida->planta->nombre . "</td><td>" . $detalleSalida->cantidad. "</td><td>".$detalleSalida->valor."</td>";
        }
        return Response::json(array('html' => $html));
    }
    public function pagarVenta(Request $request)
    {
        $valorTotal=$_POST['valorTotal'];
        $dinero=$_POST['dinero'];
        $tableContent=$_POST['tableContent'];
        $cantidadTotal=0;
        //$valorTotal=0;
        for ($i=0; $i <count($tableContent); $i++) {
            $cantidadTotal+=$tableContent[$i]['cantidad'];
           // $valorTotal+=$tableContent[$i]['valor'];
        }
        $salida= new Salidas;
        $salida->user_id=Auth::user()->id;
        $salida->fechaHora=Date('Y-m-d H:i:s');
        $salida->cantidadTotal=$cantidadTotal;
        $salida->valorTotal=$valorTotal;
        $salida->dinero=$dinero;
        $salida->save();
        $idSalidas=$salida->idSalidas;
        for ($i=0; $i <count($tableContent); $i++) {
            $cantidad=$tableContent[$i]['cantidad'];
            $idPlanta=$tableContent[$i]['id'];
            $detalleSalida= new DetalleSalida;
            $detalleSalida->idSalidas=$idSalidas;
            $detalleSalida->idPlanta=$tableContent[$i]['id'];
            $detalleSalida->cantidad=$tableContent[$i]['cantidad'];
            $detalleSalida->valor=$tableContent[$i]['valor'];
            $detalleSalida->save();
            $planta=Plantas::where('idPlanta',$tableContent[$i]['id'])->first();
            $planta->cantidad-=$cantidad;
            $planta->save();
            $secciones=Secciones::Where('idTipoPlanta',$planta->idTipoPlanta)->get();
            //var_dump($secciones);exit();
            foreach ($secciones as $key => $seccion) {
                $detallesS=DetalleSecciones::where('idSeccion',$seccion->idSeccion)->where('idPlanta',$idPlanta)->where('cantidad','>',0)->get();
                foreach ($detallesS as $key => $detalleS) {
                    if($cantidad>=0){
                        if ($detalleS->cantidad>=$cantidad) {
                            DetalleSecciones::where('idSeccion',$seccion->idSeccion)->where('idPlanta',$idPlanta)->update(['cantidad' => $detalleS->cantidad-$cantidad]);
                        }else{
                            DetalleSecciones::where('idSeccion',$seccion->idSeccion)->where('idPlanta',$idPlanta)->update(['cantidad' => 0]);
                            $cantidad-=$detalleS->cantidad;
                        }
                        $seccion->vacio='true';
                        $seccion->save();
                    }
                }
            }

        }

        return Response::json('ok');
    }

    public function seccionAlmacenar(Request $request)
    {
        ini_set('memory_limit', '1000M');
        set_time_limit(50);
        $id=$_POST['id'];
        $param=$_POST['param'];
        $nombre=$_POST['nombre'];
        $idtipoPlanta=$_POST['tipoPlanta'];
        $cantidad=$_POST['cantidad'];
        $observacion=$_POST['observacion'];
        $tempMax=$_POST['tempMax'];
        if ($param=='update') {
            $seccion=Secciones::where('idSeccion',$id)->first();
            $query='UPDATE secciones SET nombre="'.$nombre.'",espacioTotal="'.$cantidad.'",observacion="'.$observacion.'",idTipoPlanta="'.$idtipoPlanta.'", tempMax="'.$tempMax.'" WHERE idSeccion="'.$id.'"';
            DB::connection()->getPdo()->exec($query);
        }else{
            $seccion = new Secciones;
            $seccion->idTipoPlanta=$idtipoPlanta;
            $seccion->nombre=$nombre;
            $seccion->espacioTotal=$cantidad;
            $seccion->observacion=$observacion;
            $seccion->tempMax=$tempMax;
            $seccion->save();
        }
        return Response::json('ok');
    }
    public function tableSeccion(Request $request)
    {
        $array=[];
        $html='';
        $secciones=Secciones::all();
        foreach ($secciones as $key => $seccion) {
            $b=' <button class="btn btn-warning" style="margin-top: 2%; margin-bottom: 5%;" data-toggle="modal" data-target="#modalSeccion" type="button" onclick="modal';
            $b.="('".$seccion->idSeccion."','".$seccion->idTipoPlanta."','".$seccion->nombre."','".$seccion->espacioTotal."','".$seccion->observacion."','".$seccion->tempMax."')".'">';
            $b.='<i class="fa fa-pencil"></i></button>';
            array_push($array,array(
                $seccion->nombre,$seccion->tipoPlanta->nombre,$seccion->espacioTotal,$seccion->observacion,$seccion->tempMax.'ºC',$b));
        }
        return Response::json(array('html' => $array));
    }
}