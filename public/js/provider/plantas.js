$(document).ready(function()
{
	llenarTabla();
    llenarSelect();
});

function llenarTabla()
{
	$('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatablePlantas').DataTable({
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
	var t = $('#datatablePlantas').DataTable();
    t.clear();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/provider/tablePlantas",
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
	        ] ).draw( false );

		}
	});
}

function modal(idPlanta,idTipoPlanta,nombre,valor)
{
    if (idPlanta!=undefined) {
        $("#idPlanta").val(idPlanta);
        $("#nombre").val(nombre);
        $("#tipoPlanta").val(idTipoPlanta);
        $("#valor").val(valor);
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Editar Usuario</h4>');
        $("#btnModal1").val('Editar');

    }else{
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Crear Usuario</h4>');
        $("#btnModal1").val('Guardar');
        $("#idPlanta").val("");
        $("#nombre").val("");
        $("#tipoPlanta").val(0);
        $("#valor").val("");
    }
}



$("#formPlantas").on("submit", function(e){
    e.preventDefault();
    param=$("#btnModal1").val();
    idPlanta=$("#idPlanta").val();
    nombre=$("#nombre").val();
    valor=$("#valor").val();
    tipoPlanta=$("#tipoPlanta").val();
    paramSend=null;

    if (param=="Editar") {
        paramSend='update';

    }else{
        paramSend='create';
    }
    var formData = new FormData(document.getElementById("formPlantas"));
    formData.append('nombre',nombre);
    formData.append('valor',valor);
    formData.append('tipoPlanta',tipoPlanta);
    formData.append('idPlanta',idPlanta);
    formData.append('param',paramSend);
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/provider/plantaAlmacenar",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
                })
                .done(function(response){
                    if (response=='"ok"') {
                        llenarTabla();
                        $('#modalPlantas').modal('toggle');
                    }
        }).fail(function(response) {
            alert('No se pudó guardar la planta.');
        });;

    return false;
});
function llenarSelect()
{ //futuro
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        method: "POST",
        url: "/provider/llenarSelectTipoPlantas",
        dataType: 'json',
    })
    .done(function(response){
        $("#selectTipoPlantas").html(response.html);
    });
}