$(document).ready(function () {
    $("#empresa").change(function () {
        nombres = new Array();
        marker = new Array();
        dibujarRuta();
        var empid = $(this).val();
        document.getElementById("ruta").selectedIndex = "0"; 
        $.ajax({
            url: 'Scripts/infoEmpresa.php',
            type: 'post',
            data: {
                emp: empid
            },
            dataType: 'json',
            success: function (response) {
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
                document.getElementById("telefono").value = tel;
                document.getElementById("correo").value = correo;
                document.getElementById("contacto").value = contacto;
                document.getElementById('horaInicio').value = hor1;
                document.getElementById('horaFin').value = hor2;
                document.getElementById("infoEmpresa").style.display = "block";
                document.getElementById("infoRuta").style.display = "none";
                if (typeof mapsPlaceholder != 'undefined') {
                    // Nos movemos a la posición de la empresa
                    mapsPlaceholder[0].panTo([lat, long]);

                    // Añadimos un marcador si no está creado
                    if (marcadores[empid] != 1) {
                        L.marker([lat, long], { title: nom }).addTo(mapsPlaceholder[0]);
                        marcadores[empid] = 1;
                    }
                }
            }
        });
        $.ajax({
            url: 'Scripts/infoEmpresaRuta.php',
            type: 'post',
            data: {
                emp: empid
            },
            dataType: 'json',
            success: function (response) {
                var nombres = response[0]['nombres'];
                var ids = response[0]['ids'];
                select = document.getElementById('nombreRutas');
                var length = select.options.length;
                console.log(length);
                $("#nombreRutas").empty();
                option = document.createElement( 'option' );
                option.value = 0;
                option.text = "Rutas que operan";
                option.style.display = "none";
                select.add( option );
                for (i = 1; i < nombres.length; i++) {
                    option = document.createElement( 'option' );
                    option.value = ids[i];
                    option.text = nombres[i];
                    select.add( option );
                }
            }
        });
    });
});
