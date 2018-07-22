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
    			'<img src="/'.$user->perfilamiento->imagen.'" style="width: 35px;height: 35px;border-radius: 50%;overflow:hidden;" alt="user-image" class="thumb-sm rounded-circle mr-2"/>
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
                $ruta='img/usuarios/'.$id.'.png';
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

}

