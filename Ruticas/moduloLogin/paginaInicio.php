<?php
	session_start();	
	unset($_SESSION["mensajeRegistro"]);
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
		<?php
			if($_SESSION['nuevo'] == 1){
				echo "<script>$(window).on('load',function(){
					  $('#cambiarPass').modal('show');
				      });</script>";
			}
		?>
	</head>
	<body>
		<div class="container">
	    	<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="panel panel-login">
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-12">
									<a href="#" class="active" id="login-form-link">Usuario conectado</a>
								</div>
							</div>
							<hr>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12" align="center">									
									<img src="images/online.gif" width="60%">
									<p>
									<?php
										if (!isset($_SESSION["nombre_usuario"])){
											header("location:index.php");
										}
										echo "<img src='images/vineta.png' width='20' height='20'><b>".$_SESSION["nombre_usuario"]."</b><br>";										
									?>
									</p><br>
									<a type="button" href="index.php" class="form-control btn btn-register">Cerrar sesión</a><br><br>
									<button class="form-control btn btn-register" data-toggle="modal" data-target="#cambiarPass">Cambiar contraseña</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div id="cambiarPass" class="modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Cambiar Contraseña</h4>
						<button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#editar" aria-hidden="true">×</button>
					</div>
					<div class="modal-body text-center">
						<div class="col-md-12 col-sm-12 no-">
							<form action="validarCambioClave.php" method="post" id="cambiarpassword" class="log-frm" name="userRegisterFrm">
								<label>Contraseña actual</label>
								<input type="password" placeholder="Contraseña actual" name="clave_actual" id="clave_actual" class="form-control">
								<font style="color:Red"><?php echo $_SESSION["error_clave_actual"]; ?></font><br><br>
								<label>Nueva contraseña</label>
								<input type="password" placeholder="Nueva contraseña" name="nueva_clave" id="nueva_clave" class="form-control">
								<font style="color:Red"><?php echo $_SESSION["error_nueva_clave"]; ?></font><br><br>
								<label>Confirmar Nueva Contraseña</label>
								<input type="password" placeholder="Confirmar nueva contraseña" name="confirmar_clave" id="confirmar_clave" class="form-control">
								<font style="color:Red"><?php echo $_SESSION["error_confirmacion"]; ?></font><br><br>
								<input type="submit" name="userRegBtn" class="form-control btn btn-register" value="Cambiar">
							</form>
						</div>
						<div class="clearfix"></div>
						<?php
							if (isset($_SESSION["mensaje"])){								
								echo "<script language='javascript'>alert('Se ha cambiado la clave exitosamente.');</script>";
								unset($_SESSION["mensaje"]);
							} 
						?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>