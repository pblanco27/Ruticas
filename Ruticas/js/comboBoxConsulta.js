$(document).ready(function() {
    $("#consulta").change(function() {
		var idConsulta = $(this).val();
		if (idConsulta == 1){
			document.getElementById("infoEmpresa").style.display = "block";   
			document.getElementById("infoRuta").style.display = "none";
			document.getElementById("infoDestino").style.display = "none";
			document.getElementById("infoRutaParada").style.display = "none";
			consulta4 = false;
			limpiarConsulta();
			limpiarParadas();
		} else if (idConsulta == 2){
			document.getElementById("infoRuta").style.display = "block";
			document.getElementById("infoEmpresa").style.display = "none";
			document.getElementById("infoDestino").style.display = "none";
			document.getElementById("infoRutaParada").style.display = "none";
			consulta4 = false;
			limpiarConsulta();
			limpiarParadas();
		} else if (idConsulta == 3){
			document.getElementById("infoDestino").style.display = "block";
			document.getElementById("infoRuta").style.display = "none";
			document.getElementById("infoEmpresa").style.display = "none";
			document.getElementById("infoRutaParada").style.display = "none";
			consulta4 = false;
			limpiarConsulta();
			limpiarParadas();
		} else if (idConsulta == 4){
			document.getElementById("infoRutaParada").style.display = "block";
			document.getElementById("infoRuta").style.display = "none";
			document.getElementById("infoEmpresa").style.display = "none";
			document.getElementById("infoDestino").style.display = "none";
			consulta4 = true;
			reiniciarParadas();
		}
	});
});
