<?php
	include_once('conexion.php');
	include_once('arraylist.php');

	class PrimerasReglas{
		private $idRegla;
		private $kpi;
		private $valor;
		private $operadorLogico;
		private $textoSuperiorSi;
		private $textoSuperiorNo;
		private $textoInferiorSi;
		private $textoInferiorNo;
		private $textoActionSi;
		private $textoActionNo;

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

		public function setTextoSuperiorSi($textoSuperiorSi)
		{
			$this->textoSuperiorSi = $textoSuperiorSi;
		}

		public function getTextoSuperiorSi()
		{
			return $this->textoSuperiorSi;
		}

		public function setTextoSuperiorNo($textoSuperiorNo)
		{
			$this->textoSuperiorNo = $textoSuperiorNo;
		}

		public function getTextoSuperiorNo()
		{
			return $this->textoSuperiorNo;
		}

		public function setTextoInferiorSi($textoInferiorSi)
		{
			$this->textoInferiorSi = $textoInferiorSi;
		}

		public function getTextoInferiorSi()
		{
			return $this->textoInferiorSi;
		}

		public function setTextoInferiorNo($textoInferiorNo)
		{
			$this->textoInferiorNo = $textoInferiorNo;
		}

		public function getTextoInferiorNo()
		{
			return $this->textoInferiorNo;
		}

		public function setTextoActionSi($textoActionSi)
		{
			$this->textoActionSi = $textoActionSi;
		}

		public function getTextoActionSi()
		{
			return $this->textoActionSi;
		}

		public function setTextoActionNo($textoActionNo)
		{
			$this->textoActionNo = $textoActionNo;
		}

		public function getTextoActionNo()
		{
			return $this->textoActionNo;
		}

		public function buscaReglas()
		{
			$lista = new ArrayList();
			$conexion = Conexion::getInstance();
			$conexion->openConnection();
			$var = $conexion->useConnection();
			if($resultado = $var->query("SELECT * FROM primerasreglas"))
			{
				while($fila = $resultado->fetch_array())
				{
					$regla = new PrimerasReglas();
					$regla->setIdRegla($fila["id_primera_regla"]);
					$regla->setKpi($fila["kpi"]);
					$regla->setValor($fila["valor"]);
					$regla->setOperadorLogico($fila["operador_logico"]);
					$regla->setTextoSuperiorSi(utf8_encode($fila["texto_sobre_si"]));
					$regla->setTextoSuperiorNo(utf8_encode($fila["texto_sobre_no"]));
					$regla->setTextoInferiorSi(utf8_encode($fila["texto_bajo_si"]));
					$regla->setTextoInferiorNo(utf8_encode($fila["texto_bajo_no"]));
					$regla->setTextoActionSi(utf8_encode($fila["texto_action_si"]));
					$regla->setTextoActionNo(utf8_encode($fila["texto_action_no"]));
					$lista->add($regla);
				}
			}
			$conexion->closeConnection();
			return $lista;
		}

		public function modificaRegla()
		{
			$conexion = Conexion::getInstance();
			$conexion->openConnection();
			$var = $conexion->useConnection();

			if($var->query("UPDATE primerasreglas SET kpi='".$this->getKpi()."', valor='".$this->getValor()."', operador_logico='".$this->getOperadorLogico()."', texto_sobre_si='".utf8_decode($this->getTextoSuperiorSi())."', texto_sobre_no='".utf8_decode($this->getTextoSuperiorNo())."', texto_bajo_si='".utf8_decode($this->getTextoInferiorSi())."', texto_bajo_no='".utf8_decode($this->getTextoInferiorNo())."', texto_action_si='".utf8_decode($this->getTextoActionSi())."', texto_action_no='".utf8_decode($this->getTextoActionNo())."' WHERE id_primera_regla='".$this->getIdRegla()."'") > 0)
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

		public function getReglasOption()
		{
			$lista = "";
			$conexion = Conexion::getInstance();
			$conexion->openConnection();
			$var = $conexion->useConnection();
			if($resultado = $var->query("SELECT * FROM primerasreglas"))
			{
				while($fila = $resultado->fetch_array())
				{
					$lista .= "<option value='".$fila["id_primera_regla"]."'>".utf8_encode($fila["kpi"])."</option>";
				}
			}
			$conexion->closeConnection();
			return $lista;
		}

		public function getReglasOptionSeleccionada($select)
		{
			$lista = "";
			$conexion = Conexion::getInstance();
			$conexion->openConnection();
			$var = $conexion->useConnection();
			if($resultado = $var->query("SELECT * FROM primerasreglas"))
			{
				while($fila = $resultado->fetch_array())
				{
					if($select == $fila["id_primera_regla"])
						$lista .= "<option value='".$fila["id_primera_regla"]."' selected='selected'>".utf8_encode($fila["kpi"])."</option>";
					else
						$lista .= "<option value='".$fila["id_primera_regla"]."'>".utf8_encode($fila["kpi"])."</option>";
				}
			}
			$conexion->closeConnection();
			return $lista;
		}
	}
?>