@if(auth()->user()->hasRole('Admin')||auth()->user()->hasRole('User'))

    @extends('layouts.base')

    @section('leftMenu')
        @include('admin.section.leftMenu')
    @endsection

    @section('content')
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1>Reportes sensores</h1>
            </div>
        </div>
        <div class="row">
            <form method="post" id="reporteSensores">
                <div class="col-xs-12 col-md-5 text-center">
                    <label for="fechaIni">Fecha Inicial</label>
                    <input type="date"  id="fechaIni" name="fechaIni" required>
                </div>
                <div class="col-xs-12 col-md-5 text-center">
                    <label for="fechaFin">Fecha Final</label>
                    <input type="date"  id="fechaFin" name="fechaFin" required>
                </div>
                <div class="col-xs-12 col-md-2 text-center">
                    <input type="submit" value='Generar' class="btn btn-success btn-lg">
                </div>
            </form>
        </div>
        <hr style="width:100%">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1>Reportes plantas y secciones</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <button class="btn btn-success btn-lg">Generar</button>
            </div>
        </div>
    @endsection



@else
    
@endif