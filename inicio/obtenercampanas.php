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
	$_SESSION["logeado"] = "LOGEADO";
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

    function muestraDatos($datos, $user)
    {
    	$resultados = Array();
        $primerosDatosUno = $datos->primerosDatosUno($user);
        $primerosDatosDos = $datos->primerosDatosDos($user);
        $QualityScore = $datos->segundosDatos($user);
        $tercerosDatos = $datos->tercerosDatos($user);
        $cuartosDatos = $datos->cuartosDatos($user);
        $quintosDatos = $datos->quintosDatos($user);

        $regla = new Regla();
        $primera = new PrimerasReglas();
        $reglas = $regla->buscaReglas();
        $primeras = $primera->buscaReglas();

        for($i=0; $i<3; $i++)
        {
            $valor = 0;
            if($i == 0)
                $valor = $primerosDatosUno[0];
            if($i == 1)
                $valor = (round($QualityScore*100)/100);
            if($i == 2)
                $valor = $primerosDatosDos[0];
            
            if(validaRegla($primeras->get($i)->getOperadorLogico(), $primeras->get($i)->getValor(), $valor))
            {
            	//Texto corto bajo gráfico
            	$resultados["grafico".($i+1)][0] = $primeras->get($i)->getTextoSuperiorSi();
            	//Verde para mostrar que se cumple con la métrica
            	$resultados["grafico".($i+1)][1] = "'#4cd9c0'";
            	//Texto largo bajo gráfico
            	$resultados["grafico".($i+1)][2] = $primeras->get($i)->getTextoInferiorSi();
            	//Valor a mostrar dentro del gráfico y valor para dibujar gráfico
            	if($i == 0)
            		$resultados["grafico".($i+1)][3] = $primerosDatosUno[0];
            	if($i == 1)
            		$resultados["grafico".($i+1)][3] = (round($QualityScore*100)/100);
            	if($i == 2)
            		$resultados["grafico".($i+1)][3] = $primerosDatosDos[0];

            	$resultados["grafico".($i+1)][4] = $primeras->get($i)->getValor();
                //$imprimir = str_replace("TEXTOSUPERIOR".$i, $primeras->get($i)->getTextoSuperiorSi(), $imprimir);
                //$imprimir = str_replace("DIV".$i, '<div class="textovalor col-xs-12">', $imprimir);
                //$imprimir = str_replace("TEXTOINFERIOR".$i, $primeras->get($i)->getTextoInferiorSi(), $imprimir);
                //$imprimir = str_replace("TEXTOACTION".$i, $primeras->get($i)->getTextoActionSi(), $imprimir);
            }
            else
            {
            	//Texto corto bajo gráfico
            	$resultados["grafico".($i+1)][0] = $primeras->get($i)->getTextoSuperiorNo();
            	//Verde para mostrar que se cumple con la métrica
            	$resultados["grafico".($i+1)][1] = "'#ff8989'";
            	//Texto largo bajo gráfico
            	$resultados["grafico".($i+1)][2] = $primeras->get($i)->getTextoInferiorNo();
            	//Valor a mostrar dentro del gráfico y valor para dibujar gráfico
            	if($i == 0)
            		$resultados["grafico".($i+1)][3] = $primerosDatosUno[0];
            	if($i == 1)
            		$resultados["grafico".($i+1)][3] = (round($QualityScore*100)/100);
            	if($i == 2)
            		$resultados["grafico".($i+1)][3] = $primerosDatosDos[0];
            	$resultados["grafico".($i+1)][4] = $primeras->get($i)->getValor();
                //$imprimir = str_replace("TEXTOSUPERIOR".$i, $primeras->get($i)->getTextoSuperiorNo(), $imprimir);
                //$imprimir = str_replace("DIV".$i, '<div class="textovalor col-xs-12 textorojo">', $imprimir);
                //$imprimir = str_replace("TEXTOINFERIOR".$i, $primeras->get($i)->getTextoInferiorNo(), $imprimir);
                //$imprimir = str_replace("TEXTOACTION".$i, $primeras->get($i)->getTextoActionNo(), $imprimir);
            }
        }
        
        
        //$imprimir = str_replace("VALORCTR", $primerosDatosUno[0], $imprimir);
        //$imprimir = str_replace("BUDGET", $primerosDatosDos[0], $imprimir);
        //$imprimir = str_replace("QUALITY", (round($QualityScore*100)/100), $imprimir);
        //$imprimir = str_replace(".", ",", $imprimir);
        $valores = array($quintosDatos, (round($tercerosDatos[2]*100)/100), (round($tercerosDatos[0]*100)/100), (round($tercerosDatos[1]*100)/100), $primerosDatosUno[1], $primerosDatosDos[1], 0);
        
        if(isset($_SESSION["user"]))
            unset($_SESSION["user"]);
    /*
?>
    <div id="rendimientocompleto" class="col-xs-12 col-md-10 col-md-offset-1">
        <div id="cuadrorendimiento">
            Rendimiento
        </div>
    </div>
    <div id="cuadrodatos" class="col-xs-12 col-md-10 col-md-offset-1 no-padding-left-right">
        <?php
            for($i=0; $i<$reglas->size(); $i++)
            {
                echo '<div class="rendimientokpi col-xs-12 no-padding-left-right">';
                echo '<div class="metrica no-padding-left-right col-xs-6">'.utf8_encode($reglas->get($i)->getKpi()).'</div>';
                if(validaRegla($reglas->get($i)->getOperadorLogico(), $reglas->get($i)->getValor(), $valores[$i]))
                    echo '<div class="valormetrica-gris pull-right no-padding-left-right col-xs-6">'.$valores[$i].'</div>';
                else
                    echo '<div class="valormetrica-rojo pull-right no-padding-left-right col-xs-6">'.$valores[$i].'</div>';
                echo '</div>';
            }
    */
        
            for($i=0; $i<$reglas->size(); $i++)
            {
            	$resultados["regla".($i+1)][0] = $reglas->get($i)->getOperadorLogico();
            	$resultados["regla".($i+1)][1] = $reglas->get($i)->getValor();
            	$resultados["regla".($i+1)][2] = $valores[$i];
                if(validaRegla($reglas->get($i)->getOperadorLogico(), $reglas->get($i)->getValor(), $valores[$i]))
                {
                	$resultados["regla".($i+1)][3] = utf8_encode($reglas->get($i)->getTextoSi());
                	$resultados["regla".($i+1)][4] = "class='imagen-bien'";
                }
                else
                {
                    $resultados["regla".($i+1)][3] = utf8_encode($reglas->get($i)->getTextoNo());
                	$resultados["regla".($i+1)][4] = "class='imagen-mal'";
                }
            }
    		
    		$_SESSION["resultados"] = $resultados;
    		header("Location: reporte.php");
    }

    function validaRegla($operador, $comparar, $valor)
    {
        $valor = floatval(str_replace("%", "", $valor));
        $comparar = floatval(str_replace("%", "", $comparar));
        
        if((is_float($comparar) || is_int($comparar)) && (is_float($valor) || is_int($valor)))
        {
            if(strcmp($operador, ">") == 0)
            {
                if($valor > $comparar)
                    return true;
                else
                    return false;
            }
            else if(strcmp($operador, "<") == 0)
            {
                if($valor < $comparar)
                    return true;
                else
                    return false;
            }
            else if(strcmp($operador, ">=") == 0)
            {
                if($valor >= $comparar)
                    return true;
                else
                    return false;
            }
            else if(strcmp($operador, "<=") == 0)
            {
                if($valor <= $comparar)
                    return true;
                else
                    return false;
            }
        }
        else
        {
            echo "$comparar o $valor No es int ni float<br />";
        }
    }
?>