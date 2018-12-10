@if(auth()->user()->hasRole('Admin')||auth()->user()->hasRole('User'))

@extends('layouts.pdf')

@section('title')
	<title>Reporte Sensores</title>
@endsection

@section('styles')
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

@endsection
@section('body')
<div class="container">
	<div class="row">
		<div class="col-lg-12 col-xs-12 text-center">
			<h1> Reporte Sensores Nº {{ $consecutivo }}</h1>
		</div>
	</div>
	<div class="row" style="margin-top: 20px;">
		<div class="col-lg-6 col-xs-6 col-md-6 ">
			<h2> Fecha Inical: {{$fechas[0]}}</h2>
		</div>
		<div class="col-lg-6 col-xs-6 col-md-6 ">
			<h2> Fecha Final: {{$fechas[1]}}</h2>
		</div>
	</div>
	<div class="panel-body">
        <div id="morris-bar-chart"></div>
    </div>
    <div id="prueba"></div>
	<div class="row" style="margin-top: 5px;">
		<table class="table table-striped table-bordered text-center" >
		  <thead>
			    <tr >
			    	<td><b>Promedio</b></td>
				    @foreach ($promedios as $promedio)
				      <td ><b>{{$promedio->nombre}}</b></td>
					@endforeach
			    </tr>
		  </thead>
			<tbody>
				<tr>
				    <td><b>Humedad</b></td>
			      	@foreach ($promedios as $promedio)
	    				<td>{{ $promedio->promHumd}} %</td>
					@endforeach
				</tr>
				<tr>
				    <td><b>Temperatura</b></td>
			      	@foreach ($promedios as $promedio)
	    				<td>{{ $promedio->promTemp}} ºC</td>
					@endforeach
				</tr>
			</tbody>
		</table>
	</div>
	<div class="row" style="margin-top: 20px;">
		<table class="table table-striped table-bordered text-center" >
		  <thead>
			    <tr >
			      <td ><b>Sección</b></td>
			      <td ><b>Tipo</b></td>
			      <td ><b>Dato</b></td>
			      <td ><b>Fecha Hora</b></td>
			    </tr>
		  </thead>
			<tbody>
		      	@foreach ($datos as $dato)

	    			<tr>
	    				<td>{{ $dato->seccion->nombre }}</td>
	    				<td>{{ $dato->tipo }}</td>
	    				@if($dato->tipo=='temperatura')
	    					<td>{{ $dato->dato }} ºC</td>
	    				@else
	    					<td>{{ $dato->dato }} %</td>
	    				@endif
	    				<td>{{ $dato->created_at }}</td>
		    		</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	<form action="">
        <input type="hidden" id="grafica" data-grafica="{{ $grafica }}">
     </form>
</div>
@endsection
@section('scripts')
    <script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/morrisjs/morris.min.js"></script>
    <script src="vendor/raphael/raphael.min.js"></script>
    <script type="text/javascript">

    	var grafica = $('#grafica').data('grafica');
            console.log(grafica);
            if(grafica.length>0){
                Morris.Bar({
                element: 'morris-bar-chart',
                data: grafica,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Prom. Humedad', 'Prom. Temperatura'],
                hideHover: 'auto',
                resize: true
                });
            }
    </script>

@endsection
@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver este reporte</h1>
    </div>
@endif