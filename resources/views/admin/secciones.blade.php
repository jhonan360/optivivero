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
            <h1>Secciones</h1>
        </div>
    </div>

        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <button class="btn-success" data-toggle="modal" data-target="#modalSeccion" type="button" onclick="modal()">Crear seccion</button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="datatableSecciones">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre  de la seccion</th>
                                        <th scope="col">Tipo Planta</th>
                                        <th scope="col">Espacio total</th>
                                        <th scope="col">Observación</th>
                                        <th scope="col">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 </tbody>
                            </table>
                      </div>
                  </div>
            </div>
        </div>
<div id="modalSeccion" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="titleModal" class="modal-title"></h4>
      </div>
      <div class="modal-body" style="overflow-y: scroll;height: 400px;">
            <form id="formSeccion" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre" required>
                        <label for="tipoPlanta">Tipo Planta</label>
                        <select id="tipoPlanta" class="form-control" name="tipoPlanta" required>
                            <option disabled value selected > -- seleccione un tipo de planta -- </option>
                            @foreach($tipoPlantas as $tipoPlanta)
                                <option value="{{$tipoPlanta->idTipoPlanta}}" @if($tipoPlanta->idTipoPlanta == old('tipoPlanta')) selected @endif>{{$tipoPlanta->nombre}}</option>
                            @endforeach
                        </select>
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" placeholder="Ingrese la catidad" required>
                        <label for="observacion">Observación</label>
                        <textarea type="text" class="form-control" id="observacion" name="observacion" placeholder="Ingrese la observación" rows="5" required> </textarea>

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
    <script src="{{ asset('js/admin/seccion.js')}}"></script>

    @endsection


@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif