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
use App\EstadosSolicitudes;
use App\Role;


class UserController extends Controller
{
    public function inicio()
    {
        return view('user.inicio');
    }
    public function usuarios()
    {
        return view('user.usuarios');
    }
    public function plantas()
    {
        return view('user.plantas');
    }
    public function tipoPlanta()
    {
        return view('user.tipoPlanta');
    }
    public function proveedores()
    {
        return view('user.proveedores');
    }
    public function secciones()
    {
        return view('user.secciones');
    }
}