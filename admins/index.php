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
		$(document).ready(function(){});
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

			<section id="contenido" class="col-xs-12">
				<section id="centro-login" class="col-xs-12 col-md-4 col-md-offset-4">
					<div id="formu-login" class="col-xs-12" onsubmit="return validaform()">
						<form action="validalogin.php" method="post">
							<div id="textoformulario" class="col-xs-12">
								Administradores
							</div>
							<div class="textochicoformulario col-xs-12">
								Correo
							</div>
							<div class="col-xs-12">
								<input type="text" id="txtCorreo" name="txtCorreo" class="input col-xs-12" onkeypress="bordegris(0)">
							</div>
							
							<div class="textochicoformulario col-xs-12">
								Clave
							</div>
							<div class="col-xs-12">
								<input type="password" id="txtClave" name="txtClave" class="input col-xs-12" onkeypress="bordegris(1)">
							</div>
							<div class="col-xs-12">
								<input type="submit" id="boton" name="enviar" value="Entrar" class="col-xs-3 pull-right">
							</div>
						</form>
					</div>
				</section><!-- Fin derecha -->
			</section><!-- Fin contenido -->

			<section id="pie" class="col-xs-12 col-md-4 col-md-offset-4">
				<div id="admins" class="col-xs-1 pull-right">
					<a href="../">Volver</a>
				</div>
			</section>

		</div>
	</div>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>