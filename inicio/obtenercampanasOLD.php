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
                    <?php
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
                </section><!-- Fin contenido -->
            </div>
        </div>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    </body>
    </html>

<?php

    function muestraDatos($datos, $user)
    {
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
        $imprimir = '
            <div id="primeros3" class="col-xs-12">
                <div class="centrar col-xs-12 col-md-9">
                    <div id="hexaizquierdo" class="col-sm-12 col-md-4 hexa">
                        <div class="textosup col-xs-12">
                            <p>TEXTOSUPERIOR0</p>
                        </div>
                        DIV0
                            VALORCTR
                        </div>
                        <div class="textoinferior col-xs-12">
                            TEXTOINFERIOR0
                        </div>
                        <div class="textofinal col-xs-12">
                            <a href="#">TEXTOACTION0</a>
                        </div>
                    </div>
                    <div id="hexacentral" class="col-sm-12 col-md-4 hexa">
                        <div class="textosup col-xs-12">
                            <p>TEXTOSUPERIOR1</p>
                        </div>
                        DIV1
                            QUALITY
                        </div>
                        <div class="textoinferior col-xs-12">
                            TEXTOINFERIOR1
                        </div>
                        <div class="textofinal col-xs-12">
                            <a href="#">TEXTOACTION1</a>
                        </div>
                    </div>
                    <div id="hexaderecho" class="col-sm-12 col-md-4 hexa">
                        <div class="textosup col-xs-12">
                            <p>TEXTOSUPERIOR2</p>
                        </div>
                        DIV2
                            BUDGET
                        </div>
                        <div class="textoinferior col-xs-12">
                            TEXTOINFERIOR2
                        </div>
                        <div class="textofinal col-xs-12">
                            <a href="#">TEXTOACTION2</a>
                        </div>
                    </div>
                </div> 
            </div>
        ';
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
                $imprimir = str_replace("TEXTOSUPERIOR".$i, $primeras->get($i)->getTextoSuperiorSi(), $imprimir);
                $imprimir = str_replace("DIV".$i, '<div class="textovalor col-xs-12">', $imprimir);
                $imprimir = str_replace("TEXTOINFERIOR".$i, $primeras->get($i)->getTextoInferiorSi(), $imprimir);
                $imprimir = str_replace("TEXTOACTION".$i, $primeras->get($i)->getTextoActionSi(), $imprimir);
            }
            else
            {
                $imprimir = str_replace("TEXTOSUPERIOR".$i, $primeras->get($i)->getTextoSuperiorNo(), $imprimir);
                $imprimir = str_replace("DIV".$i, '<div class="textovalor col-xs-12 textorojo">', $imprimir);
                $imprimir = str_replace("TEXTOINFERIOR".$i, $primeras->get($i)->getTextoInferiorNo(), $imprimir);
                $imprimir = str_replace("TEXTOACTION".$i, $primeras->get($i)->getTextoActionNo(), $imprimir);
            }
        }
        
        
        $imprimir = str_replace("VALORCTR", $primerosDatosUno[0], $imprimir);
        $imprimir = str_replace("BUDGET", $primerosDatosDos[0], $imprimir);
        $imprimir = str_replace("QUALITY", (round($QualityScore*100)/100), $imprimir);
        $imprimir = str_replace(".", ",", $imprimir);
        $valores = array($quintosDatos, (round($tercerosDatos[2]*100)/100), (round($tercerosDatos[0]*100)/100), (round($tercerosDatos[1]*100)/100), $primerosDatosUno[1], $primerosDatosDos[1], "Keyword Changes");
        
        if(isset($_SESSION["user"]))
            unset($_SESSION["user"]);
        echo $imprimir;
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
    
        ?>  
    </div>
    <div id="cuadroexplicaciones" class="col-xs-12 col-md-10 col-md-offset-1 no-padding-left-right">
        <?php
            for($i=0; $i<$reglas->size(); $i++)
            {
                echo '<div class="rendimientokpi2 col-xs-12 no-padding-left-right">';
                echo '<div class="metrica no-padding-left-right col-xs-3">'.utf8_encode($reglas->get($i)->getKpi()).'</div>';
                if(validaRegla($reglas->get($i)->getOperadorLogico(), $reglas->get($i)->getValor(), $valores[$i]))
                    echo '<div class="valormetrica2 pull-right no-padding-left-right col-xs-9">'.utf8_encode($reglas->get($i)->getTextoSi()).'</div>';
                else
                    echo '<div class="valormetrica2 pull-right no-padding-left-right col-xs-9">'.utf8_encode($reglas->get($i)->getTextoNo()).'</div>';
                echo '</div>';
            }
    
        ?> 
    </div>
 
<?php
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
  
