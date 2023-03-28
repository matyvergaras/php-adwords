<?php
	include_once('../inicio/conexion.php');
	include_once('../inicio/admin.php');

	if(isset($_POST["txtCorreo"]) && isset($_POST["txtClave"]))
	{
		$admin = new Admin();
		$admin->setCorreo($_POST["txtCorreo"]);
		$admin->setClave(md5($_POST["txtClave"]));
		if($admin->validaLogin())
			header("Location: home.php");
		else
		{
			session_start();
			$_SESSION["mensaje"] = "El correo o la clave no corresponden";
			header("Location: index.php");
		}
	}
	else
	{
		session_start();
		$_SESSION["mensaje"] = "Debe completar todos los campos";
		header("Location: index.php");
	}
?>