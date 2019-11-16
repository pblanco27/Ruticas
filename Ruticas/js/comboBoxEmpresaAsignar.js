$(document).ready(function() {
  $("#empresa").change(function() {
	document.getElementById("costo").value = "";
	document.getElementById("duracion").value = "";
	document.getElementById("discapacitado").checked = false;
  document.getElementById("horaStart").value = "";
  document.getElementById("horaEnd").value = "";
    var empid = $(this).val();
      $.ajax({
        url: 'Scripts/infoEmpresa.php',
        type: 'post',
        data: {
          emp: empid
        },
        dataType: 'json',
        success: function(response) {
          var nom = response[0]['nombre'];
          var contacto = response[0]['contacto'];
          var dirF = response[0]['fisica'];
          var correo = response[0]['correo'];
          var hor1 = response[0]['horario1'];
          var hor2 = response[0]['horario2'];
          var lat = response[0]['lat'];
          var long = response[0]['long'];
          var tel = response[0]['telefono'];
          var zona = response[0]['zona'];
          var activado = response[0]['activado'];
          document.getElementById("nombre").value = nom;
          document.getElementById("zona").value = zona;
          document.getElementById("direccion").value = dirF;
          document.getElementById("latitud").value = lat;
          document.getElementById("longitud").value = long;
          document.getElementById("telefono").value = tel;
          document.getElementById("correo").value = correo;
          document.getElementById("contacto").value = contacto;
          document.getElementById('horaInicio').getElementsByTagName('option')[hor1-1].selected  = 'selected';
          document.getElementById('horaFin').getElementsByTagName('option')[hor2-1].selected  = 'selected';

		  if (typeof mapsPlaceholder != 'undefined'){
			  // Nos movemos a la posición de la empresa
			  mapsPlaceholder[0].panTo([lat,long]);

			  // Añadimos un marcador si no está creado
			  if (marcadores[empid] != 1){
				L.marker([lat,long], {title:nom}).addTo(mapsPlaceholder[0]);
				marcadores[empid] = 1;
			  }

			  // Se cambia el mensaje del boton de cambiar estado
			  if(activado == 1){
				document.getElementById("botonCambiarEstadoEmpresa").firstChild.data = 'Deshabilitar';
			  } else {
				document.getElementById("botonCambiarEstadoEmpresa").firstChild.data = 'Habilitar';
			  }
		  }
        }
      });
	  rutaid = document.getElementById("ruta").value;
	  empresaid = document.getElementById("empresa").value;
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
