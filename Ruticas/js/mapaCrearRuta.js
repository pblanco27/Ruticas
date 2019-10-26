var map = L.map('map').setView([9.938038, -84.075376], 13)
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://mapbox.com">Mapbox</a>',
maxZoom: 18,
id: 'mapbox.streets',
accessToken: 'pk.eyJ1IjoiYmJyb29rMTU0IiwiYSI6ImNpcXN3dnJrdDAwMGNmd250bjhvZXpnbWsifQ.Nf9Zkfchos577IanoKMoYQ'
}).addTo(map);
var marker = L.marker([9.938038, -84.075376]).addTo(map);
L.control.scale().addTo(map);

var marker = new Array();
var cont =  0; 
var routingControl;

function dibujarRuta(){
	var waypoints = new Array();
	for(i=0;i<marker.length;i++) {
		waypoints.push(L.latLng(marker[i].getLatLng().lat ,marker[i].getLatLng().lng ));
	} 
	if (routingControl != null) map.removeControl(routingControl);
	var customOptions =
	{
		'maxWidth': '500',
		'className': 'custom'
	}
	console.log('Hola');
	
	routingControl = L.Routing.control({
		waypoints: waypoints,
		createMarker: function (i, wp, nWps) {
			return L.marker(wp.latLng).bindPopup("Nombre del punto: <input type'text' id='input" + i + "'> <button value='" + i + "' onclick='clickBoton(this.value,"+wp.latLng.lat+","+wp.latLng.lng+")'>Enviar</button>", customOptions);
		}, draggableWaypoints: false
	}).addTo(map);
}

function onMapClick(e) {
	var marker2 = L.marker([ e.latlng.lat , e.latlng.lng ]);
	marker.push(marker2);
	dibujarRuta();
	document.getElementById("puntos").value = JSON.stringify(marker);
}

function eliminarPuntos(){
	for(i=0;i<marker.length;i++) {
		map.removeLayer(marker[i]);
	} 	
}

map.on('click', onMapClick);
//map.on('dblclick', eliminarPuntos);	
		