@if(auth()->user()->hasRole('Admin')||auth()->user()->hasRole('User'))

@extends('layouts.pdf')

@section('title')
    <title>Reporte Inventario</title>
@endsection

@section('styles')

@endsection
@section('body')
<div class="container">
    <div class="row">
        <div class="col-lg-12 col-xs-12 text-center">
            <h1> Reporte Inventario Nº {{ $consecutivo }}</h1>
        </div>
    </div>
    <div class="row" style="margin-top: 5px;">
        <div class="col-lg-12 col-xs-12 col-md-12 ">
            <h2> Fecha : {{$fecha}}</h2>
        </div>

    </div>

    <div class="row" style="margin-top: 5px;">
        <h2 class="text-center">Secciones</h2>
        <table class="table table-striped table-bordered text-center" >
          <thead>
                <tr >
                    <td><b>Nº</b></td>
                    <td><b>Nombre</b></td>
                    <td><b>Tipo Planta</b></td>
                    <td><b>Cantidad Existente</b></td>
                    <td><b>Espacio Total</b></td>
                    <td><b>Temperatura Maxima</b></td>
                    <td><b>Observación</b></td>
                </tr>
          </thead>
            <tbody>
                @foreach ($secciones as $key => $seccion)
                    <tr>
                        <td>{{ ($key+1) }} </td>
                        <td>{{ $seccion->nombre }} </td>
                        <td>{{ $seccion->tipoPlanta->nombre }} </td>
                        <td>{{ $seccion->cantidadReal }} </td>
                        <td>{{ $seccion->espacioTotal }} </td>
                        <td>{{ $seccion->tempMax }} </td>
                        <td>{{ $seccion->observacion }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="row" style="margin-top: 5px;">
        <h2 class="text-center">Plantas</h2>
        <table class="table table-striped table-bordered text-center" >
          <thead>
                <tr >
                    <td><b>Nº</b></td>
                    <td><b>Nombre</b></td>
                    <td><b>Tipo Planta</b></td>
                    <td><b>Cantidad Existente</b></td>
                </tr>
          </thead>
            <tbody>
                @foreach ($plantas as $key => $planta)
                    <tr>
                        <td>{{ ($key+1) }} </td>
                        <td>{{ $planta->nombre }} </td>
                        <td>{{ $planta->tipoPlanta->nombre }} </td>
                        <td>{{ $planta->cantidad }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
@endsection
@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver este reporte</h1>
    </div>
@endif