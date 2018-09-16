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
        <div class="col-lg-12 col-xs-12 text-center">
            <h1>Secciones</h1>
        </div>
    </div>

        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             <button class="btn-success" data-toggle="modal" data-target="#modalUsuarios" type="button" onclick="modal()">Crear seccion</button>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="datatablesecciones">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre  de la seccion</th>
                                        <th scope="col">Espacio total</th>
                                        <th scope="col">Observacion</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                 </tbody>
                            </table>
                      </div>
                  </div>
            </div>
        </div>
<div id="modalUsuarios" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="titleModal" class="modal-title"></h4>
      </div>
      <div class="modal-body" style="overflow-y: scroll;height: 400px;">
            <form id="formUsuario" method="POST" enctype="multipart/form-data" >
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Ingrese el correo del usuario" required>
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese la contraseña" required>
                        <label for="repetirPassword">Repertir Password</label>
                        <input type="password" class="form-control" id="repetirPassword" name="repetirPassword" placeholder="Ingrese el correo del usuario" required>
                        <label for="cedula">Cedula</label>
                        <input type="number" class="form-control" id="cedula" name="cedula" placeholder="Ingrese la cedula" required>
                        <label for="nombres">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ingrese los nombres" required>
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ingrese los apellidos" required>
                        <label for="telefono">Teléfono</label>
                        <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Ingrese teléfono" required>
                        <label for="direccion">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Ingrese la dirección de residencia">
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
    <script src="{{ asset('js/admin/usuarios.js')}}"></script>

    @endsection


@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif