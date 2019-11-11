function calcularRutaCercana() {
	var posActual = [latlng.lat, latlng.lng];
	var paradaPos = [puntosParadas[0][0], puntosParadas[0][1]];
	var d = mapsPlaceholder[0].distance(paradaPos, posActual);
	var paradaMasCercana = paradaPos;
	var minimo = d;
	
	for (i = 1; i < puntosParadas.length; i++){
		// Sacamos la posición de la parada					
		paradaPos = [puntosParadas[i][0], puntosParadas[i][1]];

		// Sacamos la distancia que hay entre la posición del marcador y la posición actual del usuario
		d = mapsPlaceholder[0].distance(paradaPos, posActual);

		// Guardar el mínimo 
		if (d < minimo){
			minimo = d;
			paradaMasCercana = paradaPos;
		} 
	}
	
	var latitud = paradaMasCercana[0];
	var longitud = paradaMasCercana[1];

	var url = "https://www.google.com/maps/dir/" + posActual[0] + "," + posActual[1] + // posición de partida
											 "/" + latitud + "," + longitud +          // posición de llegada
											 "/@" + posActual[0] + "," + posActual[1] + ",17z/am=t/data=!3m1!4b1!4m2!4m1!3e2"; // centro del mapa
	// Abrir nuevo tab
    var win = window.open(url, '_blank');
    // Cambiar el foco al nuevo tab (punto opcional)
    win.focus();
}