<?php
class usuario{
		private $Dni;
		private $Nombre;
		private $ApellidoP;
		private $ApellidoM;
		private $Telefono;
		private $Direccion;
		
		function __construct(){}

		public function getDni(){
		return $this->Dni;
		}

		public function setDni($Dni){
			$this->Dni = $Dni;
		}

		public function geNombre(){
			return $this->Nombre;
		}

		public function setNombre($Nombre){
			$this->Nombre= $Nombre;
		}
		public function getApellidoPo(){
			return $this->ApellidoP;
		}

		public function setApellidoP($ApellidoP){
			$this->ApellidoP = $ApellidoP;
		}
		public function getApellidoM(){
			return $this->ApellidoM;
		}

		public function setApellidoM($ApellidoM){
			$this->ApellidoM = $ApellidoM;
		}
		public function getTelefono(){
			return $this->Telefono;
		}

		public function setTelefono($Telefono){
			$this->Telefono = $Telefono;
		}

		public function getDireccion(){
			return $this->direccion;
		}

		public function setDireccion($Direccion){
			$this->Direccion = $Direccion;
		}
		
	}
?>