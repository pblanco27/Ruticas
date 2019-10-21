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
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
              integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
              crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
                integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
                crossorigin=""></script>
		<style>
        #map {
            width: 100%;
            height: 450px; }
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
												<a class="dropdown-item" href="#">Crear ruta</a>
											</li>
											<div class="dropdown-divider"></div>
											<li>
												<a class="dropdown-item" href="editarRuta.php">Editar rutas</a>
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
				<h2 class="pagetitle" style="color:white;">Crear ruta<h2>
			</div>
		</section>

		<section id="maincontent" class="inner">
			<div class="container">
				<div class="row">
					<div class="span8">
						<!-- Aquí va el mapa -->
						<div id="map">
                            <script type="text/javascript" src="js/fun.js"></script>
                        </div>

						<!--
						<div class="tabbable">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#one" data-toggle="tab"><i class="icon-rocket"></i> One</a></li>
								<li><a href="#two" data-toggle="tab">Two</a></li>
								<li><a href="#three" data-toggle="tab">Three</a></li>
							</ul>

							<div class="tab-content">
								<div class="tab-pane active" id="one">
									<p>
										<strong>Augue iriure</strong> dolorum per ex, ne iisque ornatus veritus duo. Ex nobis integre lucilius sit, pri ea falli ludus appareat. Eum quodsi fuisset id, nostro patrioque qui id. Nominati eloquentiam in mea.
									</p>
									<p>
										No eum sanctus vituperata reformidans, dicant abhorreant ut pro. Duo id enim iisque praesent, amet intellegat per et, solet referrentur eum et.
									</p>
									<p>
										Tale dolor mea ex, te enim assum suscipit cum, vix aliquid omittantur in. Duo eu cibo dolorum menandri, nam sumo dicit admodum ei. Ne mazim commune honestatis cum, mentitum phaedrum sit et.
									</p>
								</div>
								<div class="tab-pane" id="two">
									<p>
										Tale dolor mea ex, te enim assum suscipit cum, vix aliquid omittantur in. Duo eu cibo dolorum menandri, nam sumo dicit admodum ei. Ne mazim commune honestatis cum, mentitum phaedrum sit et.
									</p>
									<p>
										Tale dolor mea ex, te enim assum suscipit cum, vix aliquid omittantur in. Duo eu cibo dolorum menandri, nam sumo dicit admodum ei. Ne mazim commune honestatis cum, mentitum phaedrum sit et.
									</p>
								</div>
								<div class="tab-pane" id="three">
									<p>
										Cu cum commodo regione definiebas. Cum ea eros laboramus, audire deseruisse his at, munere aeterno ut quo. Et ius doming causae philosophia, vitae bonorum intellegat usu cu.
									</p>
									<p>
										Tale dolor mea ex, te enim assum suscipit cum, vix aliquid omittantur in. Duo eu cibo dolorum menandri, nam sumo dicit admodum ei. Ne mazim commune honestatis cum, mentitum phaedrum sit et.
									</p>
								</div>
							</div>
						</div>
						-->
					</div>

					<div class="span4">
						<form id="register-form" action="Scripts/validarRuta.php" method="post" role="form" >
							<div class="form-group" data-tip="El número de ruta debe ser de máximo 45 caracteres">
								<input type="text" name="numero" id="numero" class="form-control" placeholder="Número de la ruta" maxlength="45" required>
								<font style="color:Red"><?php echo $_SESSION["error_nombre"]; ?></font>
							</div>
							<div class="form-group" data-tip="La descripción debe ser de máximo 250 caracteres" >
								<textarea name="descripcion" id="descripcion" rows="7" placeholder="Descripción del ruta" style="resize: none;" maxlength="250" required></textarea>
								<font style="color:Red"><?php echo $_SESSION["error_descripcion"]; ?></font>
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
										<option value="">Seleccione un distrito</option>
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
										<option value="">Seleccione un distrito</option>
									</select>									
								</div>
							</div>
							<div class="form-group">
								<input type="submit" class="form-control btn btn-register" value="Crear">
							</div>
						</form>

						<!--
						<div class="accordion" id="accordion2">
							<div class="accordion-group">
								<div class="accordion-heading">
									<a class="accordion-toggle active" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
									<i class="icon-minus"></i> Collapsible Group Item #1 </a>
								</div>
								<div id="collapseOne" class="accordion-body collapse in">
									<div class="accordion-inner">
										Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
										on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
										raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
									</div>
								</div>
							</div>
							<div class="accordion-group">
								<div class="accordion-heading">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
									<i class="icon-plus"></i> Collapsible Group Item #2 </a>
								</div>
								<div id="collapseTwo" class="accordion-body collapse">
									<div class="accordion-inner">
										Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
										on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
										raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
									</div>
								</div>
							</div>
							<div class="accordion-group">
								<div class="accordion-heading">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
									<i class="icon-plus"></i> Collapsible Group Item #3 </a>
								</div>
								<div id="collapseThree" class="accordion-body collapse">
									<div class="accordion-inner">
										Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird
										on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table,
										raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
									</div>
								</div>
							</div>
						</div>
						-->
					</div>
				</div>

				<!--
				<div class="row">
					<div class="span6">
						<h4>Alerts</h4>
						<div class="alert">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Warning!</strong> Best check yo self, you're not looking too good.
						</div>
						<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Oh snap!</strong> Change a few things up and try submitting again.
						</div>
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Well done!</strong> Change a few things up and try submitting again.
						</div>
						<div class="alert alert-info">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Heads up!</strong> Change a few things up and try submitting again.
						</div>
					</div>
					<div class="span6">
						<h4>Progress</h4>
						<div class="progress progress-primary">
							<div class="bar" style="width: 40%;"></div>
						</div>
						<div class="progress progress-striped">
							<div class="bar" style="width: 20%;"></div>
						</div>
						<div class="progress progress-striped active">
							<div class="bar" style="width: 40%;"></div>
						</div>
						<div class="progress progress-success">
							<div class="bar" style="width: 50%;"></div>
						</div>

						<div class="progress progress-info">
							<div class="bar" style="width: 60%;"></div>
						</div>
						<div class="progress progress-warning">
							<div class="bar" style="width: 70%;"></div>
						</div>
						<div class="progress progress-danger">
							<div class="bar" style="width: 80%;"></div>
						</div>

					</div>
				</div>

				<div class="row">
					<div class="span12">
						<h4 class="heading">Button types<span></span></h4>
						<a href="#" class="btn">btn default</a>
						<a href="#" class="btn btn-theme">btn btn-theme</a>
						<a href="#" class="btn btn-primary">btn-primary</a>
						<a href="#" class="btn btn-warning">btn-warning</a>
						<a href="#" class="btn btn-danger">btn-danger</a>
						<a href="#" class="btn btn-info">btn-info</a>
						<a href="#" class="btn btn-success">btn-success</a>
						<a href="#" class="btn btn-inverse">btn-inverse</a>
					</div>
				</div>


				<div class="row">
					<div class="span6">

						<h4 class="heading">Button sizes<span></span></h4>

						<p>There are 4 button sizes: mini, small, normal and large</p>

						<a href="#" class="btn btn-mini btn-primary">mini size</a>
						<a href="#" class="btn btn-small btn-warning">small size</a>
						<a href="#" class="btn btn-danger">normal size</a>
						<a href="#" class="btn btn-large btn-info">Large size</a>

					</div>
					<div class="span6">
						<h4 class="heading">Button edge<span></span></h4>

						<p>There are 3 button edge variations: normal, rounded and flat. Simply adding <code>btn-rounded</code> or <code>btn-flat</code> class and you'll get different button edge</p>

						<a href="#" class="btn btn-primary">normal primary</a>

						<a href="#" class="btn btn-warning btn-rounded">rounded button</a>
						<a href="#" class="btn btn-danger btn-flat">flat button</a>

						<a href="#" class="btn btn-primary btn-large btn-rounded">large rounded</a>
						<a href="#" class="btn btn-warning btn-mini btn-rounded">rounded button</a>
					</div>
				</div>

				-->
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
		<script type="text/javascript" src="js/armarDireccionPartida.js"></script>
		<script type="text/javascript" src="js/armarDireccionDestino.js"></script>
	</body>

</html>
