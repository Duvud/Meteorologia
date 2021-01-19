
var sData = "";
function GetData (){
    $.ajax({
        url:   'http://127.0.0.1:8000/api/balizas',
        type:  'GET',
        beforeSend: function () {
        },
        success: function (response){
            sData = response;
            alert(sData[0].nombre);
        }
    });
}



//GetData();
//setInterval(GetData,5000);
