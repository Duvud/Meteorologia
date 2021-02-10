var mymap = undefined;//Aquí guardaremos el mapa

//Esta función vuelve a generar el mapa de 0
function GenerateMap(){
    if(mymap != undefined){
        mymap.remove();
    }
    $("#dMapa").empty();
    mymap = new L.map('dMapa').setView([43.0000000,-2.7500000], 8.46);
     marcElegido = "";
    //Token de acceso para la api mapbox de layer de leaflet : pk.eyJ1IjoiaWswMTIxMDhid2QiLCJhIjoiY2trNGQwdnBuMDA5cDMwbGs0cnlteWg0MyJ9.2cp-rcBCo0NdVScVmFZMWw
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaWswMTIxMDhid2QiLCJhIjoiY2trNGQwdnBuMDA5cDMwbGs0cnlteWg0MyJ9.2cp-rcBCo0NdVScVmFZMWw', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiaWswMTIxMDhid2QiLCJhIjoiY2trNGQwdnBuMDA5cDMwbGs0cnlteWg0MyJ9.2cp-rcBCo0NdVScVmFZMWw'
    }).addTo(mymap);

    mymap.on('popupopen', function(e){
        marcElegido = e.popup._source._popup._content.split("-")[0];
        $( function() {
            $(".leaflet-popup-content").append(`<div ><input value="Añadir" type="button" id="dPopButton" onclick="AnadirBaliza(marcElegido)"></div>`);
        });
    });
    GenerateMarkers();
}


//Genera los marcadores con los datos proporcionados por la api
function GenerateMarkers(){
    for(let i=0;i<sData.length;i++){
        let marker = L.marker([sData[i].y,sData[i].z]).addTo(mymap);
        marker.bindPopup(sData[i].nombre + "-" + sData[i].provincia);
    }
}

