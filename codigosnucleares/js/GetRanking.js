$(document).ready(function()
{
    $("#listaVIPs").click(function()
    { 
        $.ajax({
            url: '../php/Ranking.php',
            type: 'GET',
            dataType: "html",
            success:function(datos)
            {
                $('#ranking').fadeIn().html(datos);
            },
            cache : false,
            error:function()
            {
                $('#ranking').fadeIn().html('<p class="error"><strong>No se puede cargar el Ranking.</p>');
            }
        });
    });
});