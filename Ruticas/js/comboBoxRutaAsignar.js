$(document).ready(function() {
  $("#ruta").change(function() {
	document.getElementById("costo").value = "";
	document.getElementById("duracion").value = "";
	document.getElementById("discapacitado").checked = false;
  document.getElementById("horaStart").value = "";
  document.getElementById("horaEnd").value = "";
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
          document.getElementById("numero").value = numeroRuta;
          document.getElementById("descripcion").value = descripcion;
		  document.getElementById("trayecto").value = "Trayecto de ruta: " +
													  "de " + nombrePartida + " " +
													  "a " + nombreDestino;
        }
      });
	  empresaid = document.getElementById("empresa").value;
	  rutaid = document.getElementById("ruta").value;
	  if (empresaid != 0){
		  $.ajax({
			url: 'Scripts/revisarVinculacion.php',
			type: 'post',
			data: {
			  ruta: rutaid,
			  empresa: empresaid
			},
			dataType: 'json',
			success: function(response) {
			  var vinculado = response[0]['existe'];
			  if(vinculado == 1){
				document.getElementById("botonCambiarEstadoVinculacion").style = "width:100%; display:block;";
				document.getElementById("botonSubmit").value = 'Actualizar';
				document.getElementById("tipoVinculacion").value = '1';
				$.ajax({
					url: 'Scripts/infoVinculacion.php',
					type: 'post',
					data: {
					  ruta: rutaid,
					  empresa: empresaid
					},
					dataType: 'json',
					success: function(response) {
					  var costo = response[0]['costo'];
					  var duracion = response[0]['duracion'];
					  var discapacitado = response[0]['discapacitado'];
            var horaini = response[0]['horaI'];
					  var horafini = response[0]['horaF'];
					  if (discapacitado == 1){
						  discapacitado = true;
					  } else {
						  discapacitado = false;
					  }
					  document.getElementById("costo").value = costo;
					  document.getElementById("duracion").value = duracion;
					  document.getElementById("discapacitado").checked = discapacitado;
            document.getElementById("horaStart").value = horaini;
					  document.getElementById("horaEnd").value = horafini;
					}
				});
			  } else {
				document.getElementById("botonCambiarEstadoVinculacion").style = "width:100%; display:none;";
				document.getElementById("botonSubmit").value = 'Vincular';
				document.getElementById("tipoVinculacion").value = '0';
			  }
			}
		  });
	  }
  });
});
