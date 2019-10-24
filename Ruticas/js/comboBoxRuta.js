$(document).ready(function() {
  $("#ruta").change(function() {
    var rutaid = $(this).val();
      $.ajax({
        url: 'Scripts/infoRuta.php',
        type: 'post',
        data: {
          ruta: rutaid
        },
        dataType: 'json',
        success: function(response) {
          var numeroRuta = response[0]['numeroRuta'];
          var descripcion = response[0]['descripcion'];
          var nombrePartida = response[0]['nombrePartida'];
          var nombreDestino = response[0]['nombreDestino'];
		  var idDistritoPartida = response[0]['idDistritoPartida'];
          var idDistritoDestino = response[0]['idDistritoDestino'];
		  
          document.getElementById("numero").value = numeroRuta;
          document.getElementById("descripcion").value = descripcion;
		  document.getElementById("trayecto").value = "Trayecto de ruta: " +
													  "de " + nombrePartida + " " +
													  "a " + nombreDestino;
		  document.getElementById("idDistritoPartida").value = idDistritoPartida;
		  document.getElementById("idDistritoDestino").value = idDistritoDestino;
		  document.getElementById("idRuta").value = rutaid;
		  $.ajax({
			url: 'Scripts/cargarPuntos.php',
			type: 'post',
			data: {
			  ruta: rutaid
			},
			dataType: 'json',
			success: function(response) {			  
			var puntos = response[0]['puntos'];
			var waypoints = new Array();
			for(i=1;i<puntos.length;i++){
				lat = puntos[i][0];
				lng = puntos[i][1];
				waypoints.push(L.latLng(lat, lng));
				var marker2 = L.marker([lat, lng],{title:"Posición "+cont});
				marker.push(marker2);
				document.getElementById("puntos").value = JSON.stringify(marker);
			} 
			//if (routingControl != null) map.removeControl(routingControl);
			routingControl = L.Routing.control({waypoints:waypoints, draggableWaypoints:false}).addTo(mapsPlaceholder[0]);
			lat = puntos[1][0];
			lng = puntos[1][1];
			mapsPlaceholder[0].panTo([lat,lng]);
			dibujar = true;
			}
		  });
        }
      });
  });
});
