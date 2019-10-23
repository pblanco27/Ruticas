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
		  $.ajax({
			url: 'Scripts/cargarPuntos.php',
			type: 'post',
			data: {
			  ruta: rutaid
			},
			dataType: 'json',
			success: function(response) {			  
			  var puntos = response[0]['puntos'];
			  
			  
			  document.getElementById("numero").value = numeroRuta;
			  document.getElementById("descripcion").value = descripcion;
			  document.getElementById("trayecto").value = "Trayecto de ruta: " +
														  "de " + nombrePartida + " " +
														  "a " + nombreDestino;
			  document.getElementById("idDistritoPartida").value = idDistritoPartida;
			  document.getElementById("idDistritoDestino").value = idDistritoDestino;
			  
			  
			}
		  });
		  
        }
      });
  });
});
