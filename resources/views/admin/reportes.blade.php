@if(auth()->user()->hasRole('Admin')||auth()->user()->hasRole('User'))

    @extends('layouts.base')

    @section('leftMenu')
        @include('admin.section.leftMenu')
    @endsection
    @section('style')
        <style >
            hr.style-five {
                border: 0;
                height: 0; /* Firefox... */
                box-shadow: 0 0 10px 1px black;
                margin-top: 60px;
                margin-bottom: 40px;
            }
                hr.style-five:after {  /* Not really supposed to work, but does */
                content: "\00a0";  /* Prevent margin collapse */
            }
            h1{
                margin-bottom: 30px;
            }
        </style>
    @endsection
    @section('content')
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1>Reportes sensores</h1>
            </div>
        </div>
        <div class="row">
            <form   id="reporteSensores">
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
        <hr class="style-five" >
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1>Reportes plantas y secciones</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 text-center">
                <button class="btn btn-success btn-lg" onclick="inventario()">Generar</button>
            </div>
        </div>
    @endsection
    @section('javascript')
        <script >
            $("#reporteSensores").on("submit", function(e){
                e.preventDefault();
                fechaIni=$("#fechaIni").val();
                fechaFin=$("#fechaFin").val();
                if(fechaIni>fechaFin){
                    alert("La fecha final debe ser mayor que la fecha inicial");
                }else{
                    window.open("sensorReport?fechaIni="+fechaIni+"&fechaFin="+fechaFin);
                }
                return false;
            });
            function inventario(){
                window.open("inventarioReport/");
            }
        </script>
    @endsection


@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif