@if(auth()->user()->hasRole('Admin'))

    @extends('layouts.base')

    @section('leftMenu')
        @include('admin.section.leftMenu')
    @endsection
    @section('style')
    <!-- DataTables CSS -->

    <link rel="stylesheet" href="{{ asset('/css/docsupport/prism.css')}}">
    <link href="{{ asset('/css/chosen.css')}}" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="{{ asset('/vendor/datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('/vendor/datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    @endsection
    @section('content')
        <div class="row">
            <div class="col-lg-4 col-md-4 col-xs-12 text-center">
                <h1>Total Pagar</h1>
            </div>
            <div class="col-lg-8 col-md-8 col-xs-12">
                <input type="text" name="totalPagar" id="totalPagar" style="width: 100%; height: 150px" readonly>
            </div>
        </div>
        <hr>
        <div class="panel panel-default">
            <div class="panel-heading">
        <form id="formAdd">
        <div class="row form-inline">
            <div class="form-group mb-5 ">
                <label for="nombre" >Nombre</label>
                <select id="selectPlanta" data-placeholder="Seleccione Planta" class="chosen-select" tabindex="2" onblur="cargarPlantas(this.value)" required style="width: 100%">
                    <option value=""></option>
                    @foreach ($plantas as $planta)
                        <option value="{{ $planta->idPlanta}}">{{ $planta->idPlanta}} -- {{ $planta->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3 ">
                <label for="valor" >Cantidad</label>
                <input type="number"  class="form-control-plaintext" id="cantidad" style="width:80px">
                <label style="background-color: #e7e7e7; color: black;">/</label>
                <input type="number"  class="form-control-plaintext" id="cantidadDispo" style="width:80px" disabled>

            </div>
            <div class="form-group mb-3 ">
                <label for="valor" >Valor C/U</label>
                <input type="text"  class="form-control-plaintext" id="valor" readonly>
            </div>
            <div class="form-group mb-3 text-center">
                <button type="submit" class="btn btn-primary  ">Agregar Al Carrito <i class="fa fa-shopping-cart"></i></button>
            </div>
        </div>
        </form>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="tableCompra">
                <thead>
                    <tr>
                        <th width="10%"><button type="button" class="btn btn-danger delete-row"  onclick="deleteRow()">Eliminar Articulo <i class="fa fa-trash"></i></button></th>
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
    <form action="">
        <input type="hidden" id="plantas" data-plantas="{{ $plantas }}">
    </form>
    @endsection
    @section('javascript')
        <!-- Select Chosen -->
    <script src="{{ asset('/js/chosen.jquery.js')}}"></script>
    <script src="{{ asset('/js/docsupport/init.js')}}" ></script>
    <!--<script src="{{ asset('/js/docsupport/prism.js')}}" ></script>-->
        <!-- DataTables JavaScript -->
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables-responsive/dataTables.responsive.js')}}"></script>
    <script src="{{ asset('js/admin/ventas.js')}}"></script>


    @endsection


@else
    <div class="col-md-12 col-ls-12 col-sm-12 text-center">
        <h1>No tiene permisos para ver esta página</h1>
    </div>
@endif