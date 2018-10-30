var plantas = $('#plantas').data('plantas');
console.log(plantas	);
var codigos=[];
var tableContent=[];
var idPlanta;
var plantaSelected;
var audio = new Audio('/source/sound/beep.mp3');


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
    console.log(aux[0].cantidad);
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
	return suma;
}

$("#formAdd").on("submit", function(e){
	e.preventDefault();
	var id=$("#selectPlanta").val();
	if (plantaSelected.cantidad<$("#cantidad").val()) {
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
	    setTimeout(function(){$('#totalPagar').val("")}, 5000)
    }
	return false;
});