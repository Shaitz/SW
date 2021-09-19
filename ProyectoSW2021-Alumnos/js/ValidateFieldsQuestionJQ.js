function verificar()
{
    var email = $('#email').val();
    var pregunta = $("#pregunta").val();
    var respuestaCorrecta = $("#respuestaCorrecta").val();
    var respuestaInc1 = $("#respuestaIncorrecta1").val();
    var respuestaInc2 = $("#respuestaIncorrecta2").val();
    var respuestaInc3 = $("#respuestaIncorrecta3").val();
    var dificultad = $("#dificultad").val();
    var tema = $("#tema").val();

    var regExEmailStud = new RegExp("[a-z]+[0-9]{3}@ikasle\.ehu\.(eus|es)");
    var regExEmailProf = new RegExp("([a-z]+|[a-z]+\.[a-z]+)@ehu\.(eus|es)");

    if($.trim(email).length < 1 || $.trim(pregunta).length < 1 || $.trim(respuestaCorrecta).length < 1 || $.trim(respuestaInc1).length < 1 || $.trim(respuestaInc2).length < 1 || $.trim(respuestaInc3).length < 1 || $.trim(tema).length < 1)
    {
        alert("Error. Rellena los campos obligatorios.");
        return false;
    }

    if($.trim(pregunta).length < 10)
    {
        alert("La pregunta debe de tener al menos 10 caracteres.");
        return false;
    }

    if(!regExEmailStud.test(email) && !regExEmailProf.test(email))
    {
        alert("Email no válido");
        return false;
    }
    return true;
}