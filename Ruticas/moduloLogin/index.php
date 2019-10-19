<?php
	session_start();
	unset($_SESSION["mensaje"]);
	unset($_SESSION["nuevo"]);
	if (!isset($_SESSION["loginActivoTitulo"])) $_SESSION["loginActivoTitulo"] = "active";
	if (!isset($_SESSION["loginActivo"])) $_SESSION["loginActivo"] = "block";
	if (!isset($_SESSION["registrarActivo"])) $_SESSION["registrarActivo"] = "none";
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Proyecto Web</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script type="text/javascript" src="js/func.js"></script>
	</head>
	<body>
		<div class="container">
	    	<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-login">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-6">
									<a href="#" class="<?php echo $_SESSION["loginActivoTitulo"]?>" id="login-form-link">Iniciar sesión</a>
								</div>
								<div class="col-xs-6">
									<a href="#" class="<?php echo $_SESSION["registrarActivoTitulo"]?>" id="register-form-link">Registrarse</a>
								</div>
							</div>
							<hr>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<form id="login-form" action="validarLogin.php" method="post" role="form" style="display: <?php echo $_SESSION["loginActivo"]?>;">
										<div class="form-group">
											<input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" placeholder="Nombre de usuario" value="">
											<font style="color:Red"><?php echo $_SESSION["error_nombre_usuario_login"]; ?></font>
											<font style="color:Red"><?php echo $_SESSION["error_nombre_usuario_inexistente"]; ?></font>
										</div>
										<div class="form-group">
											<input type="password" name="clave" id="clave" class="form-control" placeholder="Contraseña">
											<font style="color:Red"><?php echo $_SESSION["error_clave_login"]; ?></font>
											<font style="color:Red"><?php echo $_SESSION["error_clave_incorrecta"]; ?></font>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" name="login-submit" id="login-submit" class="form-control btn btn-register" value="Iniciar sesión">
												</div>
											</div>
										</div>
									</form>
									<form id="register-form" action="validarRegistro.php" method="post" role="form" style="display: <?php echo $_SESSION["registrarActivo"]?>;">
									    <div class="form-group">
											<input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre" value="">
											<font style="color:Red"><?php echo $_SESSION["error_nombre"]; ?></font>
										</div>
										<div class="form-group">
											<input type="text" name="apellido1" id="apellido1" class="form-control" placeholder="Primer apellido" value="">
											<font style="color:Red"><?php echo $_SESSION["error_apellido1"]; ?></font>
										</div>
										<div class="form-group">
											<input type="text" name="apellido2" id="apellido2" class="form-control" placeholder="Segundo apellido" value="">
											<font style="color:Red"><?php echo $_SESSION["error_apellido2"]; ?></font>
										</div>
										<div class="form-group">
											<input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" placeholder="Nombre de usuario" value="">
											<font style="color:Red"><?php echo $_SESSION["error_nombre_usuario"]; ?></font>											
											<font style="color:Red"><?php echo $_SESSION["error_nombre_usuario_repetido"]; ?></font>
										</div>
										<div class="form-group">
											<input type="text" name="correo" id="correo" class="form-control" placeholder="Correo electrónico" value="">
											<font style="color:Red"><?php echo $_SESSION["error_correo"]; ?></font>
										</div>
										<div class="form-group">
											<input type="text" name="num_celular" id="num_celular" class="form-control" placeholder="Número de celular" value="">
											<font style="color:Red"><?php echo $_SESSION["error_num_celular"]; ?></font>
										</div>
										<div class="form-group">
											<input type="text" name="num_telefono" id="num_telefono" class="form-control" placeholder="Número telefónico" value="">
											<font style="color:Red"><?php echo $_SESSION["error_num_telefono"]; ?></font>
										</div>
										<div class="form-group">
											<input type="password" name="clave" id="clave" class="form-control" placeholder="Contraseña">
											<font style="color:Red"><?php echo $_SESSION["error_clave"]; ?></font>
										</div>
										<div class="form-group">
											<input type="password" name="confirmar_clave" id="confirmar_clave" class="form-control" placeholder="Confirmar contraseña">
											<font style="color:Red"><?php echo $_SESSION["error_confirmacion"]; ?></font>
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-sm-6 col-sm-offset-3">
													<input type="submit" class="form-control btn btn-register" value="Registrarme">
												</div>
											</div>
										</div>
									</form>
									<?php
										if (isset($_SESSION["mensajeRegistro"])){
											echo "<script language='javascript'>alert('Se ha registrado exitosamente.');</script>";
											unset($_SESSION["mensajeRegistro"]);
										} 
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>