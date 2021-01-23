var iAnadidas = 0;
var arAnadidas = [];
var arCargados = [];

$( function() {
    $("#dDatos").hide();
    $("#bMostrarDatos").hide();
});

//Esta funcion añade una baliza a la lista de balizas del usuario
function AnadirBaliza(sNombreBaliza){
    if(ComprobarExistencia(sNombreBaliza) === -1){
        let bEncontrado = false;
        let i=0;
        do{
            if(sData[i].nombre === sNombreBaliza){
                arCargados.push(sData[i]);
                arAnadidas.push(sData[i].nombre);
                bEncontrado = true;
                iAnadidas++;
                if(iAnadidas -1 === 0){
                    $("#dPaneles").css('border-color','#6c6c92');
                }
                $("#dPaneles").prepend(`<div class="dBalizaElegida p-1 col-md-12 col-lg-2 col-sm-12 col-12">${sData[i].nombre}</div>`)
                $("#bMostrarDatos").slideDown();
                if(iAnadidas -1 === 0 ){
                    var scrollDiv = document.getElementById("bMostrarDatos").offsetTop;
                    window.scrollTo({ top: scrollDiv, behavior: 'smooth'});
                }
            }else{
                i++
            }
        }while(bEncontrado === false && i<sData.length)
    }
}

function EliminarBaliza(sNombreBaliza){
    if(ComprobarExistencia(sNombreBaliza) !== -1){
        let iPos = ComprobarExistencia(sNombreBaliza);
        if(iPos !== -1){
            sData.splice(iPos,1);
            iAnadidas--;
        }
    }
}

/**
 * @return {number}
 */
function ComprobarExistencia(sNombreBaliza){
    for(let i=0;i<arAnadidas.length;i++){
        if(sNombreBaliza === arAnadidas[i]){
            return i;
        }
    }
    return -1;
}