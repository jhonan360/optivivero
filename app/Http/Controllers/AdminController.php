<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Storage;
use File;
use \Response;
use App\User;
use App\Perfilamiento;
use App\TipoPlanta;
use App\Plantas;
use App\Proveedores;
use App\DetalleSolicitud;
use App\Solicitudes;


class AdminController extends Controller
{
    public function inicio()
    {
        return view('admin.inicio');
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
    public function pedidos()
    {
        $plantas=Plantas::all();
        $proveedores=Proveedores::all();
        return view('admin.pedidos',['plantas' => $plantas,'proveedores' => $proveedores]);
    }
    public function tableUser(Request $request)
    {
    	$array=[];
    	$html='';
    	$users=User::all();
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
    			'<img src="'.asset($user->perfilamiento->imagen).'" style="width: 35px;height: 35px;border-radius: 50%;overflow:hidden;" alt="user-image" class="thumb-sm rounded-circle mr-2"/>
                        ',$a,$b));

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

            array_push($array,array(
                $planta->idPlanta,$planta->tipoPlanta->nombre,$planta->nombre,$planta->cantidad,'$'.$planta->valor,$b));

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
                $ruta='source/img/tipoPlantas/'.$id.'.png';
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
        $solicitud->FechaHora=Date('Y-m-d H:i:s');
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
        return Response::json('ok');
    }
}

