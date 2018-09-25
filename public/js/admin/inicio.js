$(document).ready(function()
{
    grafica('hoy');
});

function grafica(fecha) {
    if (fecha==undefined) {
        fecha=$("#fecha").val();
    }
    $("#morris-bar-chart").empty();
    $('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatableUser').DataTable({
        destroy: true,
        responsive: true,
        language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    },
    });
    var t = $('#datatableInicio').DataTable();
    t.clear();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: "POST",
        url: "/admin/graficaInicio",
        dataType: 'json',
        data: { fecha: fecha,
            }
        })
        .done(function(response){
            dato=response.dato;
            if(dato.length>0){
                Morris.Bar({
                element: 'morris-bar-chart',
                data: dato,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Prom. Humedad', 'Prom. Temperatura'],
                hideHover: 'auto',
                resize: true
                });
            }
            var array=response.table;
            for (var i = 0; i < array.length; i++) {
                t.row.add( [
                    array[i].created_at,
                    array[i].nombre,
                    array[i].tipo,
                    array[i].dato,
                ] ).draw( false );
            }
        }).fail(function(response) {
            alert('No se pudó grafica.');
        });
}
$("#formSeccion").on("submit", function(e){
    seccion=$("#seccion").val();
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: "POST",
        url: "/admin/pedirDatos",
        dataType: 'json',
        data: {seccion:seccion}
        })
        .done(function(response){
            grafica('hoy');
    });

    return false;
});
