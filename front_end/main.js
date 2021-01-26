
var iAnadidas = 0;
var arAnadidas = [];
var arCargados = [];
var arOpcionesMostrar = [];
var arOpcionesMostrarParse = []; //Opciones parseadas para coincidir con los datos del backend

//Comprobamos que no esté intentando entrar una persona no autorizada


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
                $("#dPaneles").prepend(`<div id="${sData[i].nombre}" onclick="EliminarBaliza('${sData[i].nombre}')" class="dBalizaElegida p-1 col-md-12 col-lg-2 col-sm-12 col-12">${sData[i].nombre}</div>`)
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
    alert(ComprobarExistencia(sNombreBaliza));
    if(ComprobarExistencia(sNombreBaliza) !== -1){
        let iPos = ComprobarExistencia(sNombreBaliza);
        if(iPos !== -1){
            EliminarPeticionBaliza(arCargados[iPos].id);
            arAnadidas.splice(iPos,1);
            arCargados.splice(iPos,1);
            iAnadidas--;
            $(`#${sNombreBaliza}`).slideUp();
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

function MostrarDatos(){
    $( function() {
      $("#dEditar").slideUp(900);
      $("#dOpcionesDatos").prepend(`<div class="dConfDatos">temperatura</div>`)
          .append(`<div class="dConfDatos">precipitación</div>`)
          .append(`<div class="dConfDatos">velocidad aire</div>`)
          .append(`<div class="dConfDatos">humedad</div>`);
      $("#dDatos").slideDown();
      $( ".dConfDatos" ).draggable({
          revert:true
      });
      $("#dTablaDatos").droppable({
          drop: function( event, ui ) {
              //$(ui.draggable).text();
              if(arOpcionesMostrar.length === 0){
                  $(ui.draggable).css('background-color','#004404');
                  arOpcionesMostrar.push($(ui.draggable).text());
                  AnadirOpcionesParseadas($(ui.draggable).text());
                  CargarDatos();
              }else{
                  if(!arOpcionesMostrar.includes($(ui.draggable).text())){
                      $(ui.draggable).css('background-color','#004406');
                      arOpcionesMostrar.push($(ui.draggable).text());
                      AnadirOpcionesParseadas($(ui.draggable).text());
                      CargarDatos()
                  }else{
                      $(ui.draggable).css('background-color','#390001');
                      arOpcionesMostrar.splice(arOpcionesMostrar.indexOf((ui.draggable).text()),1);
                      EliminarOpcionesParseadas();
                      CargarDatos();
                      if(arOpcionesMostrar.length === 0 ){
                          $(".tablaDatos").remove()
                          $("#dTablaDatos").prepend("<h6>Arrastra aquí los diferentes datos para verlos</h6>");
                          $("#dTablaDatos").css('border','solid whitesmoke 1px');
                      }
                      //!arOpcionesMostrar.includes($(ui.draggable).text()
                  }
              }
          }
      });
    });
}

function AnadirOpcionesParseadas(texto){
    switch (texto){
        case "velocidad aire":
            arOpcionesMostrarParse.push("velocidad");
            break;
        case "precipitación":
            arOpcionesMostrarParse.push("precipitacion");
            break;
        default:
            arOpcionesMostrarParse.push(texto);
            break;
    }
}

function EliminarOpcionesParseadas(texto){
    switch (texto){
        case "velocidad aire":
            arOpcionesMostrarParse.splice(arOpcionesMostrarParse.indexOf("velocidad"),1);
            break;
        case "precipitación":
            arOpcionesMostrarParse.splice(arOpcionesMostrarParse.indexOf("precipitacion"),1);
            break;
        default:
            arOpcionesMostrarParse.splice(arOpcionesMostrarParse.indexOf(texto),1);
            break;
    }
}

function CargarDatos(){
    $("#dTablaDatos h6").remove();
    $("#dTablaDatos").css('border','none');
    $(".tablaDatos").remove();
    sTabla = "";
    sTabla += "<table class='tablaDatos'>";
        sTabla += "<tr>";
            sTabla += "<th>Nombre</th>";
            for(let i=0;i<arOpcionesMostrar.length;i++){
                sTabla += `<th>${arOpcionesMostrar[i]}</th>`;
            }
        sTabla += "</tr>";
            for(let i=0;i<arCargados.length;i++){
                sTabla += "<tr>";
                sTabla += `<td>${arCargados[i]["nombre"]}</td>`;
                for(let z=0;z<arOpcionesMostrar.length;z++) {
                    sTabla += `<td>${arCargados[i][arOpcionesMostrarParse[z]]}</td>`;
                }
                sTabla += "</tr>";
            }
    sTabla += "</table>";
            $("#dTablaDatos").prepend(sTabla);
}
