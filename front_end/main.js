var iAnadidas = 0;
var arAnadidas = [];
var arCargados = [];

$( function() {
    $("#dDatos").hide();
    $("#dParteinferior").hide();
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
                if(iAnadidas>0){
                    $("#dPaneles").css('border-color','black');
                    $("#dParteinferior").slideDown();
                }

                $("#dPaneles").prepend(`<div class="dBalizaElegida p-1 col-md-2 col-lg-2 col-sm-12">${sData[i].nombre}</div>`)
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