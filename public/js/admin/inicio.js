$(document).ready(function()
{
    grafica('hoy');
});

function grafica(fecha) {
    $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            method: "POST",
            url: "/admin/graficaInicio",
            dataType: 'json',
            data: { fecha: fecha,
                }
            })
        .done(function(response){
            dato=response.dato;
            Morris.Bar({
                element: 'morris-bar-chart',
                data: data,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Temp', 'Hum'],
                hideHover: 'auto',
                resize: true
            });            
        }).fail(function(response) {
            alert('No se pudó grafica.');
        });
}
$(function() {



    
});
