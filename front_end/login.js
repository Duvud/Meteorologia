//Función para almacenar una cookie en el equipo cliente
function MandarCookie(nombre, valor, caducidad){
    document.cookie = nombre + "=" + escape(valor) + ((caducidad == null) ? "" : ("; expires=" + caducidad.toGMTString()));
}

$( function() {
    //procesar el formulario de inicio de sesión y conseguir token de usuario al hacer el login
    $('form').submit(function(event) {
        var formData = {
            'email' : $('input[name=email]').val(),
            'password' : $('input[name=password]').val(),
        };
        //Procesamos el formulario
        $.ajax({
            type        : 'POST',
            url         : 'http://127.0.0.1:8000/api/login',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {
                if (data.status !== "success") {
                   $("#dError").css('display','block').css('background-color','red');
                } else {
                    MandarCookie("token",data.token);
                    window.location.replace("main.html");
                }
            });
        event.preventDefault();
    });
});