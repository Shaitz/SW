function isEmpty( elem )
{
    return !$.trim(elem.html())
}
$(document).ready(function()
{
    $("#next").click(function()
    {
        $('#lapregunta').empty();
        $('#container').empty();
        $('#laimagen').empty();
        $('#larespuesta').empty();
        $.ajax
        ({
            url: '../php/GetNextQuestion.php',
            type: 'GET',
            dataType: "html",
            success:function(datos)
            {
                /*var pregunta = datos.pregunta;
                var inc1 = datos.inc1;
                var inc2 = datos.inc2;
                var inc3 = datos.inc3;
                var img = datos.img;
                var correcta = datos.correcta;
                
                var radios = [inc1,inc2,inc3];
                $('#lapregunta').append(`<label for="${pregunta}">${pregunta}</label>`);
                $('#laimagen').prepend("<img src=../images/" +img +" height=80px width=100px>");
                for (var value of radios) 
                {
                    $('#container')
                    .append(`<input type="radio" id="${value}" name="respuesta" value="${value}">`)
                    .append(`<label for="${value}">${value}</label>`)
                    .append(`<br>`);
                }*/
                $('#container').append(datos);
            },
            cache : false,
        });
    });
    $("#verify").click(function()
    {
        $('#larespuesta').empty();
        var answer = $('input[name="respuesta"]:checked').val();
        var questionId = $('#pregunta_id').text();
        $.ajax
        ({
            url: '../php/VerifyQuestion.php?id='+questionId+'&pregunta='+answer,
            type: 'POST',
            dataType: "html",
            success:function(datos)
            {
                var data = jQuery.parseJSON(datos);
                $('#larespuesta').append(`<label for="${data.respuesta}">Tu respuesta: ${data.respuesta}</label>`);
            },
            cache : false,
        });
    });
    
});