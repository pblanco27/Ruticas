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
						Ruticas busca aportar de información actualizada sobre rutas de servicios de transporte público, en
						particular de autobuses, en una zona geográfica.
					</blockquote>
				</div>
				<div class="span4 aligncenter flyRight">
					<br><img src="img/bus.png">
				</div>
			</div>
		</div>
	</section>

	<!--
		<section id="about" class="section">
			<div class="container">
				<h4>Who We Are</h4>
				<div class="row">
					<div class="span4 offset1">
						<div>
							<h2>We live with <strong>creativity</strong></h2>
							<p>
								Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe
								al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores.
							</p>
						</div>
					</div>
					<div class="span6">
						<div class="aligncenter">
							<img src="img/icons/creativity.png" alt="" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="span2 offset1 flyIn">
						<div class="people">
							<img class="team-thumb img-circle" src="img/team/img-1.jpg" alt="" />
							<h3>John Doe</h3>
							<p>
								Art director
							</p>
						</div>
					</div>
					<div class="span2 flyIn">
						<div class="people">
							<img class="team-thumb img-circle" src="img/team/img-2.jpg" alt="" />
							<h3>Mike Doe</h3>
							<p>
								Web developer
							</p>
						</div>
					</div>
					<div class="span2 flyIn">
						<div class="people">
							<img class="team-thumb img-circle" src="img/team/img-3.jpg" alt="" />
							<h3>Neil Doe</h3>
							<p>
								Web designer
							</p>
						</div>
					</div>
					<div class="span2 flyIn">
						<div class="people">
							<img class="team-thumb img-circle" src="img/team/img-4.jpg" alt="" />
							<h3>Mark Joe</h3>
							<p>
								UI designer
							</p>
						</div>
					</div>
					<div class="span2 flyIn">
						<div class="people">
							<img class="team-thumb img-circle" src="img/team/img-5.jpg" alt="" />
							<h3>Stephen B</h3>
							<p>
								Digital imaging
							</p>
						</div>
					</div>
				</div>
			</div>

		</section>

		<section id="services" class="section orange">
			<div class="container">
				<h4>Services</h4>

				<div class="row">
					<div class="span3 animated-fast flyIn">
						<div class="service-box">
							<img src="img/icons/laptop.png" alt="" />
							<h2>Web design</h2>
							<p>
								Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							</p>
						</div>
					</div>
					<div class="span3 animated flyIn">
						<div class="service-box">
							<img src="img/icons/lab.png" alt="" />
							<h2>Web development</h2>
							<p>
								Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							</p>
						</div>
					</div>
					<div class="span3 animated-fast flyIn">
						<div class="service-box">
							<img src="img/icons/camera.png" alt="" />
							<h2>Photography</h2>
							<p>
								Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							</p>
						</div>
					</div>
					<div class="span3 animated-slow flyIn">
						<div class="service-box">
							<img src="img/icons/basket.png" alt="" />
							<h2>Ecommerce</h2>
							<p>
								Lorem Ipsum is simply dummy text of the printing and typesetting industry.
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="works" class="section">
			<div class="container clearfix">
				<h4>Our Works</h4>

				<div class="row">
					<div id="filters" class="span12">
						<ul class="clearfix">
							<li>
								<a href="#" data-filter="*" class="active">
									<h5>All</h5>
								</a>
							</li>
							<li>
								<a href="#" data-filter=".web">
									<h5>Web</h5>
								</a>
							</li>
							<li>
								<a href="#" data-filter=".print">
									<h5>Print</h5>
								</a>
							</li>
							<li>
								<a href="#" data-filter=".design">
									<h5>Design</h5>
								</a>
							</li>
							<li>
								<a href="#" data-filter=".photography">
									<h5>Photography</h5>
								</a>
							</li>
						</ul>
					</div>

				</div>
				<div class="row">
					<div class="span12">
						<div id="portfolio-wrap">

							<div class="portfolio-item grid print photography">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/1.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid print design web">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/2.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid print design">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/3.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid photography web">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/4.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid photography web">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/5.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid photography web">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/6.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid photography web">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/7.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid photography">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/8.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid photography web">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/9.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

							<div class="portfolio-item grid design web">
								<div class="portfolio">
									<a href="img/works/big.jpg" data-pretty="prettyPhoto[gallery1]" class="portfolio-image">
							<img src="img/works/10.png" alt="" />
							<div class="portfolio-overlay">
								<div class="thumb-info">
									<h5>Portfolio name</h5>
									<i class="icon-plus icon-2x"></i>
								</div>
							</div>
							</a>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="spacer bg3">
			<div class="container">
				<div class="row">
					<div class="span12 aligncenter flyLeft">
						<blockquote class="large">
							We are an established and trusted web agency with a reputation for commitment and high integrity
						</blockquote>
					</div>
					<div class="span12 aligncenter flyRight">
						<i class="icon-rocket icon-10x"></i>
					</div>
				</div>
			</div>
		</section>

		<section id="blog" class="section">
			<div class="container">
				<h4>Our Blog</h4>

				<div class="row">
					<div class="span3">
						<div class="home-post">
							<div class="post-image">
								<img class="max-img" src="img/blog/img1.jpg" alt="" />
							</div>
							<div class="post-meta">
								<i class="icon-file icon-2x"></i>
								<span class="date">June 19, 2013</span>
								<span class="tags"><a href="#">Design</a>, <a href="#">Blog</a></span>
							</div>
							<div class="entry-content">
								<h5><strong><a href="#">New design trends</a></strong></h5>
								<p>
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. &hellip;
								</p>
								<a href="#" class="more">Read more</a>
							</div>
						</div>
					</div>
					<div class="span3">
						<div class="home-post">
							<div class="post-image">
								<img class="max-img" src="img/blog/img2.jpg" alt="" />
							</div>
							<div class="post-meta">
								<i class="icon-file icon-2x"></i>
								<span class="date">June 19, 2013</span>
								<span class="tags"><a href="#">Design</a>, <a href="#">News</a></span>
							</div>
							<div class="entry-content">
								<h5><strong><a href="#">Retro is great</a></strong></h5>
								<p>
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. &hellip;
								</p>
								<a href="#" class="more">Read more</a>
							</div>
						</div>
					</div>
					<div class="span3">
						<div class="home-post">
							<div class="post-image">
								<img class="max-img" src="img/blog/img3.jpg" alt="" />
							</div>
							<div class="post-meta">
								<i class="icon-file icon-2x"></i>
								<span class="date">June 22, 2013</span>
								<span class="tags"><a href="#">Design</a>, <a href="#">Tips</a></span>
							</div>
							<div class="entry-content">
								<h5><strong><a href="#">Isometric mockup</a></strong></h5>
								<p>
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. &hellip;
								</p>
								<a href="#" class="more">Read more</a>
							</div>
						</div>
					</div>
					<div class="span3">
						<div class="home-post">
							<div class="post-image">
								<img class="max-img" src="img/blog/img4.jpg" alt="" />
							</div>
							<div class="post-meta">
								<i class="icon-file icon-2x"></i>
								<span class="date">June 27, 2013</span>
								<span class="tags"><a href="#">News</a>, <a href="#">Tutorial</a></span>
							</div>
							<div class="entry-content">
								<h5><strong><a href="#">Free icon set</a></strong></h5>
								<p>
									Lorem Ipsum is simply dummy text of the printing and typesetting industry. &hellip;
								</p>
								<a href="#" class="more">Read more</a>
							</div>
						</div>
					</div>
				</div>
				<div class="blankdivider30"></div>
				<div class="aligncenter">
					<a href="#" class="btn btn-large btn-theme">More blog post</a>
				</div>
			</div>
		</section>
		-->

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