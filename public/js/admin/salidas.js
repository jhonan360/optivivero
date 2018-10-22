var detalles = $('#detalles').data('detalles');
console.log(detalles	);
$(document).ready(function()
{
	llenarTabla();
});

function modal(id){
	$.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/tableSalidas",
            dataType: 'json',
            data: { id: id}
            })
        .done(function(response){
			console.log(response.html);
			$("#tableModal").html(response.html);
			$("#titleModal").html('<h4 id="titleModal" class="modal-title">Detalle Salida Número '+id+'</h4>');
        }).fail(function(response) {
			$("#tableModal").html('No se puede cargar el contenido de la tabla');
        });
}

function getDetalles(planta) {
    return detalles.idSalidas == this.idSalidas
}

function llenarTabla()
{
	$('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatableSalidas').DataTable({
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
	var t = $('#datatableSalidas').DataTable();
    t.clear();
}