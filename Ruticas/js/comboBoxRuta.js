$(document).ready(function () {
	$("#ruta").change(function () {
		nombres = new Array();
		marker = new Array();
		dibujarRuta();
		//var top = document.getElementsByClassName("leaflet-top leaflet-right");
		//top[0].style.display = "block";
		var rutaid = $(this).val();
		$.ajax({
			url: 'Scripts/infoRuta.php',
			type: 'post',
			data: {
				ruta: rutaid
			},
			dataType: 'json',
			success: function (response) {
				var numeroRuta = response[0]['numeroRuta'];
				var descripcion = response[0]['descripcion'];
				var nombrePartida = response[0]['nombrePartida'];
				var nombreDestino = response[0]['nombreDestino'];
				var idDistritoPartida = response[0]['idDistritoPartida'];
				var idDistritoDestino = response[0]['idDistritoDestino'];
				var activado = response[0]['activado'];

				document.getElementById("numero").value = numeroRuta;
				document.getElementById("descripcion").value = descripcion;
				document.getElementById("trayecto").value = "Trayecto de ruta: " +
					"de " + nombrePartida + " " +
					"a " + nombreDestino;
				document.getElementById("idDistritoPartida").value = idDistritoPartida;
				document.getElementById("idDistritoDestino").value = idDistritoDestino;
				document.getElementById("idRuta").value = rutaid;
				if (activado == 1) {
					document.getElementById("botonCambiarEstadoRuta").firstChild.data = 'Deshabilitar';
				} else {
					document.getElementById("botonCambiarEstadoRuta").firstChild.data = 'Habilitar';
				}
				$.ajax({
					url: 'Scripts/cargarPuntos.php',
					type: 'post',
					data: {
						ruta: rutaid
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
							document.getElementById("puntos").value = JSON.stringify(marker);
						}
						//if (routingControl != null) map.removeControl(routingControl);
						var top = document.getElementsByClassName("leaflet-top leaflet-right");
						while (top[0].firstChild) {
						  top[0].removeChild(top[0].firstChild);
						}
						var customOptions = {'maxWidth': '2000', 'className': 'custom'};	
						routingControl = L.Routing.control({
											waypoints: waypoints,
											createMarker: function (i, wp, nWps) {
												return L.marker(wp.latLng, {title:nombres[i+1]})
												 .bindPopup("Notificar punto a OSM: <br><center><textarea id='input" + i + "' rows='3' style='resize:none;'></textarea><button value='" + i + "' onclick='clickBoton(this.value,"+wp.latLng.lat+","+wp.latLng.lng+")'>Enviar</button><center>", customOptions);
											}, draggableWaypoints: false
										}).addTo(mapsPlaceholder[0]);
						lat = puntos[1][0];
						lng = puntos[1][1];
						mapsPlaceholder[0].panTo([lat, lng]);
						dibujar = true;
					}
				});
			}
		});
	});
});
