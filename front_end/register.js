
$( function() {
    //procesar el formulario de inicio de sesión y conseguir token de usuario al hacer el login
    $('form').submit(function(event) {
        var formData = {
            'name' : $('input[name=nombre]').val(),
            'email' : $('input[name=email]').val(),
            'password' : $('input[name=password]').val(),
        };
        //Procesamos el formulario
        $.ajax({
            type        : 'POST',
            url         : 'http://127.0.0.1:8000/api/register',
            data        : formData,
            dataType    : 'json',
            encode      : true
        })
            .done(function(data) {
                if (data.status !== "success") {
                    console.log(data);
                    $("#dError").css('display','block').css('background-color','red');
                } else {
                    window.location.replace("login.html");
                }
            });
        event.preventDefault();
    });
});