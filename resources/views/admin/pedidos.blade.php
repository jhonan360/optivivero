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
    @endsection
    @section('content')
    <div class="row">
        <div class="col-lg-12 col-xs-12 text-center" style="margin-bottom: 5px;">
            <h1>Pedidos</h1>
        </div>
    </div>

        <div class="row">
                <div class="col-lg-12">
                    <div class="form-inline">
                        <label for="nombre">Nombre </label>
                        <input type="text" class="form-control mb-2 mr-sm-2" id="nombre" placeholder="Nombre pedido">
                        <label for="nombre">Proveedor</label>
                        <select id="selectProveedor" onblur="cargarPlantas(this.value)" required>
                            <option value="0">---</option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->idProveedor }}">{{ $proveedor->razonSocial }} -- {{ $proveedor->nit }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <form id="addPlant">
                                <label for="selectPlanta">Planta </label>
                                <select id="selectPlanta" onchange="showValor(this.value)" required>
                                    <option value disabled selected>---</option>
                                </select>
                                <label for="cantidad">Cantidad </label>
                                <input type="number" id="cantidad" placeholder="Cantidad" required>
                                <label for="valor">Valor </label>
                                <input type="number" id="valor" placeholder="Valor" disabled required>
                                <input type="submit" class="add-row" value="Agregar">
                            <button type="button" class="delete-row" onclick="deleteRow()">Eliminar</button>
                            </form>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="tablePlantas">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 </tbody>
                            </table>
                      </div>
                  </div>
                      <hr>
                      <label for="observacion">Observación</label>
                      <textarea rows="6" id="observacion" style="width: 100%;"></textarea>
                      <div class="text-center">
                        <button class="btn-success btn-lg" onclick="hacerPedido()">Hacer Pedido</button>
                      </div>
            </div>
        </div>
     <form action="">
            <input type="hidden" id="plantas" data-plantas="{{ $plantas }}">
    </form>
    <hr>
    <div class="row" style="margin-top: 1%;">
        <div class="col-lg-12 col-xs-12 text-center" style="margin-bottom: 5px;">
            <h1>Pedidos</h1>
        </div>
    </div>
    <div class="row" style="margin-top: 1%;">
        <div class="col-lg-12">
            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="datatablePedidos">
                <thead>
                    <tr>
                        <th scope="col">Nº</th>
                        <th scope="col">Proveedor</th>
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
<div id="modalPedido" class="modal fade" role="dialog">
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


@endsection
    @section('javascript')

        <!-- DataTables JavaScript -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{ asset('js/admin/pedidos.js')}}"></script>

    @endsection


@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif