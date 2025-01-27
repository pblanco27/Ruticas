var mapsPlaceholder = [];
var dibujar = false;
var marker = new Array();
var nombres = new Array();
var numeroPopups; 
var routingControl;

navigator.geolocation.getCurrentPosition(
	function(location) {
		var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
		var actualPos = L.icon({
			iconUrl: 'img/actualPos.png',
			iconSize: [25, 45]
		});
		
		var map = L.map('map').setView(latlng, 13)
		L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://mapbox.com">Mapbox</a>',
		maxZoom: 18,
		id: 'mapbox.streets',
		accessToken: 'pk.eyJ1IjoiYmJyb29rMTU0IiwiYSI6ImNpcXN3dnJrdDAwMGNmd250bjhvZXpnbWsifQ.Nf9Zkfchos577IanoKMoYQ'
		}).addTo(map);
		var customOptions = {'maxWidth': '2000', 'className': 'custom'};	
		marker = L.marker(latlng, {icon: actualPos, title:"Usted está aquí"}).bindPopup("Usted está aquí", customOptions).addTo(map);
		L.control.scale().addTo(map);

		mapsPlaceholder[0] = map;
		marker = new Array();

		function onMapClick(e) {
			if (dibujar) {
				var popup = L.popup();
				popup
					.setLatLng(e.latlng)			
					.setContent("Nombre del punto: <br><center><textarea id='marker" + numeroPopups + "' rows='3' style='resize:none;'></textarea><button value='" + numeroPopups + "' onclick='agregarDescripcion(this.value, "+e.latlng.lat+","+e.latlng.lng+")'>Guardar</button>")
					.openOn(mapsPlaceholder[0]);
			}
		}

		function eliminarPuntos() {
			for (i = 0; i < marker.length; i++) {
				mapsPlaceholder[0].removeLayer(marker[i]);
			}
		}

		mapsPlaceholder[0].on('click', onMapClick);
	}
);

function dibujarRuta(){
	var waypoints = new Array();
	for(i=0;i<marker.length;i++) {
		waypoints.push(L.latLng(marker[i].getLatLng().lat ,marker[i].getLatLng().lng ));
	} 
	if (routingControl != null) mapsPlaceholder[0].removeControl(routingControl); 
	
	var customOptions = {'maxWidth': '2000', 'className': 'custom'};	
	routingControl = L.Routing.control({
		waypoints: waypoints,
		createMarker: function (i, wp, nWps) {
			return L.marker(wp.latLng, {title:nombres[i+1]})
			 .bindPopup("Notificar punto a OSM: <br><center><textarea id='waypoint" + i + "' rows='3' style='resize:none;'></textarea><button value='" + i + "' onclick='clickBoton(this.value,"+wp.latLng.lat+","+wp.latLng.lng+")'>Enviar</button><center>", customOptions);
		}, draggableWaypoints: false,addWaypoints: false,
	}).addTo(mapsPlaceholder[0]);
}