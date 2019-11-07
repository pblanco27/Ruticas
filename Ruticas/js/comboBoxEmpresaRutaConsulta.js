$(document).ready(function () {
	$("#nombreEmpresas").change(function () {
		if (markerEmpresa != null) mapsPlaceholder[0].removeLayer(markerEmpresa);
		for(i = 0; i < routingControls.length; i++){
			if (routingControls[i] != null) mapsPlaceholder[0].removeControl(routingControls[i]);
		}
		nombres = new Array();
		marker = new Array();
		var costo;
		var duracion;
		var discapacitado;	
		var numeroRuta;		
		var empid = $(this).val();
		var rutaid = document.getElementById('ruta').value;
		$.ajax({
			async: false,
			url: 'Scripts/infoRuta.php',
			type: 'post',
			data: {
				ruta: rutaid
			},
			dataType: 'json',
			success: function (response) {
				numeroRuta = response[0]['numeroRuta'];
			}
		});
		$.ajax({
			async: false,
			url: 'Scripts/infoVinculacion.php',
			type: 'post',
			data: {
			  ruta: rutaid,
			  empresa: empid
			},
			dataType: 'json',
			success: function(response) {
				costo = response[0]['costo'];
				duracion = response[0]['duracion'];
				discapacitado = response[0]['discapacitado'];
				if (discapacitado == 1){
				  discapacitado = "Sí";
				} else {
				  discapacitado = "No";
				}
			}
		});
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
				}
				var top = document.getElementsByClassName("leaflet-top leaflet-right");
				while (top[0].firstChild) {
				  top[0].removeChild(top[0].firstChild);
				}
				var customOptions = {'maxWidth': '2000', 'className': 'custom'};	
				routingControl = L.Routing.control({
									waypoints: waypoints,
									createMarker: function (i, wp, nWps) {
										return L.marker(wp.latLng, {title:nombres[i+1]})
										.bindPopup("Ruta: " + numeroRuta + "<br>" +
												  "Nombre de la parada: " + nombres[i+1] + "<br>" +
												  "Costo del pasaje: " + costo + " colones<br>" +
												  "Duración del viaje: " + duracion + " minutos<br>" +
												  "Servicio para discapacitados: " + discapacitado, customOptions);
									}, draggableWaypoints: false,addWaypoints: false,
								}).addTo(mapsPlaceholder[0]);
				routingControls.push(routingControl);
				lat = puntos[1][0];
				lng = puntos[1][1];
				mapsPlaceholder[0].panTo([lat, lng]);
			}
		});
	});
});