$(document).ready(function()
{
	llenarTabla();
});


function llenarTabla()
{
	$('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatableEntradas').DataTable({
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
	var t = $('#datatableEntradas').DataTable();
    t.clear();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/tableEntradas",
		dataType: 'json',
		data: {}
	})
	.done(function(response){
		var array=response.html;
		console.log(array);
		for (var i = 0; i < array.length; i++) {
			t.row.add( [
				array[i][0],
				array[i][1],
				array[i][2],
				array[i][3],
				array[i][4],
                array[i][5],
                array[i][6],
                array[i][7],
	        ] ).draw( false );

		}
	});
}
function openModal(id)
{
	$.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/modalEntradas",
            dataType: 'json',
            data: { id: id}
            })
        .done(function(response){
			console.log(response.html);
			$("#tableModal").html(response.html);
			$("#titleModal").html('<h4 id="titleModal" class="modal-title">Pedido '+response.solicitud.nombre+'</h4>');
        }).fail(function(response) {
			$("#tableModal").html('No se puede cargar el contenido de la modal');
        });
}
$("#formResponderEntrada").on("submit", function(e){
    console.log( $( this ).serializeArray() );
    e.preventDefault();
    var array=$( this ).serializeArray();
    var id=$("#id").val();
    var observacion=$("#observacion").val();
    $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/responderEntradas",
            dataType: 'json',
            data: { id: id,array:array,observacion:observacion}
            })
        .done(function(response){
            llenarTabla();
            $('#modalResponder').modal('toggle');
        }).fail(function(response) {
            alert('No se confirmo la entrada');
        });
});