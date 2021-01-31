var userToken = ConsultarCookie("token");
var sPeticiones = "";
var sData = "";
var bFirstUpdate = true;

//Esta función carga los datos de todas las balizas y las peticiones del usuario logueado
function GetData (){
    if(userToken !== undefined){
        $.ajax({
            url:   `http://127.0.0.1:8000/api/balizas/`,
            type:  'GET',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer '+ userToken);
                xhr.setRequestHeader('Accept', 'application/json');
            },
            success: function (response){
                sData = response;
                GenerateMarkers();
            }
        });
        $.ajax({
            url:   `http://127.0.0.1:8000/api/peticiones`,
            type:  'GET',
            beforeSend: function (xhr) {
                xhr.setRequestHeader('Authorization', 'Bearer '+ userToken);
                xhr.setRequestHeader('Accept', 'application/json');
            },
            success: function (response){
                sPeticiones = response;
                if(bFirstUpdate === true){
                    ActualizarConfiguracion();
                    bFirstUpdate = false;
                }
            },
            error: function (response) {
                window.location.replace("login.html");
            }
        });
    }else{
        window.location.replace("login.html");
    }
}

//Esta función carga en el frontend las balizas escogidas anteriormente por el usuario
function ActualizarConfiguracion(){
    if(sPeticiones.status !== "failed"){
        for(let i=0;i<sPeticiones.data.length;i++){
            $.ajax({
                url:   `http://127.0.0.1:8000/api/balizas/${sPeticiones.data[i].baliza}`,
                type:  'GET',
                beforeSend: function (xhr) {
                    xhr.setRequestHeader('Authorization', 'Bearer '+ userToken);
                    xhr.setRequestHeader('Accept', 'application/json');
                },
                success: function (response){
                    AnadirBaliza(response.nombre);
                },
                error: function (response) {
                    console.log("No se ha podido actualizar la configuración");
                }
            });
        }
    }
}

//Almacena las balizas elegidas por el usuario en la base de datos
function GuardarBalizas() {
    for (let i = 0; i < arCargados.length; i++) {
        $.ajax({
            url: `http://127.0.0.1:8000/api/peticiones/almacenar`,
            type: 'GET',
            data:{
              user: "front-session",
              baliza: arCargados[i].id
            },
            beforeSend: function (xhr){
                xhr.setRequestHeader('Authorization', 'Bearer ' + userToken);
                xhr.setRequestHeader('Accept', 'application/json');
            },
            error: function (response) {
                console.log("No se ha podido guardar la configuración");
            }
        });
    }
}

//Function que elimina las peticiones que haya hecho un usuario sobre una baliza
function EliminarPeticionBaliza(sIdBaliza){
    $.ajax({
        url: `http://127.0.0.1:8000/api/peticiones/eliminar`,
        type: 'GET',
        data:{
            baliza: sIdBaliza
        },
        beforeSend: function (xhr){
            xhr.setRequestHeader('Authorization', 'Bearer ' + userToken);
            xhr.setRequestHeader('Accept', 'application/json');
        },
        success: function (response){
            console.log(response);
        },
        error: function (response) {
            console.log(response);
            console.log("No se ha podido guardar la configuración");
        }
    });
}

//Consigue una cookie
function ConsultarCookie(nombre) {
    var buscamos = nombre + "=";
    if (document.cookie.length > 0) {
        i = document.cookie.indexOf(buscamos);
        if (i != -1) {
            i += buscamos.length;
            j = document.cookie.indexOf(";", i);
            if (j == -1)
                j = document.cookie.length;
            return unescape(decodeURI(document.cookie.substring(i, j)));
        }
    }
}

GetData();
setInterval(GetData,1000 * 60 * 2);




