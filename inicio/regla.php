<?php
	include_once('conexion.php');
	include_once('arraylist.php');
	include_once('primerasreglas.php');
	class Regla
	{
		private $idRegla;
		private $kpi;
		private $valor;
		private $operadorLogico;
		private $textoSi;
		private $textoNo;

		public function __construct()
		{

		}

		public function setIdRegla($idRegla)
		{
			$this->idRegla = $idRegla;
		}

		public function getIdRegla()
		{
			return $this->idRegla;
		}

		public function setKpi($kpi)
		{
			$this->kpi = $kpi;
		}

		public function getKpi()
		{
			return $this->kpi;
		}

		public function setValor($valor)
		{
			$this->valor = $valor;
		}

		public function getValor()
		{
			return $this->valor;
		}

		public function setOperadorLogico($operadorLogico)
		{
			$this->operadorLogico = $operadorLogico;
		}

		public function getOperadorLogico()
		{
			return $this->operadorLogico;
		}

		public function setTextoSi($textoSi)
		{
			$this->textoSi = $textoSi;
		}

		public function getTextoSi()
		{
			return $this->textoSi;
		}

		public function setTextoNo($textoNo)
		{
			$this->textoNo = $textoNo;
		}

		public function getTextoNo()
		{
			return $this->textoNo;
		}

		public function buscaReglas()
		{
			$lista = new ArrayList();
			$conexion = Conexion::getInstance();
			$conexion->openConnection();
			$var = $conexion->useConnection();
			if($resultado = $var->query("SELECT * FROM reglas"))
			{
				while($fila = $resultado->fetch_array())
				{
					$regla = new Regla();
					$regla->setIdRegla($fila["id_regla"]);
					$regla->setKpi($fila["kpi"]);
					$regla->setValor($fila["valor"]);
					$regla->setOperadorLogico($fila["operador_logico"]);
					$regla->setTextoSi($fila["texto_si"]);
					$regla->setTextoNo($fila["texto_no"]);
					$lista->add($regla);
				}
			}
			$conexion->closeConnection();
			return $lista;
		}

		public function selectReglas()
		{
			$primera = new PrimerasReglas();
			$options = $primera->getReglasOption();
			$retorno = '<div id="reglas">';
			$retorno .= '<select name="reglas" id="reglas" class="form-control selects" onchange="obtieneregla()">';
			$retorno .= '<option value="0">Seleccione una regla</option>';
			$retorno .= $options;
			$lista = new ArrayList();
			$lista = $this->buscaReglas();
			for($i=0; $i<$lista->size(); $i++)
			{
				$retorno .= "<option value='".$lista->get($i)->getIdRegla()."'>".utf8_encode($lista->get($i)->getKpi())."</option>";
			}
			$retorno .= '</select>';
			$retorno .= '</div>';
			echo $retorno;
		}

		public function selectReglas2($idRegla)
		{
			$primera = new PrimerasReglas();
			$options = $primera->getReglasOptionSeleccionada($idRegla);
			$retorno = '<div id="reglas">';
			$retorno .= '<select name="reglas" id="reglas" class="form-control selects" onchange="obtieneregla()">';
			$retorno .= '<option value="0">Seleccione una regla</option>';
			$retorno .= $options;
			$lista = new ArrayList();
			$lista = $this->buscaReglas();
			for($i=0; $i<$lista->size(); $i++)
			{
				if($idRegla == $lista->get($i)->getIdRegla())
					$retorno .= "<option value='".$lista->get($i)->getIdRegla()."' selected='selected'>".utf8_encode($lista->get($i)->getKpi())."</option>";
				else
					$retorno .= "<option value='".$lista->get($i)->getIdRegla()."'>".utf8_encode($lista->get($i)->getKpi())."</option>";
			}
			$retorno .= '</select>';
			$retorno .= '</div>';
			return $retorno;
		}

		public function opcionesReglas($idRegla)
		{
			$retorno = "<form action='modificareglas.php' method='post' onsubmit='return validacambioreglas()'>";
			$retorno .= $this->selectReglas2($idRegla);
			$operadores = array(">", "<", ">=", "<=");
			$conexion = Conexion::getInstance();
			$conexion->openConnection();
			$var = $conexion->useConnection();
			
			if($resultado = $var->query("SELECT * FROM reglas WHERE id_regla='".$idRegla."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Nombre</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtKpiRegla' id='txtKpiRegla' class='input ancho-cien' value='".utf8_encode($fila["kpi"])."'></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Valor</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtValorRegla' id='txtValorRegla' class='input ancho-cien' value='".$fila["valor"]."'></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Operador de Comparación</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><select name='txtOperadorRegla' id='txtOperadorRegla' class='form-control selects ancho-cien'>";
					for($i = 0; $i<count($operadores); $i++)
					{
						if(strcmp($operadores[$i],$fila["operador_logico"]) == 0)
							$retorno .= "<option value='".($i+1)."' selected='selected'>".$operadores[$i]."</option>";
						else
							$retorno .= "<option value='".($i+1)."'>".$operadores[$i]."</option>";
					}
					$retorno .="</select></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Texto regla cumplida</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtTextoSi' id='txtTextoSi' class='input ancho-cien' value='".utf8_encode($fila["texto_si"])."'></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Texto regla no cumplida</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtTextoNo' id='txtTextoNo' class='input ancho-cien' value='".utf8_encode($fila["texto_no"])."'></div>";
				}
			}
			$retorno .= "<div class='col-xs-12 no-padding'><input type='submit' id='boton' name='enviar' value='Modificar Regla' class='col-xs-12 col-sm-6 col-lg-5 pull-right'></div>";
			$retorno .= "</form>";
			$conexion->closeConnection();
			return $retorno;
		}

		public function opcionesPrimerasReglas($idRegla)
		{
			$retorno = "<form action='modificareglas.php' method='post' onsubmit='return validacambioprimerasreglas()'>";
			$retorno .= $this->selectReglas2($idRegla);
			$operadores = array(">", "<", ">=", "<=");
			$conexion = Conexion::getInstance();
			$conexion->openConnection();
			$var = $conexion->useConnection();
			
			if($resultado = $var->query("SELECT * FROM primerasreglas WHERE id_primera_regla='".$idRegla."'"))
			{
				while($fila = $resultado->fetch_array())
				{
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Nombre</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtKpiRegla' id='txtKpiRegla' class='input ancho-cien' value='".utf8_encode($fila["kpi"])."'></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Valor</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtValorRegla' id='txtValorRegla' class='input ancho-cien' value='".$fila["valor"]."'></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Operador de Comparación</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><select name='txtOperadorRegla' id='txtOperadorRegla' class='form-control selects ancho-cien'>";
					for($i = 0; $i<count($operadores); $i++)
					{
						if(strcmp($operadores[$i],$fila["operador_logico"]) == 0)
							$retorno .= "<option value='".($i+1)."' selected='selected'>".$operadores[$i]."</option>";
						else
							$retorno .= "<option value='".($i+1)."'>".$operadores[$i]."</option>";
					}
					$retorno .="</select></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Texto superior regla cumplida</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtTextoSuperiorSi' id='txtTextoSuperiorSi' class='input ancho-cien' value='".utf8_encode($fila["texto_sobre_si"])."'></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Texto superior regla no cumplida</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtTextoSuperiorNo' id='txtTextoSuperiorNo' class='input ancho-cien' value='".utf8_encode($fila["texto_sobre_no"])."'></div>";

					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Texto inferior regla cumplida</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtTextoInferiorSi' id='txtTextoInferiorSi' class='input ancho-cien' value='".utf8_encode($fila["texto_bajo_si"])."'></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Texto inferior regla no cumplida</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtTextoInferiorNo' id='txtTextoInferiorNo' class='input ancho-cien' value='".utf8_encode($fila["texto_bajo_no"])."'></div>";

					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Texto call to action regla cumplida</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtTextoActionSi' id='txtTextoActionSi' class='input ancho-cien' value='".utf8_encode($fila["texto_action_si"])."'></div>";
					$retorno .= "<div class='textochicoformulario col-xs-12 no-padding'>Texto call to action regla no cumplida</div>";
					$retorno .= "<div class='col-xs-12 no-padding'><input type='text' name='txtTextoActionNo' id='txtTextoActionNo' class='input ancho-cien' value='".utf8_encode($fila["texto_action_no"])."'></div>";
				}
			}
			$retorno .= "<div class='col-xs-12 no-padding'><input type='submit' id='boton' name='enviar' value='Modificar Regla' class='col-xs-12 col-sm-6 col-lg-5 pull-right'></div>";
			$retorno .= "</form>";
			$conexion->closeConnection();
			return $retorno;
		}

		public function modificaRegla()
		{
			$conexion = Conexion::getInstance();
			$conexion->openConnection();
			$var = $conexion->useConnection();

			if($var->query("UPDATE reglas SET kpi='".$this->getKpi()."', valor='".$this->getValor()."', operador_logico='".$this->getOperadorLogico()."', texto_si='".utf8_decode($this->getTextoSi())."', texto_no='".utf8_decode($this->getTextoNo())."' WHERE id_regla='".$this->getIdRegla()."'") > 0)
			{
				$conexion->closeConnection();
				return true;
			}
			else
			{
				$conexion->closeConnection();
				return false;
			}
		}
	}
?>