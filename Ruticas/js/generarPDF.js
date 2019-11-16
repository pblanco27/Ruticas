function foto() {
	html2canvas(document.getElementById("map"), {
		scale: window.devicePixelRatio,
		logging: true,
		profile: true,
		allowTaint: true,
		useCORS: true
	}).then(function(canvas) {
		const data = canvas.toDataURL('img/jpg', 0.9);
		generarPDF(canvas.toDataURL('img', 0.9));

	});
}

function generarPDF(photo){
	var rutaid;
	var empresaid;
	var consulta = "";
	
	fotoBase = photo.replace('data:image/png;base64,','');
	//console.log(fotoBase);
	if (idConsulta != undefined) {
		if (idConsulta == 1) {
			rutaid = document.getElementById('nombreRutas').value;
			empresaid = document.getElementById('empresa').value;
		}
		else if (idConsulta == 2) {
			rutaid = document.getElementById('ruta').value;
			empresaid = document.getElementById('nombreEmpresas').value;
		}
		else if(idConsulta == 3){
			rutaid = document.getElementById('rutasDestino').value;
			empresaid = document.getElementById('nombreEmpresasDestino').value;
		}
		else if(idConsulta == 4){
			rutaid = document.getElementById('rutaParada').value;
			empresaid = document.getElementById('nombreEmpresasParada').value;
		}
		if (rutaid != 0 && empresaid != 0) {
			$.ajax({
				async: false,
				url: 'Scripts/infoEmpresa.php',
				type: 'post',
				data: {
				  emp: empresaid
				},
				dataType: 'json',
				success: function(response) {
					var nom = response[0]['nombre'];
					var contacto = response[0]['contacto'];
					var dirF = response[0]['fisica'];
					var correo = response[0]['correo'];
					var hor1 = response[0]['horario1'];
					var hor2 = response[0]['horario2'];
					var tel = response[0]['telefono'];
					var zona = response[0]['zona'];
					consulta = consulta + "<h3>Información de la empresa:</h3>";
					consulta = consulta + "Empresa: " + nom + "<br>";
					consulta = consulta + "Dirección física: " + dirF + "<br>";				
					consulta = consulta + "Zona en donde opera: " + zona + "<br>";
					consulta = consulta + "Número telefónico: " + tel + "<br>";
					consulta = consulta + "Correo electrónico: " + correo + "<br>";
					consulta = consulta + "Contacto de emergencia: " + contacto + "<br>";
					consulta = consulta + "Hora apertura: " + hor1 + "<br>";
					consulta = consulta + "Hora cierre: " + hor2 + "<br>";
				}
			});
			$.ajax({
				async: false,
				url: 'Scripts/infoRuta.php',
				type: 'post',
				data: {
					ruta: rutaid
				},
				dataType: 'json',
				success: function (response) {
					consulta = consulta + "<h3>Información de la ruta:</h3>";
					var numeroRuta = response[0]['numeroRuta'];
					var descripcion = response[0]['descripcion'];
					var nombrePartida = response[0]['nombrePartida'];
					var nombreDestino = response[0]['nombreDestino'];
					var trayecto = "de " + nombrePartida + " a " + nombreDestino;
					consulta = consulta + "Ruta: " + numeroRuta + "<br>";
					consulta = consulta + "Descripcion: " + descripcion + "<br>";
					consulta = consulta + "Trayecto: " + trayecto + "<br>";
				}
			});
			$.ajax({
				async: false,
				url: 'Scripts/cargarPuntos.php',
				type: 'post',
				data: {
					ruta: rutaid
				},
				dataType: 'json',
				success: function (response) {
					var puntos = response[0]['puntos'];
					var descripcion = response[0]['descripcion'];
					var listaParadas = "";
					for (i = 1; i < puntos.length; i++) {
						listaParadas = listaParadas + i + ". " +descripcion[i] + "<br>";
					}	
					consulta = consulta + "Lista de paradas: <br>" + listaParadas;				
				}
			});
			$.ajax({
				async: false,
				url: 'Scripts/infoVinculacion.php',
				type: 'post',
				data: {
					ruta: rutaid,
					empresa: empresaid
				},
				dataType: 'json',
				success: function (response) {
					if (divisaActual) {
						fx.settings = {
							from: "CRC",
							to: "USD"
						};
						costo = Number((fx.convert(response[0]['costo'])).toFixed(2));
						moneda = "dólares";
					}
					else {
						costo = response[0]['costo'];
						moneda = "colones";
					}
					duracion = response[0]['duracion'];
					discapacitado = response[0]['discapacitado'];
					if (discapacitado == 1) {
						discapacitado = "Sí";
					} else {
						discapacitado = "No";
					}						
					consulta = consulta + "<h3>Información adicional:</h3>";
					consulta = consulta + "Costo del pasaje: " + costo + " " + moneda + "<br>";
					consulta = consulta + "Duración del viaje: " + duracion + " minutos<br>";
					consulta = consulta + "Servicio para discapacitados: " + discapacitado + "<br>";
				}
			});
		} else if (rutaid != 0 && empresaid == 0){
			$.ajax({
				async: false,
				url: 'Scripts/infoRuta.php',
				type: 'post',
				data: {
					ruta: rutaid
				},
				dataType: 'json',
				success: function (response) {
					consulta = consulta + "<h3>Información de la ruta:</h3>";
					var numeroRuta = response[0]['numeroRuta'];
					var descripcion = response[0]['descripcion'];
					var nombrePartida = response[0]['nombrePartida'];
					var nombreDestino = response[0]['nombreDestino'];
					var trayecto = "de " + nombrePartida + " a " + nombreDestino;
					consulta = consulta + "Ruta: " + numeroRuta + "<br>";
					consulta = consulta + "Descripcion: " + descripcion + "<br>";
					consulta = consulta + "Trayecto: " + trayecto + "<br>";
				}
			});
			$.ajax({
				async: false,
				url: 'Scripts/cargarPuntos.php',
				type: 'post',
				data: {
					ruta: rutaid
				},
				dataType: 'json',
				success: function (response) {
					var puntos = response[0]['puntos'];
					var descripcion = response[0]['descripcion'];
					var listaParadas = "";
					for (i = 1; i < puntos.length; i++) {
						listaParadas = listaParadas + i + ". " +descripcion[i] + "<br>";
					}	
					consulta = consulta + "Lista de paradas: <br>" + listaParadas;
				}
			});
		} else if (rutasPorDibujar.length > 0){
			for (j = 1; j < rutasPorDibujar.length; j++) {
				$.ajax({
					async: false,
					url: 'Scripts/infoRuta.php',
					type: 'post',
					data: {
						ruta: rutasPorDibujar[j]
					},
					dataType: 'json',
					success: function (response) {
						consulta = consulta + "<h3>Información de la ruta:</h3>";
						var numeroRuta = response[0]['numeroRuta'];
						var descripcion = response[0]['descripcion'];
						var nombrePartida = response[0]['nombrePartida'];
						var nombreDestino = response[0]['nombreDestino'];
						var trayecto = "de " + nombrePartida + " a " + nombreDestino;
						consulta = consulta + "Ruta: " + numeroRuta + "<br>";
						consulta = consulta + "Descripcion: " + descripcion + "<br>";
						consulta = consulta + "Trayecto: " + trayecto + "<br>";
					}
				});
				$.ajax({
					async: false,
					url: 'Scripts/cargarPuntos.php',
					type: 'post',
					data: {
						ruta: rutasPorDibujar[j]
					},
					dataType: 'json',
					success: function (response) {
						var puntos = response[0]['puntos'];
						var descripcion = response[0]['descripcion'];
						var listaParadas = "";
						for (i = 1; i < puntos.length; i++) {
							listaParadas = listaParadas + i + ". " +descripcion[i] + "<br>";
						}	
						consulta = consulta + "Lista de paradas: <br>" + listaParadas;				
					}
				});
			}
		} else if (rutaid == 0 && empresaid != 0){
			$.ajax({
				async: false,
				url: 'Scripts/infoEmpresa.php',
				type: 'post',
				data: {
				  emp: empresaid
				},
				dataType: 'json',
				success: function(response) {
					var nom = response[0]['nombre'];
					var contacto = response[0]['contacto'];
					var dirF = response[0]['fisica'];
					var correo = response[0]['correo'];
					var hor1 = response[0]['horario1'];
					var hor2 = response[0]['horario2'];
					var tel = response[0]['telefono'];
					var zona = response[0]['zona'];
					consulta = consulta + "<h3>Información de la empresa:</h3>";
					consulta = consulta + "Empresa: " + nom + "<br>";
					consulta = consulta + "Dirección física: " + dirF + "<br>";				
					consulta = consulta + "Zona en donde opera: " + zona + "<br>";
					consulta = consulta + "Número telefónico: " + tel + "<br>";
					consulta = consulta + "Correo electrónico: " + correo + "<br>";
					consulta = consulta + "Contacto de emergencia: " + contacto + "<br>";
					consulta = consulta + "Hora apertura: " + hor1 + "<br>";
					consulta = consulta + "Hora cierre: " + hor2 + "<br>";
				}
			});
		}

		document.getElementById('consultaPDF').value = consulta;
		document.getElementById('foto').value = fotoBase;
		document.getElementById('botonGenerar').click();				
	}
}