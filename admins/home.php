<?php
	include_once('../inicio/regla.php');
	include_once('../inicio/arraylist.php');
	session_start();
	if(isset($_SESSION["correo"]) && isset($_SESSION["nombre"]) && isset($_SESSION["apellido"]))
	{
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/estilo.css">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/funciones.js"></script>

	<title>Audience - Optimizer</title>
	<script type="text/javascript">
		$(document).ready(function(){
			<?php
				if(isset($_SESSION["mensaje"]))
				{
					echo "alert('".$_SESSION["mensaje"]."')";
					unset($_SESSION["mensaje"]);
				}
			?>
		});
	</script>
</head>
<body>
	<div id="todo" class="col-xs-12">
		<div class="container-fluid">
			<section id="top" class="col-lg-12 col-xs-12">
				<div id="logo"></div>
			</section>
			<section id="verde" class="col-xs-12"></section>

			<section id="pasos" class="col-xs-12">
				<div id="cubos" class=""></div>
			</section>

			<section class="col-xs-12 col-lg-12">
				<div id="bannerimage" class="col-lg-10 col-lg-offset-1">
					<p id="texto-principal" class="col-xs-12">Conoce de forma rápida el rendimiento de tus campañas de AdWords</p>
				</div>
			</section>

			<section id="contenido" class="col-xs-12">
				<section id="izquierda-admin" class="col-xs-12 col-md-5 col-md-offset-1 no-padding">
					<div id="formu-izquierda" class="col-xs-12 col-md-11">
						<div id="formu" class="col-xs-12" onsubmit="return validaformregistro()">
							<form action="registraadmin.php" method="post">
								<div id="textoformulario" class="col-xs-12">
									Registrar nuevo administrador
								</div>
								<div class="textochicoformulario col-xs-12">
									Nombre
								</div>
								<div class="col-xs-12">
									<input type="text" id="txtNombre" name="txtNombre" class="input col-xs-12" onkeypress="bordegrisreg(0)">
								</div>
								
								<div class="textochicoformulario col-xs-12">
									Apellido
								</div>
								<div class="col-xs-12">
									<input type="text" id="txtApellido" name="txtApellido" class="input col-xs-12" onkeypress="bordegrisreg(1)">
								</div>
								<div class="textochicoformulario col-xs-12">
									Correo
								</div>
								<div class="col-xs-12">
									<input type="text" id="txtCorreo" name="txtCorreo" class="input col-xs-12" onkeypress="bordegrisreg(2)">
								</div>
								<div class="textochicoformulario col-xs-12">
									Clave (Al menos 8 carácteres)
								</div>
								<div class="col-xs-12">
									<input type="password" id="txtClave" name="txtClave" class="input col-xs-12" onkeypress="bordegrisreg(3)">
								</div>
								<div class="textochicoformulario col-xs-12">
									Repetir clave (Debe coincidir con la anterior)
								</div>
								<div class="col-xs-12">
									<input type="password" id="txtRClave" name="txtRClave" class="input col-xs-12" onkeypress="bordegrisreg(4)">
								</div>
								<div class="col-xs-12">
									<input type="submit" id="boton" name="enviar" value="Registrar Administrador" class="col-xs-12 col-sm-6 col-lg-5 pull-right">
								</div>
							</form>
						</div>
					</div>
				</section><!-- Fin izquierda -->

				<section id="derecha-admin" class="col-xs-12 col-md-5 no-padding">
					<div id="formu-derecha" class="col-xs-12 col-md-11 pull-right">
						<div id="textoformulario" class="col-xs-12">
							Modificar Reglas
						</div>

						<div id="formu2" class="col-xs-12 margen-arriba">
							<?php
								$regla = new Regla();
								$regla->selectReglas();
							?>
						</div>
					</div>
				</section><!-- Fin derecha -->
			</section><!-- Fin contenido -->

			<section id="pie" class="col-xs-12">
				<div id="admins" class="col-xs-2 pull-right">
					<a href="../inicio/cierrasesion.php">Cerrar Sesión</a>
				</div>
			</section>

		</div>
	</div>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>
<?php
}
else
{
	$_SESSION["mensaje"] = "Debe realizar el login primero";
	header("Location: index.php");
}
?>