<?php
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
							<button class="btn btn-danger dropdown-toggle" onclick="location.href='guest.php';">
								Ingresar como invitado
							</button>&nbsp;&nbsp;
							<button class="btn btn-danger dropdown-toggle" onclick="location.href='moduloLogin/index.php';">
								Iniciar sesión
							</button>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>

	<div id="header-wrapper" class="header-slider">
		<header class="clearfix">
			<div class="logo">
				<h1>Proyecto Ruticas</h1>
			</div>
			<div class="container">
				<div class="row">
					<div class="span12">
						<div id="main-flexslider" class="flexslider">
							<ul class="slides">
								<li>
									<p class="home-slide-content">
										<strong>Consulte</strong> Rutas
									</p>
								</li>
								<li>
									<p class="home-slide-content">
										Ubicación de<strong> Paradas</strong>
									</p>
								</li>
								<li>
									<p class="home-slide-content">
										<strong>Información </strong> de empresas
									</p>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</header>
	</div>

	<section class="spacer green">
		<div class="container">
			<div class="row">
				<br><br>
				<div class="span8 alignright flyLeft">
					<blockquote class="large" align="left">
						Ruticas busca aportar información actualizada sobre rutas de servicios de transporte público, en
						particular de autobuses, en una zona geográfica.
					</blockquote>
				</div>
				<div class="span4 aligncenter flyRight">
					<br><img src="img/bus.png">
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
	<script src="contactform/contactform.js"></script>
</body>

</html>