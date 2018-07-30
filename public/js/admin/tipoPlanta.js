$(document).ready(function()
{
	llenarTabla();
});

function llenarTabla()
{
	$('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatableUser').DataTable({
        destroy: true,
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
	var t = $('#datatableTipoPlantas').DataTable();
    t.clear();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/tableTipoPlantas",
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
	        ] ).draw( false );

		}
	});
}

function modal(idTipoPlanta,nombre,imagen)
{
    if (idTipoPlanta!=undefined) {
        $("#nombre").val(nombre);
        $("#idTipoPlanta").val(idTipoPlanta);
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Editar Usuario</h4>');
        $("#btnModal1").val('Editar');

    }else{
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Crear Usuario</h4>');
        $("#btnModal1").val('Guardar');
        $("#nombre").val("");
        $("#idTipoPlanta").val(0);
    }
}



$("#formTipoPlantas").on("submit", function(e){
    e.preventDefault();
    param=$("#btnModal1").val();
    idTipoPlanta=$("#idTipoPlanta").val();
    nombre=$("#nombre").val();
    file=$("#file").val();
    tipoPlanta=$("#tipoPlanta").val();
    paramSend=null;
    file=$("#file").val();
    if (param=="Editar") {
        paramSend='update';

    }else{
        paramSend='create';
    }
    var formData = new FormData(document.getElementById("formTipoPlantas"));
    formData.append('nombre',nombre);
    formData.append('idTipoPlanta',idTipoPlanta);
    formData.append('param',paramSend);
    alert(idTipoPlanta)
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/tipoPlantaAlmacenar",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
                })
                .done(function(response){
                    if (response=='"ok"') {
                        llenarTabla();
                        $('#modalTipoPlantas').modal('toggle');
                    }
        }).fail(function(response) {
            alert('No se pudó guardar el tipo de planta.');
        });;

    return false;
});