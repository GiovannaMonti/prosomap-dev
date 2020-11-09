
var mymap = L.map('mapid').setView([36.849998, 14.766667], 3);
var zoom = mymap.getZoom();
    console.log(zoom);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/outdoors-v9',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'pk.eyJ1IjoiZ2lvdmFubmFtb250aSIsImEiOiJja2NxMWR3dWoxMGlnMzNsZnY3andkb2ZwIn0.jEysB4u6XZgrYKZrOLNBCw'
}).addTo(mymap);
