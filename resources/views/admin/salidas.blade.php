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
        <div class="col-lg-12 col-xs-12 text-center" style="margin-bottom: 5px;">
            <h1>Salidas</h1>
        </div>
    </div>

    <div class="row" style="margin-top: 1%;">
        <div class="col-lg-12">
            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="datatableSalidas">
                <thead>
                    <tr>
                        <th scope="col">Nº</th>
                        <th scope="col">Fecha Hora</th>
                        <th scope="col">Vendedor</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Ver Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salidas as $key => $salida)
                        <tr>
                            <td>{{ $salida->idSalidas }}</td>
                            <td>{{ $salida->fechaHora }}</td>
                            <td>{{ $salida->user->perfilamiento->nombres }} {{ $salida->user->perfilamiento->apellidos }}</td>
                            <td>{{ $salida->cantidadTotal }}</td>
                            <td>{{ $salida->valorTotal }}</td>
                            <td><button class="btn btn-warning" style="margin-top: 2%; margin-bottom: 5%;" data-toggle="modal" data-target="#modalDetalle" type="button" onclick="modal('{{ $salida->idSalidas }}')"><i class="fa fa-eye"></i></button>
                            </td>
                        </tr>
                    @empty
                        <h2>No Hay Salidas Para Mostrar</h2>
                    @endforelse
                 </tbody>
            </table>
        </div>
    </div>
    <form action="">
            <input type="hidden" id="detalles" data-detalles="{{ $detalleSalida }}">
    </form>
<div id="modalDetalle" class="modal fade" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 id="titleModal" class="modal-title"></h4>
      </div>
      <div class="modal-body" style="overflow-y: scroll;height: auto;">
        <form id="formResponderEntrada" method="POST" enctype="multipart/form-data">
            <div id="tableModal"></div>
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
    <script src="{{ asset('js/admin/salidas.js')}}"></script>

    @endsection


@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif