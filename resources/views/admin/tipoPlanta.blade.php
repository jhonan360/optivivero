@if(auth()->user()->hasRole('Admin')||auth()->user()->hasRole('User'))

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
        <div class="col-lg-12 col-xs-12 text-center">
            <h1>Plantas</h1>
        </div>
    </div>

        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <button class="btn-success" data-toggle="modal" data-target="#modalTipoPlantas" type="button" onclick="modal()">Crear Tipo De Planta</button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="datatableTipoPlantas">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 </tbody>
                            </table>
                      </div>
                  </div>
            </div>
        </div>
<div id="modalTipoPlantas" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="titleModal" class="modal-title"></h4>
      </div>
      <div class="modal-body" >
            <form id="formTipoPlantas" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <input type="text" class="form-control" id="idTipoPlanta" style="display: none">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre de la planta" required>
                        <label for="file"    class="control-label">Fotografia</label>
                        <input type="file" accept="image/*" name="file" id="file" onchange="extension();">
                    </div>
                   <div class="text-center">
                     <input id="btnModal1" class="btn btn-success" type="submit">
                   </div>
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
    <script src="{{ asset('js/admin/tipoPlanta.js')}}"></script>

    @endsection


@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif