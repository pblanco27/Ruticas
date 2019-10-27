function agregarDescripcion(n, lat, lng) {
    var name = document.getElementById("marker" + n).value;
    if(name == ""){
        document.getElementById("alertaMal").style = "visibility:show;";
    }
    else{
		numeroPopups = numeroPopups + 1;
		var marker2 = L.marker([lat, lng]);
		marker.push(marker2);
        nombres[numeroPopups] = name;
		mapsPlaceholder[0].closePopup();
		dibujarRuta();
		document.getElementById("puntos").value = JSON.stringify(marker);
		document.getElementById("nombres").value = JSON.stringify(nombres);
    }
}
