var plantas = $('#plantas').data('plantas');
console.log(plantas	);
var tableContent=[];
$(document).ready(function()
{
	llenarTabla();
});
function sumar(){
	var suma=0;
	for (var i = 0; i < tableContent.length; i++) {
		suma+=tableContent[i].valor;
	}
	return suma;
}

$("#addPlant").on("submit", function(e){
	e.preventDefault();
	var id=$("#selectPlanta").val();
	for (var i = 0; i < tableContent.length; i++) {
		if (tableContent[i].id==id) {
			alert("No se puede agregar la misma planta")
			return false;
		}
	}
	$("#total").remove();
	var planta = new Object();
	planta.id=id;
	planta.cantidad=$("#cantidad").val();
	planta.valor=$("#valor").val()*$("#cantidad").val();
	tableContent.push(planta);
	var suma=sumar();

	var nombre=$("#selectPlanta option:selected").text();
	var cantidad = $("#cantidad").val();
	var valorTotal = $("#valor").val()*$("#cantidad").val();
	var markup = "<tr align='center'><td><input type='checkbox' name='record' id='"+id+"'></td><td>" + nombre + "</td><td>" + cantidad + "</td><td>"+valorTotal+"</td></tr><tr id='total' align='center'><td scope='col' colspan='3'>TOTAL</td><td scope='col'>"+suma+"</td></tr>";
    $("table tbody").append(markup);
    $("#cantidad").val("");
	return false;
});

function showValor(id){
	if (id!=0) {
		for (var i = 0; i < plantas.length; i++) {
			if (plantas[i].idPlanta==id) {
				$("#valor").val(plantas[i].valor);
				console.log(plantas[i].valor);
			}
		}
	}
}
function deleteRow(){
	$("table tbody").find('input[name="record"]').each(function(){
    	if($(this).is(":checked")){
            $(this).parents("tr").remove();
            var id = this.id;
            for (var i = 0; i < plantas.length; i++) {
				if (tableContent[i].id==id) {
            		tableContent.splice(i, 1);
            		$("#total").remove();
            		var suma=sumar();
            		$("table tbody").append("<tr id='total' align='center'><td scope='col' colspan='3'>TOTAL</td><td scope='col'>"+suma+"</td></tr>");
            		return;
				}
			}
        }
    });
}
function hacerPedido(){
	var nombre=$("#nombre").val();
	var idProveedor=$("#selectProveedor").val();
	var observacion=$("#observacion").val();
	if (tableContent.length>0&&nombre!=""&&idProveedor!=""&&observacion!="") {
		$.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/hacerPedido",
            dataType: 'json',
            data: { nombre: nombre,
                    idProveedor:idProveedor,
                    observacion:observacion,
                    tableContent:tableContent,
                }
            })
        .done(function(response){
        	alert("Pedido agregado");
        	$("#nombre").val('');
			$("#selectProveedor").val(0);
			$("#selectPlanta").val(0);
			$("#observacion").val('');
			$("#cantidad").val('');
			$("#valor").val('');
			$("#tablePlantas tr").remove();
			llenarTabla();
        }).fail(function(response) {
            alert('No se pudó agregar el pedido.');
        });
	}else{
		alert("ningun campo debe estar vacio");
	}
}
function llenarTabla()
{
	$('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatablePedidos').DataTable({
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
	var t = $('#datatablePedidos').DataTable();
    t.clear();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/tablePedido",
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
            url: "/admin/tableSolicitudes",
            dataType: 'json',
            data: { id: id}
            })
        .done(function(response){
			console.log(response.html);
			$("#tableModal").html(response.html);
			$("#titleModal").html('<h4 id="titleModal" class="modal-title">Pedido '+response.solicitud.nombre+'</h4>');
        }).fail(function(response) {
			$("#tableModal").html('No se puede cargar el contenido de la tabla');
        });
}