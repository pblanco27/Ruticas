function limpiarConsulta() {
	document.getElementById("botonRutaCercana").style.display = "none";
    document.getElementById("numeroRutaParada").value = "";
    document.getElementById("descripcionRutaParada").value = "";
    document.getElementById("trayectoRutaParada").value = "";
    $("#nombreEmpresasParada").empty();
    select = document.getElementById('nombreEmpresasParada');
    option = document.createElement('option');
    option.value = 0;
    option.text = "Empresas que la recorren";
    option.style.display = "none";
    select.add(option);
    select = document.getElementById('rutaParada');
    $("#rutaParada").empty();
    option = document.createElement('option');
    option.value = 0;
    option.text = "Número de la ruta";
    option.style.display = "none";
    select.add(option);
}