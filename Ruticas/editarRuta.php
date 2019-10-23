<?php
	include "conexion.php";
	session_start();
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
		<link rel="shortcut icon" href="img/favicon.ico">
		<script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
        		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
		<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
		<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
		<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
		<style>
        #map {
            width: 100%;
            height: 380px; }
		nav ul {
			list-style-type: none;
		}
		[data-tip] {
			position:relative;
		}
		[data-tip]:before {
			content:'';
			/* hides the tooltip when not hovered */
			display:none;
			content:'';
			border-left: 5px solid transparent;
			border-right: 5px solid transparent;
			border-bottom: 5px solid #1a1a1a;
			position:absolute;
			top:30px;
			left:50%;
			z-index:8;
			font-size:0;
			line-height:0;
			width:0;
			height:0;
		}
		[data-tip]:after {
			display:none;
			content:attr(data-tip);
			position:absolute;
			top:35px;
			left:40%;
			padding:5px 8px;
			background:#1a1a1a;
			color:#fff;
			z-index:9;
			font-size: 0.75em;
			height:110%;
			line-height:18px;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			white-space:pre-wrap;
		}
		[data-tip]:hover:before,
		[data-tip]:hover:after {
			display:block;
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
									<div class="dropdown">
									  <button class="btn btn-danger dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Empresas
									  </button>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<ul>
											<li>
												<a class="dropdown-item" href="crearEmpresa.php">Crear empresa</a>
											</li>
											<li>
												<a class="dropdown-item" href="editarEmpresa.php">Editar empresa</a>
											</li>
										</ul>
									  </div>
									  &nbsp;&nbsp;
									</div>
								</li>
								<li>
									<div class="dropdown">
									  <button class="btn btn-danger dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										Rutas
									  </button>
									  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<ul>
											<li>
												<a class="dropdown-item" href="crearRuta.php">Crear ruta</a>
											</li>
											<div class="dropdown-divider"></div>
											<li>
												<a class="dropdown-item" href="#">Editar rutas</a>
											</li>
											<li>
												<a class="dropdown-item" href="asignarRuta.php">Asignar rutas</a>
											</li>
										</ul>
									  </div>
									  &nbsp;&nbsp;
									</div>
								</li>
								<li>
									<button class="btn btn-danger dropdown-toggle" onclick="location.href='log.php';">
										Log
									</button>
									&nbsp;&nbsp;
								</li>
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
				Editar ruta:
				<?php
					$sql = "call getRutasSimple()";
					$res = $conn->query($sql);
				?>
				<select name="ruta" id="ruta">
					<option value="0" style="display:none;">Seleccione una ruta</option>
					<?php while ($row = $res->fetch_array()) {
						if (!empty($row['numeroRuta'])) {?>
						<option value="<?php echo $row['idRuta']; ?>">
						  <?php echo $row['numeroRuta']; ?>
						</option>
					<?php }
					}
					$res->close();
					$conn->next_result();
					?>
				</select>
				<h2>
			</div>
		</section>

		<section id="maincontent" class="inner">
			<div class="container">
				<div class="row">
					<form id="register-form" action="Scripts/modificarRuta.php" method="post" role="form" >
						<div class="span8">
							<!-- Aquí va el mapa -->
							<div id="map">
								<script type="text/javascript" src="js/mapaEditarRuta.js"></script>
							</div>
							<div class="row">
								<div class="span4"><br><br>
									<button type="button" class="btn btn-register" style="width:100%;" onclick="window.location.reload();">
									<!--<button type="button" class="btn btn-register" style="width:100%;" onclick="eliminarPuntos();">-->
										Volver a trazar
									</button>
								</div>
								<div class="span4"><br>
									<input name="puntos" id="puntos" type="text" style="display:none;">
									<h6 align="center"><input id="listo" name="listo" type="checkbox" style="height:30px;">&nbsp; He trazado la ruta correctamente<h6>
									<font style="color:Red"><?php echo $_SESSION["error_listo"]; unset($_SESSION["error_listo"]); ?></font>									
								</div>
							</div>
						</div>

						<div class="span4">							
							<div class="form-group" data-tip="El número de ruta debe ser de máximo 45 caracteres">
								<input type="text" name="numero" id="numero" class="form-control" placeholder="Número de la ruta" maxlength="45" required>
								<font style="color:Red"><?php echo $_SESSION["error_numero"]; unset($_SESSION["error_numero"]); ?></font>
							</div>
							<div class="form-group">
								<textarea name="descripcion" id="descripcion" rows="5" placeholder="Descripción del ruta" style="resize: none;" maxlength="250" required></textarea>
								<font style="color:Red"><?php echo $_SESSION["error_descripcion"]; unset($_SESSION["error_descripcion"]); ?></font>
							</div>
							<div class="form-group" data-tip="El trayecto actual de la ruta. Seleccione otro en las opciones de abajo si desea cambiarlo.">
								<input type="text" name="trayecto" id="trayecto" readonly>
								<input type="text" name="idDistritoPartida" id="idDistritoPartida" style="display:none;" readonly>
								<input type="text" name="idDistritoDestino" id="idDistritoDestino" style="display:none;" readonly>
							</div>
							<div class="row">								
								<div class="span2">
									Lugar de partida:<br><br>
									<select name="provinciaPartida" id="provinciaPartida" class="form-control" style="width:100%;" required>
										<option value="">Seleccione una provincia</option>
										<?php
											$sql = "call getProvincias()";
											$res = $conn->query($sql);
											$provincias = "";
											while ($row = $res->fetch_array()) {
												$provincias.= "<option value='".$row["idProvincia"]."'>".$row["nombre"]."</option>";
											}
											echo $provincias;
											$res->close();
											$conn->next_result();
										?>
									</select>
									<select name="cantonPartida" id="cantonPartida" class="form-control" style="width:100%;" required>
										<option value="">Seleccione un cantón</option>
									</select>
									<select name="distritoPartida" id="distritoPartida" class="form-control" style="width:100%;" required>
										<option value="0">Seleccione un distrito</option>
									</select>
								</div>
								<div class="span2">
									Lugar de destino:<br><br>
									<select name="provinciaDestino" id="provinciaDestino" class="form-control" style="width:100%;" required>
										<option value="">Seleccione una provincia</option>
										<?php
											$sql = "call getProvincias()";
											$res = $conn->query($sql);
											$provincias = "";
											while ($row = $res->fetch_array()) {
												$provincias.= "<option value='".$row["idProvincia"]."'>".$row["nombre"]."</option>";
											}
											echo $provincias;
										?>
									</select>
									<select name="cantonDestino" id="cantonDestino" class="form-control" style="width:100%;" required>
										<option value="">Seleccione un cantón</option>
									</select>
									<select name="distritoDestino" id="distritoDestino" class="form-control" style="width:100%;" required>
										<option value="0">Seleccione un distrito</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="span2">
									<button type="button" class="btn" style="width:100%;" onclick="location.href='Scripts/cambiarEstadoRuta.php';" id='botonCambiarEstadoRuta'>-----</button>
								</div>
								<div class="span2">
									<input type="submit" class="btn" style="font-size: 16px; padding: 11px 19px;" value="Guardar">
								</div>
							</div>
						</div>
					</form>
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
							<li><a href="https://www.instagram.com/n4chogs">  <i class="icon-circled icon-bgdark icon-instagram icon-2x"></i></a></li>
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
		<script src="js/jquery.tweet.js"></script>
		<script src="js/custom.js"></script>
		<script type="text/javascript" src="js/comboBoxRuta.js"></script>
		<script type="text/javascript" src="js/armarDireccionPartida.js"></script>
		<script type="text/javascript" src="js/armarDireccionDestino.js"></script>		
	</body>
</html>
