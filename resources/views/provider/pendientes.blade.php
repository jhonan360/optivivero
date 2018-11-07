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
	                        <th scope="col">Responder</th>
	                    </tr>
	                </thead>
	                <tbody>
	                 </tbody>
	            </table>
	        </div>
	    </div>












<div id="modalPendientes" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="titleModal" class="modal-title"></h4>
      </div>
      <div class="modal-body" style="overflow-y: scroll;height: auto;">
            <div id="tableModal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<div id="modalResponder" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="titleModal2" class="modal-title"></h4>
      </div>
      <div class="modal-body" style="overflow-y: scroll;height: auto;">
		<form id="formResponderEntrada" method="POST" enctype="multipart/form-data" class="form-inline">
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
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