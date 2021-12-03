function isEmpty( elem )
{
    return !$.trim(elem.html())
}
function mostrarPregunta()
{
    $.ajax
    ({
        url: '../php/GetNextQuestion.php',
        type: 'GET',
        dataType: "json",
        success:function(datos)
        {
            $('#pregunta_id').text(datos.numero);
            $('#pregunta_sentencia').text(datos.pregunta);
            $('#image').attr("src", "../images/"+datos.imagen);

            $('#resp1').val(datos.resp1);
            $('#respLabel1').text(datos.resp1);

            $('#resp2').val(datos.resp2);
            $('#respLabel2').text(datos.resp2);

            $('#resp3').val(datos.resp3);
            $('#respLabel3').text(datos.resp3);

            $('#resp4').val(datos.resp4);
            $('#respLabel4').text(datos.resp4);
        },
        cache : false,
    });
}
$(document).ready(function()
{
    mostrarPregunta();
    $("#next").click(function()
    {
        mostrarPregunta();
    });
    $("#verify").click(function()
    {
        var answer = $('input[name="respuesta"]:checked').val();
        var questionId = $('#pregunta_id').text();
        $.ajax
        ({
            url: '../php/VerifyQuestion.php?id='+questionId+'&pregunta='+answer,
            type: 'POST',
            dataType: "json",
            success:function(datos)
            {
                $('#siono').text("Tu respuesta: "+datos.respuesta);
            },
            cache : false,
        });
    });
    
});