$(document).ready(function()
{
	llenarTabla();
});

function llenarTabla()
{
	$('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatableRealizados').DataTable({
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
    var t = $('#datatableRealizados').DataTable();
    t.clear();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/provider/tableRealizados",
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
	        ] ).draw( false );

		}
	});
}
function openModal(id)
{
    $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/provider/tableSolicitudes",
            dataType: 'json',
            data: { id: id}
            })
        .done(function(response){
            $("#tableModal").html(response.html);
            $("#titleModal").html('<h4 id="titleModal" class="modal-title">Pedido '+response.solicitud.nombre+'</h4>');
        }).fail(function(response) {
            $("#tableModal").html('No se puede cargar el contenido de la tabla');
        });
}
function openModalResponder(id)
{
    $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/provider/formResponderSolicitud",
            dataType: 'json',
            data: { id: id}
            })
        .done(function(response){
            $("#formResponder").html(response.html);
            $("#titleModal").html('<h4 id="titleModal" class="modal-title">Pedido '+response.solicitud.nombre+'</h4>');
        }).fail(function(response) {
            $("#tableModal").html('No se puede cargar el contenido de la tabla');
        });
}

function openModalResponder(id)
{
    $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/provider/formResponderSolicitud",
            dataType: 'json',
            data: { id: id}
            })
        .done(function(response){
            $("#formResponder").html(response.html);
            $("#titleModal").html('<h4 id="titleModal" class="modal-title">Pedido '+response.solicitud.nombre+'</h4>');
        }).fail(function(response) {
            $("#tableModal").html('No se puede cargar el contenido de la tabla');
        });
}


$("#formResponder").on("submit", function(e){
    console.log( $( this ).serializeArray() );
    e.preventDefault();
    var array=$( this ).serializeArray();
    var idS=$("#idS").val();
    var observacion=$("#observacion").val();

    $.ajax({
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: "POST",
        url: "/provider/pendienteAlmacenar",
        dataType: 'json',
        data: { array: array, idS:idS,observacion:observacion}
            })
            .done(function(response){
                if (response=="ok") {
                    llenarTabla();
                    $('#modalResponder').modal('toggle');
                }
    }).fail(function(response) {
        alert('No se pudó guardar la respuesta del pedido.');
    });


    return false;
});
