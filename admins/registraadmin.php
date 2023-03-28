<?php
	include_once('../inicio/admin.php');

	session_start();
	if(isset($_SESSION["correo"]) && isset($_SESSION["nombre"]) && isset($_SESSION["apellido"]))
	{
		$admin = new Admin();
		$admin->setCorreo($_POST["txtCorreo"]);
		$admin->setClave(md5($_POST["txtClave"]));
		$admin->setNombre($_POST["txtNombre"]);
		$admin->setApellido($_POST["txtApellido"]);
		if($admin->insertaAdmin())
			$_SESSION["mensaje"] = "Administrador registrado";
		else
			$_SESSION["mensaje"] = "Error al registrar al administrador, intentelo nuevamente";
		header("Location: home.php");
	}
	else
	{
		$_SESSION["mensaje"] = "Debe realizar el login primero";
		header("Location: index.php");
	}
?>