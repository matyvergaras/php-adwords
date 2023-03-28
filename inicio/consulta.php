<?php
	include_once('conexion.php');
	class Consulta
	{
		private $id;
		private $nombre;
		private $apellido;
		private $correoAdwords;
		private $correoContacto;
		private $empresa;
		private $fechaConsulta;
		
		function __construct()
		{

		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function getId()
		{
			return $this->id;
		}

		public function setNombre($nombre)
		{
			$this->nombre = $nombre;
		}

		public function getNombre()
		{
			return $this->nombre;
		}

		public function setApellido($apellido)
		{
			$this->apellido = $apellido;
		}

		public function getApellido()
		{
			return $this->apellido;
		}

		public function setCorreoAdwords($correoAdwords)
		{
			$this->correoAdwords = $correoAdwords;
		}

		public function getCorreoAdwords()
		{
			return $this->correoAdwords;
		}

		public function setCorreoContacto($correoContacto)
		{
			$this->correoContacto = $correoContacto;
		}

		public function getCorreoContacto()
		{
			return $this->correoContacto;
		}

		public function setEmpresa($empresa)
		{
			$this->empresa = $empresa;
		}

		public function getEmpresa()
		{
			return $this->empresa;
		}

		public function setFechaConsulta($fechaConsulta)
		{
			$this->fechaConsulta = $fechaConsulta;
		}

		public function getFechaConsulta()
		{
			return $this->fechaConsulta;
		}

		public function insertaConsulta()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($var->query("INSERT INTO cuentas(nombre, apellido, correo_adwords, correo_contacto, empresa) VALUES('".$this->nombre."','".$this->apellido."','".$this->correoAdwords."','".$this->correoContacto."','".$this->empresa."')"))
			{
				$this->conexion->closeConnection();
				return true;
			}
			else
			{
				$this->conexion->closeConnection();
				return false;
			}
		}
		
	}
?>