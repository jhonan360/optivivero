var plantas = $('#plantas').data('plantas');
console.log(plantas	);
var codigos=[];
var tableContent=[];
var idPlanta;
var plantaSelected;
var audio = new Audio('/source/sound/beep.mp3');
var valorTotalPagar=0;

$(document).ready(function()
{

});
//$("#selectPlanta").blur( alert("hola") );
$('#selectPlanta').on('change', function(evt) {
    cargarPlantas(this.value);
  });

function cargarPlantas(id){
	this.plantaSelected= new Object();
    this.idPlanta=id
    var aux=  plantas.filter(getPlantas);
    for (var i = 0; i < aux.length; i++) {
    	this.plantaSelected.cantidad=aux[i].cantidad;
		this.plantaSelected.created_at=aux[i].created_at;
		this.plantaSelected.idPlanta=aux[i].idPlanta;
		this.plantaSelected.idTipoPlanta=aux[i].idTipoPlanta;
		this.plantaSelected.nombre=aux[i].nombre;
		this.plantaSelected.updated_at=aux[i].updated_at;
		this.plantaSelected.valor=aux[i].valor;
    }
    $('#cantidadDispo').val(this.plantaSelected.cantidad);
    $('#valor').val(this.plantaSelected.valor);
}
function getPlantas(planta) {
    return planta.idPlanta == this.idPlanta
}
function sumar(){
	var suma=0;
	for (var i = 0; i < tableContent.length; i++) {
		suma+=tableContent[i].valor;
	}
	valorTotalPagar=suma;
	return suma;
}

$("#formAdd").on("submit", function(e){
	e.preventDefault();
	var id=$("#selectPlanta").val();
	var cantidad=parseInt($("#cantidad").val());
	if (parseInt($("#cantidad").val())==0) {
		alert('La cantidad no sebe ser cero')
	} else if (plantaSelected.cantidad==0 ) {
		alert("No hay unidades existentes")
	}else if (plantaSelected.cantidad<$("#cantidad").val()) {
		alert("No puede pedir mas unidades que las existentes")
	}else{
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
	    $("#tableCompra").append(markup);
	    $('#totalPagar').val(valorTotal)
	    audio.play();
		document.getElementById("formAdd").reset();
	    setTimeout(function(){$('#totalPagar').val(valorTotalPagar)}, 5000)
	    $('#irPagar').prop('disabled',false);
    }
	return false;
});
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
            		if (tableContent.length==0) {
	    				$('#irPagar').prop('disabled',true);
            		}
            		$('#totalPagar').val(valorTotalPagar)
            		return;
				}
			}
        }
    });
}
function openModal(){
	$('#totalPagarModal').val(valorTotalPagar);

}
$("#formPagar").on("submit", function(e){
	e.preventDefault();
	var dinero=$('#dinero').val();
	if (dinero==0) {
		alert('Dinero no puede ser cero')
	}else if(dinero<valorTotalPagar){
		alert('Dinero no puede ser menor al valor a pagar')
	}else{
		$.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/pagarVenta",
            dataType: 'json',
            data: { valorTotal: valorTotalPagar,
                    tableContent:tableContent,
                    dinero:dinero,
                }
            })
        .done(function(response){
        	if ((dinero-valorTotalPagar)==0) {
        		alert("Compra Realizada");
        	}else{
        		alert("Compra Realizada. Cambio: "+(dinero-valorTotalPagar));
        	}
	    	/*$('#irPagar').prop('disabled',true);
			$("#totalPagar").val('');
			('#formPagar').trigger("reset");
			$("#tableCompra tr").remove();
			$('#modalPagar').modal('toggle');*/
			location.reload();

        }).fail(function(response) {
            alert('No se pudó hacer compra.');
        });
	}
		return false;
});