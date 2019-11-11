function limpiarDestino() {
    var select = document.getElementById('rutasDestino');
    $("#rutasDestino").empty();
    option = document.createElement('option');
    option.value = 0;
    option.text = "Seleccione una ruta";
    option.style.display = "none";
    select.add(option);
    document.getElementById("trayectoDestino").value = "";
    select = document.getElementById('nombreEmpresasDestino');
    $("#nombreEmpresasDestino").empty();
    option = document.createElement('option');
    option.value = 0;
    option.text = "Empresas que la recorren";
    option.style.display = "none";
    select.add(option);
    document.getElementById("infoRutaDestino").style.display = "none";
}