$(document).ready(function()
{
	llenarTabla();
});

$("#formSeccion").on("submit", function(e){
	e.preventDefault();
    param=$("#btnModal1").val();
    id=$("#id").val();
    nombre=$("#nombre").val();
    tipoPlanta=$("#tipoPlanta").val();
    cantidad=$("#cantidad").val();
    observacion=$("#observacion").val();
    tempMax=$("#tempMax").val();
    paramSend=null;
    if (param=="Editar") {
        paramSend='update';
    }else{
        paramSend='create';
    }
    var formData = new FormData(document.getElementById("formSeccion"));
    formData.append('id',id);
    formData.append('nombre',nombre);
    formData.append('cantidad',cantidad);
    formData.append('tipoPlanta',tipoPlanta);
    formData.append('observacion',observacion);
    formData.append('tempMax',tempMax);
    formData.append('param',paramSend);
    $.ajax({
         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: "POST",
        url: "/admin/seccionAlmacenar",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
    })
    .done(function(response){
        if (response=='"ok"') {
            llenarTabla();
            $('#modalSeccion').modal('toggle');
        }
    }).fail(function(response) {
        alert('No se pudó guardar la sección.');
    });


    return false;
});

function llenarTabla()
{
	$('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatableSecciones').DataTable({
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
	var t = $('#datatableSecciones').DataTable();
    t.clear();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/tableSeccion",
		dataType: 'json',
		data: {}
	})
	.done(function(response){
		var array=response.html;
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
function modal(id,idTipoPlanta,nombre,espacioTotal,observacion,tempMax)
{
    window.scroll(0, 0);
    if (id!=undefined) {
        $("#id").val(id);
        $("#nombre").val(nombre);
        $("#tipoPlanta").val(idTipoPlanta);
        $("#cantidad").val(espacioTotal);
        $("#observacion").val(observacion);
        $("#tempMax").val(tempMax);
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Editar Sección</h4>');
        $("#btnModal1").val('Editar');

    }else{
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Crear Sección</h4>');
        $("#id").val("");
        $("#nombre").val("");
        $("#repetirPassword").val("");
        $("#tipoPlanta").val("");
        $("#cantidad").val("");
        $("#observacion").val("");
        $("#tempMax").val("");
        $("#btnModal1").val('Crear');

    }
}