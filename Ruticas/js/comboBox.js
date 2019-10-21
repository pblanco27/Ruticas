$(document).ready(function() {
  $("#empresa").change(function() {
    var empid = $(this).val();
      $.ajax({
        url: 'Scripts/infoEmpresa.php',
        type: 'post',
        data: {
          emp: empid
        },
        dataType: 'json',
        success: function(response) {
          console.log('Entre2');
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
          if(activado == 1){
            document.getElementById("botonCambiarEstadoEmpresa").firstChild.data = 'Deshabilitar';
          }else {
            document.getElementById("botonCambiarEstadoEmpresa").firstChild.data = 'Habilitar';
          }
          //map = L.map('map');
          //map.setView(new L.LatLng(lat, long),11,{animation:true});
        }
      });
  });
});
