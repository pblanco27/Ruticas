$(document).ready(function () {
	$("#distrito").change(function () {
		limpiarDestino();
		if (markerEmpresa != null) mapsPlaceholder[0].removeLayer(markerEmpresa);
		for (i = 0; i < routingControls.length; i++) {
			if (routingControls[i] != null) mapsPlaceholder[0].removeControl(routingControls[i]);
		}
		eliminarCirculo();
		nombres = new Array();
		marker = new Array();
		var numeroRuta;
		var idDistrito = $(this).val();
		$.ajax({
			url: 'Scripts/rutasPorDistrito.php',
			type: 'post',
			data: {
				id_distrito: idDistrito
			},
			dataType: 'json',
			success: function (response) {
				var colors = ["red", "blue", "orange", "green", "yellow", "brown", "black", "purple"];
				rutasPorDibujar = response[0]['ids'];
				var select = document.getElementById('rutasDestino');
				$("#rutasDestino").empty();
				option = document.createElement('option');
				option.value = 0;
				option.text = "Seleccione una ruta";
				option.style.display = "none";
				select.add(option);
				if(rutasPorDibujar.length > 1){
					document.getElementById("botonRutaCercanaDestino").style.display = "block";
				}
				else{
					document.getElementById("botonRutaCercanaDestino").style.display = "none";
				}
				puntosParadas = [];
				for (j = 1; j < rutasPorDibujar.length; j++) {
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
							option = document.createElement( 'option' );
                            option.value = rutasPorDibujar[j];
							option.text = response[0]['numeroRuta'];
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
								puntosParadas.push([lat, lng]);
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
				document.getElementById("infoRutaDestino").style.display = "block";
			}
		});
	});
});
