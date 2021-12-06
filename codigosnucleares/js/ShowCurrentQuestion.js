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
            $('#pregunta_id').text(datos.numero + ". ");
            $('#pregunta_sentencia').text(datos.pregunta);
            $('#likes').text(datos.likes);
            $('#dislikes').text(datos.dislikes);

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
        $.ajax
        ({
            url: '../php/GameFinished.php',
            type: 'GET',
            dataType: "json",
            success:function(datos)
            {
                if (datos != 0)
                {
                    var puntuacion = datos.puntuacion;
                    var aciertos = datos.aciertos;
                    var fallos = datos.fallos;

                    $('#fin').text("FIN DE LA SESIÓN");
                    $('#puntuacion').text("Tu puntuación: " + puntuacion);
                    $('#aciertos').text("Aciertos: " + aciertos);
                    $('#fallos').text("Fallos: " + fallos);
                    $('#next').prop('disabled', true);
                    $('#verify').prop('disabled', true);
                }
            },
            cache : false,
        });
        $('#verify').prop('disabled', false);
        $('#like').prop('disabled', false);
        $('#dislike').prop('disabled', false);
        $('#correcta').text("");
        $('#incorrecta').text("");
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
                $('#correcta').text("Respuesta Correcta: "+datos.respuestaC);
                $('#incorrecta').text("Tu Respuesta: "+datos.tuRespuesta);
            },
            cache : false,
        });
        $('#verify').prop('disabled', true);
    });
    $('#like').click(function()
    {
        $.ajax
        ({
            url: '../php/VoteQuestion.php?ans=like',
            type: 'post',
            dataType: "json",
            success:function(datos)
            {
                var likes = datos.likes;
                $('#likes').text(likes);
                $('#like').prop('disabled', true);
                $('#dislike').prop('disabled', true);
            },
            cache : false,
        });
    });
    /* suma 1 dislike a la pregunta */
    $('#dislike').click(function()
    {
        $.ajax
        ({
            url: '../php/VoteQuestion.php?ans=dislike',
            type: 'post',
            dataType: "json",
            success:function(datos)
            {
                var dislikes = datos.dislikes;
                $('#dislikes').text(dislikes);
                $('#like').prop('disabled', true);
                $('#dislike').prop('disabled', true);
            },
            cache : false,
        });
    });
    
});