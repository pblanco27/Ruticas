function clickBoton(n, lat, lng) {
    var name = document.getElementById("waypoint" + n).value;
    if(name == ""){
        document.getElementById("alertaMal").style = "visibility:show;";
    }
    else{
        $.ajax({
            url: 'Scripts/notificaciones.php',
            type: 'post',
            data: {
                nombre: name,
                latitud: lat,
                longitud: lng
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("waypoint" + n).value = "";
                document.getElementById("alertaBien").style = "block";
            },
            error: function () {
                console.log("Error");
                document.getElementById("alertaMal").style = "block";
            }
        });
    }
}
