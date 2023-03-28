<?php

    require_once 'init.php';
    require_once 'ReportUtils.php';
    require_once 'SimpleOAuth2Handler.php';
    require_once 'traedatos.php';
    require_once 'AdWordsUser.php';
    require_once 'regla.php';
    require_once 'arraylist.php';
    require_once 'primerasreglas.php';
    session_start();

    $userId = "";
    if(isset($_POST["clientid"]))
        $userId = $_POST["clientid"];

    if(!isset($_SESSION["user"]))
    {
        $data = $_GET["code"];
        

        $datos = new Traedatos();
        $datos->creaUsuario($data);
        $user = $datos->getUser();
        if($datos->esMcc($user) == "true")
        {
            $_SESSION["user"] = $user;
            echo $datos->muestraCuentas($user);
        }
        else
        {
            muestraDatos($datos, $user);
        }
    }
    else
    {
        $datos = new Traedatos();
        $datos->setUser($_SESSION["user"]);
        $datos->creaUsuarioUserId($userId);
        $user = $datos->getUser();
        if($datos->esMcc($user) == "true")
        {
            $_SESSION["user"] = $user;
            echo $datos->muestraCuentas($user);
        }
        else
        {
            muestraDatos($datos, $user);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Audience - Optimizer</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/estilos2.css">
	<link rel="stylesheet" media="screen and (min-width: 992px)" href="../css/estilos2.css" />
	<link rel="stylesheet" media="screen and (max-width: 991px)" href="../css/estilos2-xs-sm.css" />
	<link rel="stylesheet" type="text/css" href="../css/fixers.css">
	<link rel="icon" type="image/x-icon" href="../img/logo.ico">
	<link rel="shortcut icon" type="image/x-icon" href="../img/logo.ico">
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/funciones.js"></script>
	<script type="text/javascript" src="../js/Chart.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			generaGrafico1();
			generaGrafico2();
			generaGrafico3("Gris", "#4cd9c0", 82, 18);
			//alert("El ancho de tu pantalla es: " + $(window).width());
		});
	</script>
</head>

<body>
	<div id="todo">
	<div class="container-fluid no-padding">

			<!--BARRA DE MENU-->
			<div id="barra-menu" class="col-xs-12 no-padding">
				<div class="col-xs-12 col-md-10 col-md-offset-1 col-lg-6 col-lg-offset-3">
					<div id="logo-optimizer"></div>
					<div id="texto-quieres-optimizar">
						<a href="http://www.audience.cl" target="_blank">¿Quieres mejorar el performance de tus campañas?</a>
					</div>
				</div>
			</div>
			<!--Fin BARRA-MENU-->

			<!--Barra para arreglar el box-shadow que no se ve-->
			<div id="barra-gris" class="col-xs-12 col-md-12 no-padding"></div>

			<!--GRAFICOS RESULTADOS-->
			<div id="graficos" class="col-md-12 no-padding">
				<div id="texto-resumen">
					Este es el resumen sobre tus campañas de Google Adwords
				</div>

				<div id="circulitos" class="col-xs-6 col-xs-offset-3 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 no-padding">
					<div id="circulo1" class="col-xs-12 col-md-3 col-md-offset-2 no-padding">
						<canvas id="circulo-ejemplo-1" class="circulo-ejemplo" height="200", width="200"></canvas>
						<div class="label-porcentaje">
							<div class="texo-superior-circulo">CTR SEARCH</div><br />
							<div class="texto-porcentaje-inferior">50%</div>
						</div>
						<div class="texto-bajo-circulo-ejemplo">
							Puedes mejorar tu CTR
						</div>

						<div class="text-como-mejorar">
							Necesitas mejorar la calidad de tus palabras y anuncios
						</div>

						<button type="button" class="btn btn-default btn-lg botones-bajo-circulos">Mejora tu CTR</button>
					</div>
					<div id="circulo2" class="col-xs-12 col-md-3 no-padding">
						<canvas id="circulo-ejemplo-2" class="circulo-ejemplo" height="200", width="200"></canvas>
						<div class="label-porcentaje">
							<div class="texo-superior-circulo">NIVEL DE CALIDAD</div><br />
							<div class="texto-porcentaje-inferior">50%</div>
						</div>
						<div class="texto-bajo-circulo-ejemplo">
							Tienes un nivel de calidad bajo
						</div>
						<div class="text-como-mejorar">
							Optimiza tus keywords y se más relevante según como te esten buscando
						</div>
						<button type="button" class="btn btn-default btn-lg botones-bajo-circulos">Aumenta tu nivel de calidad</button>
					</div>
					<div id="circulo3" class="col-xs-12 col-md-4 no-padding">
						<canvas id="circulo-ejemplo-3" class="circulo-ejemplo" height="200", width="200"></canvas>
						<div id="label-porcentaje3" class="label-porcentaje">
							<div class="texo-superior-circulo">IMP. LOST BUDGET</div><br />
							<div class="texto-porcentaje-inferior">50%</div>
						</div>
						<div class="texto-bajo-circulo-ejemplo">
							Tienes un nivel de calidad bajo
						</div>
						<div class="text-como-mejorar">
							Tu presupuesto está cubriendo casi todas las búsquedas de tus usuarios
						</div>

						<button type="button" class="btn btn-default btn-lg botones-bajo-circulos">Otras razones de perdida</button>
					</div>
				</div>
			</div>
			<!--Fin GRAFICOS-->

			<!--DIV para las explicaciones de los resultados-->
			<div id="explicaciones" class="col-xs-12 no-padding">
				<div class="col-xs-12 col-md-10 col-md-offset-1 no-padding">
					<div id="tu-reporte" class="col-xs-12 col-md-8 col-md-offset-2 no-padding">
						Tu reporte personalizado
					</div>

					<div onclick="activaExplicacion(1)" id="explicacion1" class="explicacion col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 no-padding active">
						<div class="fila" class="col-xs-12 no-padding">
							<div id="imagen1" class="imagen-bien"></div>
							<div class="titulo-explicacion">
								Keywords negativas
							</div>
							<div class="numero">
								20
							</div>
						</div>
						<div id="text-detalle-explicacion1" class="fila2 col-xs-11 col-md-11 col-xs-offset-1 no-padding">
							Tienes un volumen desebale de keywords negativas, debes incorporar todas las necesarias para no aparecer en búsquedas ineficientes.
						</div>
					</div>
					<div onclick="activaExplicacion(2)" id="explicacion2" class="explicacion col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 no-padding">
						<div class="fila" class="col-xs-12">
							<div id="imagen1" class="imagen-bien"></div>
							<div class="titulo-explicacion">
								Porcentaje de concordancia exacta
							</div>
							<div class="numero">
								20
							</div>
							<div id="text-detalle-explicacion2" class="fila2 col-xs-11 col-xs-offset-1" style="display: none">
								Tienes un volumen desebale de keywords negativas, debes incorporar todas las necesarias para no aparecer en búsquedas ineficientes.
							</div>
						</div>
					</div>
					<div onclick="activaExplicacion(3)" id="explicacion3" class="explicacion col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 no-padding">
						<div class="fila" class="col-xs-12">
							<div id="imagen1" class="imagen-mal"></div>
							<div class="titulo-explicacion">
								Porcentaje de concordancia frase
							</div>
							<div class="numero">
								20
							</div>
							<div id="text-detalle-explicacion3" class="fila2 col-xs-11 col-xs-offset-1" style="display: none">
								Tienes un volumen desebale de keywords negativas, debes incorporar todas las necesarias para no aparecer en búsquedas ineficientes.
							</div>
						</div>
					</div>
					<div onclick="activaExplicacion(4)" id="explicacion4" class="explicacion col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 no-padding">
						<div class="fila" class="col-xs-12">
							<div id="imagen1" class="imagen-bien"></div>
							<div class="titulo-explicacion">
								Porcentaje de concordancia amplia
							</div>
							<div class="numero">
								20
							</div>
							<div id="text-detalle-explicacion4" class="fila2 col-xs-11 col-xs-offset-1" style="display: none">
								Tienes un volumen desebale de keywords negativas, debes incorporar todas las necesarias para no aparecer en búsquedas ineficientes.
							</div>
						</div>
					</div>
					<div onclick="activaExplicacion(5)" id="explicacion5" class="explicacion col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 no-padding">
						<div class="fila" class="col-xs-12">
							<div id="imagen1" class="imagen-bien"></div>
							<div class="titulo-explicacion">
								Posición promedio
							</div>
							<div class="numero">
								20
							</div>
							<div id="text-detalle-explicacion5" class="fila2 col-xs-11 col-xs-offset-1" style="display: none">
								Tienes un volumen desebale de keywords negativas, debes incorporar todas las necesarias para no aparecer en búsquedas ineficientes.
							</div>
						</div>
					</div>
					<div onclick="activaExplicacion(6)" id="explicacion6" class="explicacion col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 no-padding">
						<div class="fila" class="col-xs-12">
							<div id="imagen1" class="imagen-mal"></div>
							<div class="titulo-explicacion">
								Search impression share
							</div>
							<div class="numero">
								20
							</div>
							<div id="text-detalle-explicacion6" class="fila2 col-xs-11 col-xs-offset-1" style="display: none">
								Tienes un volumen desebale de keywords negativas, debes incorporar todas las necesarias para no aparecer en búsquedas ineficientes.
							</div>
						</div>
					</div>
					<div onclick="activaExplicacion(7)" id="explicacion7" class="explicacion col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 no-padding">
						<div class="fila" class="col-xs-12">
							<div id="imagen1" class="imagen-bien"></div>
							<div class="titulo-explicacion">
								Keyword changes
							</div>
							<div class="numero">
								20
							</div>
							<div id="text-detalle-explicacion7" class="fila2 col-xs-11 col-xs-offset-1" style="display: none">
								Tienes un volumen desebale de keywords negativas, debes incorporar todas las necesarias para no aparecer en búsquedas ineficientes.
							</div>
						</div>
					</div>

					<div id="barra-botones" class="col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 no-padding">
						<button type="button" id="boton-pdf" class="btn btn-default btn-lg col-xs-4 col-md-3 borde-2px-gris" style="float: left;">
								Descargar PDF
						</button>
						<div class="col-xs-4 col-md-5 col-md-offset-0 no-padding">
							<input type="text" name="txtEnviarCorreo" id="input-caja-correo" class="col-xs-10 col-md-12">
						</div>
						<button type="button" id="boton-correo" class="btn btn-default btn-lg col-xs-4 col-md-3 pull-right borde-2px-gris" style="float: left;">
							Enviar a correo
						</button>
						<button type="button" id="btn-quieres-mejorar" name="btn-quieres-mejorar" class="btn btn-warning btn-lg col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3">
							¿Quieres mejorar tus campañas?
						</button>
					</div>
				</div>

			</div>
			<!--Fin del DIV para exlicaciones-->


			<!--Este es el Footer-->
			<div id="footer" class="col-xs-12 no-padding">
				<div id="izquierda" class="col-xs-12 col-md-3 col-md-offset-1 col-lg-3 col-lg-offset-1 no-padding">
					<div id="logo" class="col-md-10 col-md-offset-1 col-lg-12 centradoY"></div>
				</div>


				<div id="centro" class=" col-xs-12 col-md-5 col-lg-4 no-padding">
					<div id="opciones" class="col-md-12 col-lg-12 no-padding centradoY">
						<div class="textos col-md-3 col-lg-3 col-lg-offset-1 no-padding">
							Obtener mi reporte
						</div>
						<div class="textos col-md-4 col-lg-3 no-padding">
							Terminos y condiciones
						</div>
						<div class="textos col-md-3 col-lg-2 no-padding">
							Contactanos
						</div>
						<div id="contacto" class="col-md-10 no-padding">
							Audience © 2016 - www.audience.cl - Santa Beatriz 100, Oficina 503 - Providencia &nbsp;+56 (2) 3224 6444 / +56 (2) 3224 6445
						</div>
					</div>
				</div>


				<div id="derecha" class="col-xs-12 col-md-3 col-lg-3 no-padding">
					<div id="botones" class="col-md-12 no-padding">
						<div id="facebook" class="col-md-1 col-md-offset-1"></div>
						<div id="youtube" class="col-md-1 col-md-offset-1"></div>
						<div id="linkedin" class="col-md-1 col-md-offset-1"></div>
					</div>
				</div>
			</div><!--Fin del FOOTER-->

		</div><!--Fin  CONTAINER-FLUID-->
	</div><!--Fin TODO-->


	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
</body>
</html>