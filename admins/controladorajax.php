<?php
	include_once('../inicio/regla.php');
	include_once('../inicio/arraylist.php');
	session_start();
	if(isset($_SESSION["correo"]) && isset($_SESSION["nombre"]) && isset($_SESSION["apellido"]))
	{
		if(isset($_GET["data"]))
		{
			switch($_GET["data"])
			{
				case "getregla":
					$regla = new Regla();
					$id = substr($_GET["idregla"], 0, 1);
					if(strcmp($id, "1") == 0)
						echo $regla->opcionesReglas($_GET["idregla"]);
					else if(strcmp($_GET["idregla"], "0") == 0)
						echo $regla->selectReglas();
					else
						echo $regla->opcionesPrimerasReglas($_GET["idregla"]);
				break;
			}
		}
		else
		{
			$_SESSION["mensaje"] = "Debe realizar el login primero";
			header("Location: home.php");
		}
	}
	else
	{
		$_SESSION["mensaje"] = "Debe realizar el login primero";
		header("Location: index.php");
	}
?>