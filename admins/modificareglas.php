<?php
	include_once('../inicio/conexion.php');
	include_once('../inicio/regla.php');
	session_start();
	if(isset($_SESSION["correo"]) && isset($_SESSION["nombre"]) && isset($_SESSION["apellido"]))
	{
		if(isset($_POST["txtKpiRegla"]) && isset($_POST["txtValorRegla"]) && isset($_POST["txtOperadorRegla"]) && isset($_POST["reglas"]))
		{
			if(isset($_POST["txtTextoSi"]) && isset($_POST["txtTextoNo"]))
			{
				if($_POST["reglas"] != 0)
				{
					$idRegla = $_POST["reglas"];
					$kpi = $_POST["txtKpiRegla"];
					$valor = $_POST["txtValorRegla"];
					$operador = "";
					switch($_POST["txtOperadorRegla"])
					{
						case "1":
							$operador = ">";
						break;
						case "2":
							$operador = "<";
						break;
						case "3":
							$operador = ">=";
						break;
						case "4":
							$operador = "<=";
						break;
						default:
							$operador = ">";
						break;
					}
					
					$textoSi = $_POST["txtTextoSi"];
					$textoNo = $_POST["txtTextoNo"];
					$regla = new Regla();
					$regla->setKpi($kpi);
					$regla->setValor($valor);
					$regla->setOperadorLogico($operador);
					$regla->setTextoSi($textoSi);
					$regla->setTextoNo($textoNo);
					$regla->setIdRegla($idRegla);
					
					if($regla->modificaRegla())
					{
						$_SESSION["mensaje"] = "Regla modificada";
					}
					else
					{
						$_SESSION["mensaje"] = "Error al modificar la regla. Intentelo nuevamente";
					}
					header("Location: home.php");
				}
				else
				{
					$_SESSION["mensaje"] = "Debe completar todos los campos";
					header("Location: home.php");
				}
			}
			else if(isset($_POST["txtTextoSuperiorSi"]) && isset($_POST["txtTextoSuperiorNo"]) && isset($_POST["txtTextoInferiorSi"]) && isset($_POST["txtTextoInferiorNo"]) && isset($_POST["txtTextoActionSi"]) && isset($_POST["txtTextoActionNo"]))
			{
				$idRegla = $_POST["reglas"];
				$kpi = $_POST["txtKpiRegla"];
				$valor = $_POST["txtValorRegla"];
				$operador = "";
				switch($_POST["txtOperadorRegla"])
				{
					case "1":
						$operador = ">";
					break;
					case "2":
						$operador = "<";
					break;
					case "3":
						$operador = ">=";
					break;
					case "4":
						$operador = "<=";
					break;
					default:
						$operador = ">";
					break;
				}
				
				$textoSuperiorSi = $_POST["txtTextoSuperiorSi"];
				$textoSuperiorNo = $_POST["txtTextoSuperiorNo"];
				$textoInferiorSi = $_POST["txtTextoInferiorSi"];
				$textoInferiorNo = $_POST["txtTextoInferiorNo"];
				$textoActionSi = $_POST["txtTextoActionSi"];
				$textoActionNo = $_POST["txtTextoActionNo"];
				$regla = new PrimerasReglas();
				$regla->setKpi($kpi);
				$regla->setValor($valor);
				$regla->setOperadorLogico($operador);
				$regla->setTextoSuperiorSi($textoSuperiorSi);
				$regla->setTextoSuperiorNo($textoSuperiorNo);
				$regla->setTextoInferiorSi($textoInferiorSi);
				$regla->setTextoInferiorNo($textoInferiorNo);
				$regla->setTextoActionSi($textoActionSi);
				$regla->setTextoActionNo($textoActionNo);
				$regla->setIdRegla($idRegla);
				
				if($regla->modificaRegla())
				{
					$_SESSION["mensaje"] = "Regla modificada";
				}
				else
				{
					$_SESSION["mensaje"] = "Error al modificar la regla. Intentelo nuevamente";
				}
				header("Location: home.php");
			}
			else
			{
				$_SESSION["mensaje"] = "Debe completar todos los campos2";
				header("Location: home.php");
			}
		}
		else
		{
			$_SESSION["mensaje"] = "Debe completar todos los campos2";
			header("Location: home.php");
		}
	}
	else
	{
		$_SESSION["mensaje"] = "Debe realizar el login primero";
		header("Location: index.php");
	}
?>