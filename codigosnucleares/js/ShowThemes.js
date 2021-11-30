function isEmpty( elem )
{
    return !$.trim(elem.html())
}

$(document).ready(function()
{
    $("#themes").click(function()
    {
        if (isEmpty($('#temas')))
        {
            $.ajax
            ({
                url: '../php/Themes.php',
                type: 'GET',
                dataType: "html",
                success:function(datos)
                {
                    $('#temas').fadeIn().html(datos);
                },
                cache : false,
            });
        }
        else
            $("#temas").empty();
    });
    
});