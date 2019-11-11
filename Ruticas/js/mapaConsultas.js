var mapsPlaceholder = [];
var routingControls = [];
var dibujar = false;
var marcadores = [];
var markerEmpresa = null;
// Cuarta consulta
var consulta4 = false;
var hayCirculo = false;
var rutasPorDibujar = [];
var circle;
var paradas = [];
var marcadoresParadas = [];
var puntosParadas = [];
var latlng;

navigator.geolocation.getCurrentPosition(
	function (location) {
		latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
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
		var customOptions = { 'maxWidth': '2000', 'className': 'custom' };
		var marker = L.marker(latlng, { icon: actualPos, title: "Usted está aquí" }).bindPopup("Usted está aquí", customOptions).addTo(map);
		L.control.scale().addTo(map);

		mapsPlaceholder[0] = map;

		function onMapClick(e) {
			if (consulta4 && !hayCirculo) {
				rutasPorDibujar = [];
				eliminarCirculo();
				circle = L.circle(e.latlng, {
					color: 'red',
					fillColor: '#f03',
					fillOpacity: 0.3,
					radius: 500
				}).addTo(mapsPlaceholder[0]);

				// Hacemos un for que recorra cada una de ellas y pregunte lo siguiente:
				for (i = 1; i < paradas.length; i++) {
					// Sacamos la posición de la parada					
					var paradaPos = [paradas[i][1], paradas[i][2]];

					// Sacamos la distancia que hay entre la posición del marcador y el centro del círculo
					var d = mapsPlaceholder[0].distance(paradaPos, circle.getLatLng());

					// El marcador se encuentra dentro del círculo si la distancia obtenida es menor al radio
					var isInside = d < circle.getRadius();

					if (isInside) {
						// Obtenemos el id de la ruta asociado a dicho punto 
						var idRuta = paradas[i][0];

						// Guardamos el id de dicha ruta en el arreglo global únicamente si no ha almacenado antes
						if (!rutasPorDibujar.includes(idRuta)) {
							rutasPorDibujar.push(idRuta);
						}
					}
				}
				if (rutasPorDibujar.length > 0) {
					limpiarParadas();
					nombres = new Array();
					marker = new Array();
					var numeroRuta;
					select = document.getElementById('rutaParada');
					$("#rutaParada").empty();
					option = document.createElement('option');
					option.value = 0;
					option.text = "Número de la ruta";
					option.style.display = "none";
					select.add(option);
					for (j = 0; j < rutasPorDibujar.length; j++) {
						var colors = ["red", "blue", "orange", "green", "yellow", "brown", "black", "purple"];
						mapsPlaceholder[0].createPane("pane" + j);
						$.ajax({
							async: false,
							url: 'Scripts/infoRuta.php',
							type: 'post',
							data: {
								ruta: rutasPorDibujar[j]
							},
							dataType: 'json',
							success: function (response) {
								numeroRuta = response[0]['numeroRuta'];
								option = document.createElement('option');
								option.value = rutasPorDibujar[j];
								option.text = numeroRuta;
								select.add(option);
							}
						});
						$.ajax({
							async: false,
							url: 'Scripts/cargarPuntos.php',
							type: 'post',
							data: {
								ruta: rutasPorDibujar[j]
							},
							dataType: 'json',
							success: function (response) {
								var puntos = response[0]['puntos'];
								var descripcion = response[0]['descripcion'];
								var waypoints = new Array();
								numeroPopups = puntos.length - 1;
								for (i = 1; i < puntos.length; i++) {
									lat = puntos[i][0];
									lng = puntos[i][1];
									nombres[i] = descripcion[i];
									waypoints.push(L.latLng(lat, lng));
									var marker2 = L.marker([lat, lng]);
									marker.push(marker2);
								}
								var customOptions = { 'maxWidth': '2000', 'className': 'custom' };
								routingControl = L.Routing.control({
									waypoints: waypoints,
									createMarker: function (i, wp, nWps) {
										return L.marker(wp.latLng, { title: nombres[i + 1] })
											.bindPopup("Ruta: " + numeroRuta + "<br>" +
												"Nombre de la parada: " + nombres[i + 1], customOptions);
									}, draggableWaypoints: false, addWaypoints: false,
									lineOptions: {
										styles: [{ pane: "pane" + j, color: colors[j - 1] }]
									}
								}).addTo(mapsPlaceholder[0]);
								routingControls.push(routingControl);
								var top = document.getElementsByClassName("leaflet-top leaflet-right");
								while (top[0].firstChild) {
									top[0].removeChild(top[0].firstChild);
								}
								lat = puntos[1][0];
								lng = puntos[1][1];
								mapsPlaceholder[0].panTo([lat, lng]);
							}
						});
					}
					hayCirculo = true;
				}
			}
		}
		mapsPlaceholder[0].on('click', onMapClick);
	}
);

function dibujarParadas() {
	$.ajax({
		async: false,
		url: 'Scripts/obtenerParadas.php',
		dataType: 'json',
		success: function (response) {
			marcadoresParadas = [];
			paradas = response[0]['paradas'];
			var customOptions = { 'maxWidth': '2000', 'className': 'custom' };
			for (i = 1; i < paradas.length; i++) {
				var paradaPos = [paradas[i][1], paradas[i][2]];
				var punto = L.marker(paradaPos, { title: paradas[i][3] }).addTo(mapsPlaceholder[0]);
				marcadoresParadas.push(punto);
			}
		}
	});
}

function limpiarParadas() {
	for (i = 0; i < marcadoresParadas.length; i++) {
		mapsPlaceholder[0].removeLayer(marcadoresParadas[i]);
	}
}

function limpiarRutas() {
	for (i = 0; i < routingControls.length; i++) {
		if (routingControls[i] != null) mapsPlaceholder[0].removeControl(routingControls[i]);
	}
}

function eliminarCirculo() {
	if (circle != undefined) {
		mapsPlaceholder[0].removeLayer(circle);
		hayCirculo = false;
	}
}
function reiniciarParadas() {
	limpiarRutas();
	eliminarCirculo();
	dibujarParadas();
	limpiarConsulta();
}

