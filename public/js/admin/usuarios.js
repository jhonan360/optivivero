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
	var t = $('#datatableUser').DataTable();
    t.clear();
	$.ajax({
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		method: "POST",
		url: "/admin/tableUser",
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
function modal(email,cedula,nombres,apellidos,telefono,direccion)
{
    window.scroll(0, 0);
    if (email!=undefined) {
        $("#email").val("");
        $("#password").val("");
        $("#repetirPassword").val("");
        $("#cedula").val("");
        $("#nombres").val("");
        $("#apellidos").val("");
        $("#telefono").val("");
        $("#direccion").val("");
        $("#file").val("");
        $("#email").prop("disabled",true);
        $("#email").val(email);
        $("#password").val("");
        $("#password").prop("required",false);
        $("#repetirPassword").val("");
        $("#repetirPassword").prop("required",false);
        $("#cedula").prop("disabled",true);
        $("#cedula").val(cedula);
        $("#nombres").val(nombres);
        $("#apellidos").val(apellidos);
        $("#telefono").val(telefono);
        $("#direccion").val(direccion);
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Editar Usuario</h4>');
        $("#btnModal1").val('Editar');

    }else{
        $("#titleModal").html('<h4 id="titleModal" class="modal-title">Crear Usuario</h4>');
        $("#email").removeAttr("disabled");
        $("#cedula").removeAttr("disabled");
        $("#btnModal1").val('Guardar');
        $("#email").val("");
        $("#password").val("");
        $("#repetirPassword").val("");
        $("#cedula").val("");
        $("#nombres").val("");
        $("#apellidos").val("");
        $("#telefono").val("");
        $("#direccion").val("");
        $("#file").val("");
        $("#password").prop("required",true);
        $("#repetirPassword").prop("required",true);
    }
}

function extension()
{
    var archivo = $("#file").val();
    var extension = archivo.substring(archivo.lastIndexOf("."));
    if (extension != ".jpg" && extension != ".png"&& extension != ".jpeg") {
        $("#file").val("");
    }
}

$("#formUsuario").on("submit", function(e){
    e.preventDefault();
    param=$("#btnModal1").val();
    email=$("#email").val();
    password=$("#password").val();
    repetirPassword=$("#repetirPassword").val();
    cedula=$("#cedula").val();
    nombres=$("#nombres").val();
    apellidos=$("#apellidos").val();
    telefono=$("#telefono").val();
    direccion=$("#direccion").val();
    file=$("#file").val();
    paramSend=null;

    if (param=="Editar") {
        paramSend='update';

    }else{
        paramSend='create';
    }
    var formData = new FormData(document.getElementById("formUsuario"));
    formData.append('email',email);
    formData.append('password',password);
    formData.append('cedula',cedula);
    formData.append('nombres',nombres);
    formData.append('apellidos',apellidos);
    formData.append('telefono',telefono);
    formData.append('direccion',direccion);
    formData.append('param',paramSend);
    if (password==repetirPassword) {
        $.ajax({
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/usuarioAlmacenar",
            dataType: "html",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
                })
                .done(function(response){
                    if (response=='"ok"') {
                        llenarTabla();
                        $('#modalUsuarios').modal('toggle');
                    }
        }).fail(function(response) {
            alert('No se pudó guardar el usuario email.');
        });
    }else{
        alert('Las contraseñas deben ser iguales');
    }

    return false;
});