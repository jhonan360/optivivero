@if(auth()->user()->hasRole('Admin'))

    @extends('layouts.base')

    @section('leftMenu')
        @include('admin.section.leftMenu')
    @endsection

    
    @section('style')
    <!-- DataTables CSS -->
    <link href="{{ asset('/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">
	
    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <link href="{{ asset('/vendor/morrisjs/morris.css')}}" rel="stylesheet">
    @endsection
	    
     @section('content')
    <div class="row">
        <div class="col-lg-12 col-xs-12 text-center">
            <h1>Plantas</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        	<div class="panel panel-default">
                <div class="panel-heading">
                	<input type="date"  id="fecha" name="fecha">
                	<button id="filtro" onclick="buscar()" class="btn btn-success"> buscar<i class="fa fa-search"></i></button>
                  <!-- <option></option> <button></button>--->
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-bar-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
 		</div>
	</div>       
    <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="datatableInicio">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha Hora</th>
                                    <th scope="col">Secciones</th>
                                    <th scope="col">Temperatura</th>
                                    <th scope="col">Humedad</th>
                                </tr>
                            </thead>
                            <tbody>
                             </tbody>
                        </table>
                  </div>
              </div>
        </div>
    </div>
@endsection

@section('javascript')
	<script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{ asset('js/admin/inicio.js')}}"></script>
    <script src="{{ asset('vendor/morrisjs/morris.min.js')}}"></script>
    <script src="{{ asset('vendor/raphael/raphael.min.js')}}"></script>


@endsection

@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif