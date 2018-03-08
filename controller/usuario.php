<?php
	class Usuario{
		private $id;
		private $nombre;
		private $apellido;
		private $fechaNacimiento;
		private $edad;
		private $cedula;
		private $correo;

		function __construct(){}

		public function getNombre(){
			return $this->nombre;
		}

		public function setNombre($nombre){
			$this->nombre = $nombre;
		}

		public function getApellido(){
			return $this->apellido;
		}

		public function setApellido($apellido){
			$this->apellido = $apellido;
		}

		public function getFechaNacimiento(){
			return $this->fechaNacimiento;
		}

		public function setFechaNacimiento($fechaNacimiento){
			$this->fechaNacimiento = $fechaNacimiento;
		}

		public function getEdad(){
			return $this->edad;
		}

		public function setEdad($edad){
			$this->edad = $edad;
		}

		public function getCedula(){
			return $this->cedula;
		}

		public function setCedula($cedula){
			$this->cedula = $cedula;
		}

		public function getCorreo(){
			return $this->correo;
		}

		public function setCorreo($correo){
			$this->correo = $correo;
		}

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
	}
?>