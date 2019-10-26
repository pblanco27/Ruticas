<?php
session_start();
unset($_SESSION["mensajeRegistro"]);
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
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin="" />
	<script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js" integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og==" crossorigin=""></script>
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
								<button class="btn btn-danger dropdown-toggle" onclick="location.href='#';">
									Consultas
								</button>
								&nbsp;&nbsp;
							</li>
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
												<a class="dropdown-item" href="editarRuta.php">Editar rutas</a>
											</li>
											<div class="dropdown-divider"></div>
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
								<button class="btn btn-danger dropdown-toggle" id="botonAjuste" name="botonAjuste" data-toggle="modal" data-target="#cambiarPass" onclick="document.getElementById('cambiarPass').style.visibility = 'visible' ;">
									<img src="img/gear.png" height="19" width="20">
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
			<h2 class="pagetitle" style="color:white;">Consultar información<h2>
		</div>
	</section>

	<section id="maincontent" class="inner">
		<div class="container">
			<div class="row">
				<div class="span8">
					<!-- Aquí va el mapa -->
					<div id="map">
						<script>
							var map = L.map('map').setView([9.938118, -84.075391], 14);

							L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
								attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://cloudmade.com">CloudMade</a>',
								maxZoom: 18
							}).addTo(map);


							L.control.scale().addTo(map);
							//L.marker([9.938118,-84.075391], {draggable: true}).addTo(map);
							// L.Routing.control({
							// 	waypoints: [
							// 		L.latLng(9.938118, -84.075391),
							// 		L.latLng(9.935428, -84.071388),
							// 		L.latLng(9.928192, -84.078832)
							// 	]
							// }).addTo(map);
						</script>
					</div>
				</div>

				<div class="span4">
				</div>
			</div>
		</div>
	</section>

	<div id="cambiarPass" class="modal" style="visibility:hidden;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="row">
						<div class="span4">
							<h4 class="modal-title">Cambiar Contraseña</h4>
						</div>
						<div class="span1">
							<button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#editar" aria-hidden="true">×</button>
						</div>
					</div>
					<!-- <h4 class="modal-title">Cambiar Contraseña</h4>
					<button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#editar" aria-hidden="true">×</button> -->
				</div>
				<div class="modal-body text-center">
					<div class="col-md-12 col-sm-12 no-">
						<form action="moduloLogin/validarCambioClave.php" method="post" id="cambiarpassword" class="log-frm" name="userRegisterFrm">
							<label>Contraseña actual</label>
							<input type="password" placeholder="Contraseña actual" name="clave_actual" id="clave_actual" class="form-control">
							<br>
							<font style="color:Red"><?php echo $_SESSION["error_clave_actual"]; ?></font><br><br>
							<label>Nueva contraseña</label>
							<input type="password" placeholder="Nueva contraseña" name="nueva_clave" id="nueva_clave" class="form-control">
							<br>
							<font style="color:Red"><?php echo $_SESSION["error_nueva_clave"]; ?></font><br><br>
							<label>Confirmar Nueva Contraseña</label>
							<input type="password" placeholder="Confirmar nueva contraseña" name="confirmar_clave" id="confirmar_clave" class="form-control">
							<br>
							<font style="color:Red"><?php echo $_SESSION["error_confirmacion"]; ?></font><br><br>
							<input type="submit" name="userRegBtn" class="form-control btn btn-register" value="Cambiar">
						</form>
					</div>
					<div class="clearfix"></div>
					<?php
					if (isset($_SESSION["mensaje"])) {
						echo "<script language='javascript'>alert('Se ha cambiado la clave exitosamente.');</script>";
						unset($_SESSION["mensaje"]);
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<?php
	if ($_SESSION['nuevo'] == 1) {
		//echo "<script language='javascript'>alert('Deberia estar el modal.');</script>";
		echo "<script>
		document.getElementById('botonAjuste').click();
			</script>";
	}
	?>

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

</body>

</html>