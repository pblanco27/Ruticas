<?php
include "conexion.php";
?>

<!DOCTYPE HTML>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Proyecto Ruticas</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link href="color/default.css" rel="stylesheet">
	<link rel="shortcut icon" href="img/bus-icon.png">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
	<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style>
		#map {
			width: 100%;
			height: 450px;
		}

		nav ul {
			list-style-type: none;
		}

		[data-tip] {
			position: relative;
		}

		[data-tip]:before {
			content: '';
			/* hides the tooltip when not hovered */
			display: none;
			content: '';
			border-left: 5px solid transparent;
			border-right: 5px solid transparent;
			border-bottom: 5px solid #1a1a1a;
			position: absolute;
			top: 30px;
			left: 50%;
			z-index: 8;
			font-size: 0;
			line-height: 0;
			width: 0;
			height: 0;
		}

		[data-tip]:after {
			display: none;
			content: attr(data-tip);
			position: absolute;
			top: 35px;
			left: 40%;
			padding: 5px 8px;
			background: #1a1a1a;
			color: #fff;
			z-index: 9;
			font-size: 0.75em;
			height: 30px;
			line-height: 18px;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			white-space: nowrap;
			word-wrap: normal;
		}

		[data-tip]:hover:before,
		[data-tip]:hover:after {
			display: block;
		}
	</style>
</head>

<body>
	<div class="navbar-wrapper">
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
					</a>
					<img class="brand" src="img/ruticas.png">
					<nav class="pull-right nav-collapse collapse">
						<ul id="menu-main" class="nav">
							<li>
								<button class="btn btn-danger dropdown-toggle" onclick="location.href='index.php';">
									Salir
								</button>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<section class="spacer green">
		<div align="center">
			<h2 class="pagetitle" style="color:white;">
				Consultar información
				<select name="consulta" id="consulta">
					<option value="0" style="display:none;">Seleccione una consulta</option>
					<option value="1" >Todas las rutas de una empresa</option>
					<option value="2" >Una ruta en particular</option>
					<option value="3" >Rutas con un mismo destino</option>
					<option value="4" >Rutas con una misma parada intermedia</option>
				</select>
			</h2>
		</div>
	</section>

	<section id="maincontent" class="inner">
		<div class="container">
			<div class="row">
				<div class="span8">
					<!-- Aquí va el mapa -->
					<div id="map">
						<script type="text/javascript" src="js/mapaConsultas.js"></script>
					</div>
				</div>
				<div class="span4">
					<div id="infoEmpresa" style="display:none;">
						<h3>Información de la Empresa</h3>
						<?php
						$sql = "call getEmpresasSimpleActivado()";
						$res = $conn->query($sql);
						?>
						<select name="empresa" id="empresa" class="form-control" required>
							<option value="0" style="display:none;">Seleccione una empresa</option>
							<?php while ($row = $res->fetch_array()) {
								if (!empty($row['nombre'])) { ?>
									<option value="<?php echo $row['idEmpresa']; ?>">
										<?php echo $row['nombre']; ?>
									</option>
							<?php }
							} ?>
						</select><br>
						Nombre:
						<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la empresa" maxlength="45" readonly>
						Zona:
						<input type="text" name="zona" id="zona" class="form-control" placeholder="Zona donde opera" maxlength="45" readonly>
						Dirección:
						<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion física" maxlength="45" readonly>
						Teléfono:
						<input type="text" name="telefono" id="telefono" class="form-control" placeholder="Número telefónico" maxlength="45" readonly>
						Correo:
						<br>
						<input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" maxlength="45" readonly>
						<br>
						Información de Contacto:
						<input type="text" name="contacto" id="contacto" class="form-control" placeholder="Contacto de emergencia" maxlength="45" readonly>
						<div class="row">
							<div class="span2">
								Hora de Inicio:
								<input type="text" name="horaInicio" id="horaInicio" class="form-control" placeholder="Hora de inicio" maxlength="45" readonly>
							</div>
							<div class="span2">
								Hora de Cierre:
								<input type="text" name="horaFin" id="horaFin" class="form-control" placeholder="Hora de cierre" maxlength="45" readonly>
							</div>
						</div>
						Rutas que opera:
						<br>
						<select name="nombreRutas" id="nombreRutas">
						</select>
					</div>
					<div id="infoRuta" style="display: none;">
						<h3>Información de la Ruta</h3>						
						<?php
						$res->close();
						$conn->next_result();
						$sql = "call getRutasSimpleActivado()";
						$res = $conn->query($sql);
						?>
						<select name="ruta" id="ruta">
							<option value="0" style="display:none;">Seleccione una ruta</option>
							<?php while ($row = $res->fetch_array()) {
								if (!empty($row['numeroRuta'])) { ?>
									<option value="<?php echo $row['idRuta']; ?>">
										<?php echo $row['numeroRuta']; ?>
									</option>
							<?php }
							}
							?>
						</select><br>
						Número:
						<input type="text" name="numero" id="numero" class="form-control" placeholder="Número de la ruta" maxlength="45" readonly>
						Descripción:
						<textarea name="descripcion" id="descripcion" rows="5" placeholder="Descripción del ruta" style="resize: none;" maxlength="250" readonly></textarea>
						Trayecto:
						<input type="text" name="trayecto" placeholder="Trayecto" id="trayecto" readonly>
						Empresas que la recorren:
						<select name="nombreEmpresas" id="nombreEmpresas">
						</select>
					</div>
					<div id="infoDestino" style="display:none;">
						<h3>Información Destino</h3>
						<select name="provincia" id="provincia" class="form-control" style="width:100%;">
							<option value="">Seleccione una provincia</option>
							<?php
							$res->close();
							$conn->next_result();
							$sql = "call getProvincias()";
							$res = $conn->query($sql);
							$provincias = "";
							while ($row = $res->fetch_array()) {
								$provincias .= "<option value='" . $row["idProvincia"] . "'>" . $row["nombre"] . "</option>";
							}
							echo $provincias;
							$res->close();
							$conn->next_result();
							?>
						</select>
						<select name="canton" id="canton" class="form-control" style="width:100%;">
							<option value="">Seleccione un cantón</option>
						</select>
						<select name="distrito" id="distrito" class="form-control" style="width:100%;">
							<option value="">Seleccione un distrito</option>
						</select>
					</div>
					<div id="infoRutaParada" style="display: none;">
						<h3>Información de la Ruta</h3>						
						<select name="rutaParada" id="rutaParada">
							<option value="0" style="display:none;">Seleccione una ruta</option>
						</select><br>
						Número:
						<input type="text" name="numeroRutaParada" id="numeroRutaParada" class="form-control" placeholder="Número de la ruta" maxlength="45" readonly>
						Descripción:
						<textarea name="descripcionRutaParada" id="descripcionRutaParada" rows="5" placeholder="Descripción del ruta" style="resize: none;" maxlength="250" readonly></textarea>
						Trayecto:
						<input type="text" name="trayectoRutaParada" placeholder="Trayecto" id="trayectoRutaParada" readonly>
						Empresas que la recorren:
						<select name="nombreEmpresasParada" id="nombreEmpresasParada">
						</select>
						<br>
						<button onclick="reiniciarParadas()">Limpiar Consulta</button>
					</div>
				</div>
			</div>
		</div>
	</section>

	<footer>
		<div class="container">
			<div class="row">
				<h1>
					<font style="color:white;">
						Desarrolladores
					</font>
				</h1>
				<div class="span6 offset3">
					<ul class="social-networks">
						<li><a href="https://www.instagram.com/gabritico"><i class="icon-circled icon-bgdark icon-instagram icon-2x"></i></a></li>
						<li><a href="https://www.instagram.com/pblanco27"><i class="icon-circled icon-bgdark icon-instagram icon-2x"></i></a></li>
						<li><a href="https://www.instagram.com/n4chogs"> <i class="icon-circled icon-bgdark icon-instagram icon-2x"></i></a></li>
					</ul>
					<p class="copyright">
						Proyecto Ruticas
						<div class="credits">
							Instituto Tecnológico de Costa Rica
						</div>
					</p>
				</div>
			</div>
		</div>
	</footer>
	<a href="#" class="scrollup"><i class="icon-angle-up icon-square icon-bgdark icon-2x"></i></a>
	<script src="js/jquery.js"></script>
	<script src="js/jquery.scrollTo.js"></script>
	<script src="js/jquery.nav.js"></script>
	<script src="js/jquery.localScroll.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.prettyPhoto.js"></script>
	<script src="js/isotope.js"></script>
	<script src="js/jquery.flexslider.js"></script>
	<script src="js/inview.js"></script>
	<script src="js/animate.js"></script>
	<script src="js/custom.js"></script>
	<script type="text/javascript" src="js/comboBoxEmpresaConsulta.js"></script>
	<script type="text/javascript" src="js/comboBoxRutaEmpresaConsulta.js"></script> 
	<script type="text/javascript" src="js/comboBoxRutaConsulta.js"></script>
	<script type="text/javascript" src="js/comboBoxEmpresaRutaConsulta.js"></script> 
	<script type="text/javascript" src="js/armarDireccion.js"></script>
	<script type="text/javascript" src="js/rutasPorDistrito.js"></script>
	<script type="text/javascript" src="js/comboBoxConsulta.js"></script>
	<script type="text/javascript" src="js/comboBoxRutaConsultaParada.js"></script>
	<script type="text/javascript" src="js/limpiarConsulta.js"></script>
	<script type="text/javascript" src="js/comboBoxEmpresaRutaConsultaParada.js"></script> 
</body>

</html>