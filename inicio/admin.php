<?php
	include_once('conexion.php');
	class Admin
	{
		private $correo;
		private $nombre;
		private $apellido;
		private $clave;

		public function __construct()
		{

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

		public function setCorreo($correo)
		{
			$this->correo = $correo;
		}

		public function getCorreo()
		{
			return $this->correo;
		}

		public function setClave($clave)
		{
			$this->clave = $clave;
		}

		public function getClave()
		{
			return $this->clave;
		}

		public function validaLogin()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("SELECT nombre, apellido, correo FROM admins WHERE correo='".$this->correo."' AND clave='".$this->clave."'"))
			{
				if(mysqli_num_rows($resultado) > 0)
				{
					while($fila = $resultado->fetch_array())
					{
						session_start();
						$_SESSION["nombre"] = $fila[0];
						$_SESSION["apellido"] = $fila[1];
						$_SESSION["correo"] = $fila[2];
						$this->conexion->closeConnection();
						return true;
					}
				}
				else
				{
					$this->conexion->closeConnection();
					return false;
				}
			}
			else
			{
				$this->conexion->closeConnection();
				return false;
			}
		}

		public function insertaAdmin()
		{
			$this->conexion = Conexion::getInstance();
			$this->conexion->openConnection();
			$var = $this->conexion->useConnection();
			if($resultado = $var->query("INSERT INTO admins(correo, clave, nombre, apellido) VALUES('".$this->correo."','".$this->clave."','".$this->nombre."','".$this->apellido."')") > 0)
			{
				$this->conexion->closeConnection();
				return true;
			}
			$this->conexion->closeConnection();
			return false;
		}
	}
?>