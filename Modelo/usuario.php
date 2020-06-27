<?php
class usuario{
		private $Dni;
		private $Nombre;
		private $ApellidoP;
		private $ApellidoM;
		private $Telefono;
		private $Direccion;
	
		public function getDni(){
		return $this->Dni;
		}

		public function setDni($Dni){
			$this->Dni = $Dni;
		}

		public function getNombre(){
			return $this->Nombre;
		}

		public function setNombre($Nombre){
			$this->Nombre= $Nombre;
		}
		public function getApellidoP(){
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
			return $this->Direccion;
		}

		public function setDireccion($Direccion){
			$this->Direccion = $Direccion;
		}
		
	}
?>