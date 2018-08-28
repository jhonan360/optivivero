@if(auth()->user()->hasRole('Proveedor'))

    @extends('layouts.base')

    @section('leftMenu')
        @include('provider.section.leftMenu')
    @endsection


    @section('content')
    	<div class="row" style="margin-top: 1%;">
	        <div class="col-lg-12 col-xs-12 text-center" style="margin-bottom: 5px;">
	            <h1>Pedidos Pendientes</h1>
	        </div>
    	</div>
	    <div class="row" style="margin-top: 1%;">
	        <div class="col-lg-12">
	            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="datatablePendientes">
	                <thead>
	                    <tr>
	                        <th scope="col">Nº</th>
	                        <th scope="col">Usuario</th>
	                        <th scope="col">Nombre</th>
	                        <th scope="col">Fecha</th>
	                        <th scope="col">Cantidad</th>
	                        <th scope="col">Valor</th>
	                        <th scope="col">Estado</th>
	                    </tr>
	                </thead>
	                <tbody>
	                 </tbody>
	            </table>
	        </div>
	    </div>
    @endsection
	@section('javascript')

        <!-- DataTables JavaScript -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{ asset('js/provider/pendientes.js')}}"></script>

    @endsection
@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif