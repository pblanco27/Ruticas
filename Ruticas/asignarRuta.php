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
	<link rel="shortcut icon" href="img/bus-icon.png">
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
			height: 110%;
			line-height: 18px;
			-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			white-space: pre-wrap;
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
								<button class="btn btn-danger dropdown-toggle" onclick="location.href='start.php';">
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
									Historial
								</button>
								&nbsp;&nbsp;
							</li>
							<li>
								<button class="btn btn-danger" id="botonAjuste" name="botonAjuste" data-toggle="modal" data-target="#cambiarPass" onclick="document.getElementById('cambiarPass').style.visibility = 'visible';">
									<img src="img/gear.png" width="20">
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
				Asignar rutas:
				<h2>
		</div>
	</section>
	<section id="maincontent" class="inner">
		<div class="container">
			<div class="row">
				<div class="span4">
					<form id="register-form" action="Scripts/modificarVinculacion.php" method="post" role="form">
						<center>
							<div class="row">
								<?php
								$sql = "call getEmpresasSimple()";
								$res = $conn->query($sql);
								?>
								<div class="span1">
									Empresa:
								</div>
								<div class="span2">
									<select name="empresa" id="empresa">
										<option value="0" style="display:none;">Seleccione una empresa</option>
										<?php while ($row = $res->fetch_array()) {
											if (!empty($row['nombre'])) { ?>
												<option value="<?php echo $row['idEmpresa']; ?>">
													<?php echo $row['nombre']; ?>
												</option>
										<?php }
										} ?>
									</select>
								</div>
							</div>

							<div class="row">
								<?php
								$res->close();
								$conn->next_result();
								$sql = "call getRutasSimple()";
								$res = $conn->query($sql);
								?>
								<div class="span1">
									Ruta:
								</div>
								<div class="span2">
									<select name="ruta" id="ruta">
										<option value="0" style="display:none;">Seleccione una ruta</option>
										<?php while ($row = $res->fetch_array()) {
											if (!empty($row['numeroRuta'])) { ?>
												<option value="<?php echo $row['idRuta']; ?>">
													<?php echo $row['numeroRuta']; ?>
												</option>
										<?php }
										} ?>
									</select>
								</div>
							</div>
						</center>
						<p>Costo (colones):</p>
						<input type="text" id="costo" name="costo" placeholder="Costo Pasaje">
						<p>Hora de inicio del servicio:</p>
						<input type="time" id="horaStart" name="horaStart" required>
						<p>Hora de fin del servicio:</p>
						<input type="time" id="horaEnd" name="horaEnd" required>
						<p>Duración (min):</p>
						<input type="text" id="duracion" name="duracion" placeholder="Duracion del viaje (min)">
						<br>
						Unidades de discapacitados:
						<input type="checkbox" id="discapacitado" name="discapacitado" class="custom-control-input">
						<br>
						<br>
						<div class="row">
							<div class="span2">
								<button id="botonCambiarEstadoVinculacion" type="button" class="btn" style="width:100%; display:none;" onclick="location.href='Scripts/cambiarEstadoVinculacion.php';">Desvincular</button>
							</div>
							<div class="span2">
								<input id="botonSubmit" type="submit" class="btn" style="font-size: 16px; padding: 11px 19px;" value="Vincular">
								<input id="tipoVinculacion" name="tipoVinculacion" type="text" style="display:none;">
							</div>
						</div>
					</form>
				</div>
				<div class="span4">
					<h4>Empresa</h4>
					<div class="form-group">
						<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre de la empresa" maxlength="45" readonly>
					</div>
					<div class="form-group">
						<input type="text" name="zona" id="zona" class="form-control" placeholder="Zona donde opera" maxlength="45" readonly>
					</div>
					<div class="form-group">
						<input type="text" name="direccion" id="direccion" class="form-control" placeholder="Direccion física" maxlength="45" readonly>
					</div>
					<div class="form-group">
						<input type="text" name="latitud" id="latitud" class="form-control" placeholder="Latitud" style="display:none;" readonly>
					</div>
					<div class="form-group" style="display:none;">
						<input type="text" name="longitud" id="longitud" class="form-control" placeholder="Longitud" readonly>
					</div>
					<div class="form-group">
						<input type="text" name="telefono" id="telefono" class="form-control" placeholder="Número telefónico" maxlength="45" readonly>
					</div>
					<div class="form-group">
						<input type="email" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" maxlength="45" readonly>
					</div>
					<div class="form-group" data-tip="Contacto ante eventualidad.">
						<input type="text" name="contacto" id="contacto" class="form-control" placeholder="Contacto de emergencia" maxlength="45" readonly>
					</div>

					<div class="form-group">
						Hora inicio: &nbsp;&nbsp;<select name="horaInicio" id="horaInicio" class="form-control" placeholder="Seleccione una hora" readonly>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
						</select>
					</div>
					<div class="form-group">
						Hora cierre: &nbsp;<select name="horaFin" id="horaFin" class="form-control" placeholder="Seleccione una hora" readonly>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
						</select>
					</div>
				</div>
				<div class="span4">
					<h4>Ruta</h4>
					<div class="form-group">
						<input type="text" name="numero" id="numero" class="form-control" placeholder="Número de la ruta" maxlength="45" readonly>
					</div>
					<div class="form-group">
						<textarea name="descripcion" id="descripcion" rows="7" placeholder="Descripción del ruta" style="resize: none;" maxlength="250" readonly></textarea>
					</div>
					<div class="form-group">
						<input type="text" name="trayecto" id="trayecto" readonly>
					</div>
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
							<h3 class="modal-title">Ajustes</h3>
						</div>
						<div class="span1" style="float:right;">
							<button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#editar" aria-hidden="true" style="float:right;">×</button>
						</div>						
					</div>
					<div class="row">
						<div class="span2">
							<button class="btn btn-danger" onclick="document.getElementById('cambio').style.display = 'block';
																	document.getElementById('desactivacion').style.display = 'none';">
								Cambiar clave
							</button>						
						</div>
						<div class="span2.5" style="float:right;">
							<button class="btn btn-danger" onclick="document.getElementById('desactivacion').style.display = 'block';
																	document.getElementById('cambio').style.display = 'none';">
								Desactivar cuenta
							</button>
						</div>								
					</div>						
				</div>
				
				<div class="modal-body text-center">				
					<div class="col-md-12 col-sm-12 no-"  id="cambio" style="display:none;">
						<form action="moduloLogin/validarCambioClave.php" method="post"  class="log-frm" name="userRegisterFrm" >
							<label>Contraseña actual</label>
							<input type="password" placeholder="Contraseña actual" name="clave_actual"  class="form-control">
							<br>
							<font style="color:Red; font-size:15px"><?php echo $_SESSION["error_clave_actual"]; unset($_SESSION["error_clave_actual"]); ?></font><br><br>
							<label>Nueva contraseña</label>
							<input type="password" placeholder="Nueva contraseña" name="nueva_clave" id="nueva_clave" class="form-control">
							<br>
							<font style="color:Red; font-size:15px"><?php echo $_SESSION["error_nueva_clave"]; unset($_SESSION["error_nueva_clave"]); ?></font><br><br>
							<label>Confirmar Nueva Contraseña</label>
							<input type="password" placeholder="Confirmar nueva contraseña" name="confirmar_clave" id="confirmar_clave" class="form-control">
							<br>
							<font style="color:Red; font-size:15px"><?php echo $_SESSION["error_confirmacion"]; unset($_SESSION["error_confirmacion"]); ?></font><br><br>
							<input type="submit" name="userRegBtn" class="form-control btn btn-register" value="Cambiar">
						</form>
					</div>
					<div class="col-md-12 col-sm-12 no-"  id="desactivacion" style="display:none;">
						<form action="moduloLogin/validarDesactivacion.php" method="post"  class="log-frm" name="userRegisterFrm" >
							<label>Contraseña actual</label>
							<input type="password" placeholder="Contraseña actual" name="clave_actual"  class="form-control"><br>
							<font style="color:Red; font-size:15px"><?php echo $_SESSION["error_clave_incorrecta"]; unset($_SESSION["error_clave_incorrecta"]); ?></font><br><br>
							<p>
								Si desactiva su cuenta, no podrá volver a utilizarla nuevamente.<br>
								Si desea volver a utilizar el sistema, debe volver a registrarse con otro nombre de usuario.<br>
								Estos nombres son únicos y no se pueden recuperar.<br>
							</p><br>
							<h6 align="center"><input id="seguro" name="seguro" type="checkbox" style="height:30px;">&nbsp; Estoy seguro que deseo desactivar mi cuenta<h6>
							<font style="color:Red; font-size:15px"><?php echo $_SESSION["error_seguro"]; unset($_SESSION["error_seguro"]); ?></font><br><br>
							<input type="submit" name="userRegBtn" class="form-control btn btn-register" value="Desactivar">
						</form>
					</div>
					<div class="clearfix"></div>
					<?php
					if (isset($_SESSION["mensaje"])) {
						echo "<script>document.getElementById('exitoCambioClave').style = 'block';</script>";
						unset($_SESSION["mensaje"]);
					}
					?>
				</div>
			</div>
		</div>
	</div>
	
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
	<script type="text/javascript" src="js/comboBoxEmpresaAsignar.js"></script>
	<script type="text/javascript" src="js/comboBoxRutaAsignar.js"></script>
	<?php
		if ($_SESSION['nuevo'] == 1) {
			echo "<script>
				    $(window).on('load',function(){
					   $('#cambiarPass').modal('show');
					   document.getElementById('cambiarPass').style.visibility = 'visible';
					   document.getElementById('cambio').style.display = 'block';
					   document.getElementById('desactivacion').style.display = 'none';
				    });
				  </script>";
		}
		$_SESSION['nuevo'] = 0;
	?>
</body>

</html>