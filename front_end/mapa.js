var mymap = L.map('dMapa').setView([43.0000000,-2.7500000], 8.3);
var marker = L.marker([43.3199000,-1.9000000]).addTo(mymap);

//Token de acceso para la api mapbox de layer de leaflet : pk.eyJ1IjoiaWswMTIxMDhid2QiLCJhIjoiY2trNGQwdnBuMDA5cDMwbGs0cnlteWg0MyJ9.2cp-rcBCo0NdVScVmFZMWw
L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoiaWswMTIxMDhid2QiLCJhIjoiY2trNGQwdnBuMDA5cDMwbGs0cnlteWg0MyJ9.2cp-rcBCo0NdVScVmFZMWw', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiaWswMTIxMDhid2QiLCJhIjoiY2trNGQwdnBuMDA5cDMwbGs0cnlteWg0MyJ9.2cp-rcBCo0NdVScVmFZMWw'
}).addTo(mymap);

//Marcadores
marker.bindPopup("Lezo").openPopup();

