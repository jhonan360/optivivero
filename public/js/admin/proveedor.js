$(document).ready(function()
{
	llenarTabla();

});


function llenarTabla()
{
	$('#datatable').DataTable();
    //Buttons examples
    var table = $('#datatableProveedores').DataTable({
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
	var t = $('#datatableProveedores').DataTable();
    t.clear();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/tableProveedores",
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
                array[i][7],
                array[i][8],
				array[i][9],
	        ] ).draw( false );

		}
	});
}
function switchEstado(name,id){
    var estado = document.getElementById(name).checked;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/estadoUsuario",
            dataType: 'json',
            data: { id: id,
                    estado:estado}
            })
        .done(function(response){
            });
}
function modal(email,nit,razonSocial,telefono,direccion)
{
    window.scroll(0, 0);
    if (email!=undefined) {
        $("#file").val("");
        $("#email").val("");
        $("#password").val("");
        $("#repetirPassword").val("");
        $("#nit").val("");
        $("#razonSocial").val("");
        $("#telefono").val("");
        $("#direccion").val("");
        $("#email").prop("disabled",true);
        $("#email").val(email);
        $("#password").val("");
        $("#password").prop("required",false);
        $("#repetirPassword").val("");
        $("#repetirPassword").prop("required",false);
        $("#nit").prop("disabled",true);
        $("#nit").val(nit);
        $("#razonSocial").val(razonSocial);
        $("#telefono").val(telefono);
        $("#direccion").val(direccion);
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Editar Proveedor</h4>');
        $("#btnModal1").val('Editar');

    }else{
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Crear Proveedor</h4>');
        $("#email").removeAttr("disabled");
        $("#nit").removeAttr("disabled");
        $("#btnModal1").val('Guardar');
        $("#email").val("");
        $("#password").val("");
        $("#repetirPassword").val("");
        $("#nit").val("");
        $("#razonSocial").val("");
        $("#telefono").val("");
        $("#direccion").val("");
        $("#file").val("");
        $("#password").prop("required",true);
        $("#repetirPassword").prop("required",true);
    }
}



$("#formProveedor").on("submit", function(e){
    e.preventDefault();
    param=$("#btnModal1").val();
    email=$("#email").val();
    password=$("#password").val();
    repetirPassword=$("#repetirPassword").val();
    nit=$("#nit").val();
    razonSocial=$("#razonSocial").val();
    telefono=$("#telefono").val();
    direccion=$("#direccion").val();
    paramSend=null;
    file=$("#file").val();

    if (param=="Editar") {
        paramSend='update';

    }else{
        paramSend='create';
    }
    var formData = new FormData(document.getElementById("formProveedor"));
    formData.append('email',email);
    formData.append('password',password);
    formData.append('nit',nit);
    formData.append('razonSocial',razonSocial);
    formData.append('telefono',telefono);
    formData.append('direccion',direccion);
    formData.append('param',paramSend);
    if (password==repetirPassword) {
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/proveedorAlmacenar",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
                })
                .done(function(response){
                    if (response=='"ok"') {
                        llenarTabla();
                        $('#modalProveedor').modal('toggle');
                    }
        }).fail(function(response) {
            alert('No se pudó guardar el proveedor.');
        });
    }else{
        alert('Las contraseñas deben ser iguales');
    }

    return false;
});
function switchEstado(name,id){
    var estado = document.getElementById(name).checked;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/estadoUsuario",
            dataType: 'json',
            data: { id: id,
                    estado:estado}
            })
        .done(function(response){
            });
}
function extension()
{
    var archivo = $("#file").val();
    var extension = archivo.substring(archivo.lastIndexOf("."));
    if (extension != ".jpg" && extension != ".png"&& extension != ".jpeg") {
        $("#file").val("");
    }
}