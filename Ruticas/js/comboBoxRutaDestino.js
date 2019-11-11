$(document).ready(function () {
	$("#rutasDestino").change(function () {
		if (markerEmpresa != null) mapsPlaceholder[0].removeLayer(markerEmpresa);
		for(i = 0; i < routingControls.length; i++){
			if (routingControls[i] != null) mapsPlaceholder[0].removeControl(routingControls[i]);
		}
		//eliminarCirculo();
		nombres = new Array();
		marker = new Array();
        document.getElementById("empresa").selectedIndex = "0"; 
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
				document.getElementById("botonRutaCercanaDestino").style.display = "block";
				document.getElementById("trayectoDestino").value = "Trayecto de ruta: " +
					"de " + nombrePartida + " " +
                    "a " + nombreDestino;
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
							puntosParadas.push([lat, lng]);
							nombres[i] = descripcion[i];
							waypoints.push(L.latLng(lat, lng));
							var marker2 = L.marker([lat, lng]);
							marker.push(marker2);
						}
						var customOptions = {'maxWidth': '2000', 'className': 'custom'};	
						routingControl = L.Routing.control({
											waypoints: waypoints,
											createMarker: function (i, wp, nWps) {
												return L.marker(wp.latLng, {title:nombres[i+1]})
													.bindPopup("Ruta: " + numeroRuta + "<br>" +
															   "Nombre de la parada: " + nombres[i+1], customOptions);
											}, draggableWaypoints: false, addWaypoints: false,
										}).addTo(mapsPlaceholder[0]);
						routingControls.push(routingControl);
						lat = puntos[1][0];
						lng = puntos[1][1];
						mapsPlaceholder[0].panTo([lat, lng]);
					}
				});
                $.ajax({
					url: 'Scripts/infoRutaEmpresa.php',
					type: 'post',
					data: {
						ruta: rutaid
					},
					dataType: 'json',
					success: function (response) {
                        var info = response[0]['info'];
                        select = document.getElementById('nombreEmpresasDestino');
                        var length = select.options.length;
                        for (i = 0; i < length; i++) {
                            select.options[i] = null;
                        }
						$("#nombreEmpresasDestino").empty();
						option = document.createElement( 'option' );
						option.value = 0;
						option.text = "Empresas que la recorren";
						option.style.display = "none";
						select.add(option);
						for (i = 1; i < info.length; i++) {
                            option = document.createElement( 'option' );
                            option.value = info[i][0];
							option.text = info[i][1];
                            select.add(option);
						}
					}
				});
			}
		});
	});
	
});
