var panes = [];

$(document).ready(function () {
	$("#distrito").change(function () {
		//mapsPlaceholder[0]._panes.markerPane.remove();
		//mapsPlaceholder[0]._panes.overlayPane.remove();
		//mapsPlaceholder[0]._panes.shadowPane.remove();
		nombres = new Array();
		marker = new Array();
		dibujarRuta();
		
		//var top = document.getElementsByClassName("leaflet-top leaflet-right");
		//top[0].style.display = "block";
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
				var ids = response[0]['ids'];
				for (j = 1; j < ids.length; j++){
					mapsPlaceholder[0].createPane("pane" + j);
					panes.push("pane"+j);
					$.ajax({
						async: false,
						url: 'Scripts/cargarPuntos.php',
						type: 'post',
						data: {
							ruta: ids[j]
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
							//if (routingControl != null) map.removeControl(routingControl);
							var top = document.getElementsByClassName("leaflet-top leaflet-right");
							while (top[0].firstChild) {
							  top[0].removeChild(top[0].firstChild);
							}
							var customOptions = {'maxWidth': '2000', 'className': 'custom'};							
							routingControl = L.Routing.control({
												waypoints: waypoints,
												createMarker: function (i, wp, nWps) {
													return L.marker(wp.latLng, {title:nombres[i+1]});
												}, draggableWaypoints: false,	
												lineOptions: {
													styles: [{pane:"pane"+j, color: colors[j-1]}]
												}
											}).addTo(mapsPlaceholder[0]);
							var top = document.getElementsByClassName("leaflet-top leaflet-right");
							while (top[0].firstChild) {
							  top[0].removeChild(top[0].firstChild);
							}
							lat = puntos[1][0];
							lng = puntos[1][1];
							mapsPlaceholder[0].panTo([lat, lng]);
							dibujar = true;
						}
					});
				}
			}
		});
	});
});
