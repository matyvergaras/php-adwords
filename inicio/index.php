<?php
	require_once 'init.php';
	require_once 'consulta.php';
	require_once 'utils.php';

	$nombre = $_POST["txtNombre"];
    $apellido = $_POST["txtApellido"];
    $correo_adwords = $_POST["txtCorreoAdwords"];
    $correo_contacto = $_POST["txtCorreoContacto"];
    $empresa = $_POST["txtEmpresa"];

    session_start();

    $consulta = new Consulta();
    $consulta->setNombre($nombre);
    $consulta->setApellido($apellido);
    if(Utils::validateEmail($correo_adwords))
    	$consulta->setCorreoAdwords($correo_adwords);
    else
    {
    	$_SESSION["mensaje"] = "Ingrese una cuenta de adwords válida";
    	header("Location: ../index.html");
    }

    if(Utils::validateEmail($correo_contacto))
    	$consulta->setCorreoContacto($correo_contacto);
    else
    {
    	$_SESSION["mensaje"] = "Ingrese un correo de contacto válido";
    	header("Location: ../index.html");
    }
    $consulta->setEmpresa($empresa);
    $consulta->insertaConsulta(); 




	$clientId = "851197242710-eddgs40lafgm0mvf9pbf8i7q6jogn8da.apps.googleusercontent.com";
	$access = "PROVIDED_HIDDEN";
	$refresh = "PROVIDED_HIDDEN";
	$redirect_uri = 'http://www.audience.cl/adwords/inicio/obtenercampanas.php';
	 
	$user = new AdWordsUser();
	$user->SetUserAgent("audience.ltda@gmail.com");
	$user->SetDeveloperToken('3QNYmQcux02171LvdXAXHQ');
	$user->setScopes(array('redirect_uri' => 'https://www.googleapis.com/auth/adwords'));
	$user->SetOAuth2Info(array(
	      "client_id" => '851197242710-eddgs40lafgm0mvf9pbf8i7q6jogn8da.apps.googleusercontent.com'
	  ));
	$handler = $user->GetDefaultOAuth2Handler();

	$cred = array(
		"client_id" => $clientId
	);

	$params = array(
	   "client_id" => $clientId,
	   "redirect_uri" => $redirect_uri,
	   "access_type" => 'offline'
	);
	 
	$authUrl = $handler->GetAuthorizationUrl($cred, $redirect_uri, 'offline', $params);
	$authUrl = urldecode(filter_var($authUrl, FILTER_SANITIZE_URL));
	$authUrl .= "&approval_prompt=force";
	//echo $authUrl;
	session_destroy();
	header("Location: $authUrl");
?>