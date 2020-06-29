<?php
require_once('../Controlador/conexion.php');
class pedidos{
		private $Id_prestamo;
		private $Domicilio;
		private $Telefono;
		private $Fecha_salida;
		private $Fecha_entrega;
		private $Id_libro;
		private $Dni_user;

		function __construct(){}

		public function getIdPrestamo(){
			return $this->Id_prestamo;
		}
		public function setIdPrestamo($Id_prestamo){
			$this->Id_prestamo = $Id_prestamo;
		}

		public function getDomicilio(){
			return $this->Domicilio;
		}
		public function setDomicilio($Domicilio){
			$this->Domicilio = $Domicilio;
		}

		public function getTelefono(){
			return $this->Telefono;
		}
		public function setTelefono($Telefono){
			$this->Telefono = $Telefono;
		}

		public function getFecha_salida(){
			return $this->Fecha_salida;
		}
		public function setFecha_salida($Fecha_salida){
			$this->Fecha_salida = $Fecha_salida;
		}

		public function getFecha_entrega(){
			return $this->Fecha_entrega;
		}
		public function setFecha_entrega($Fecha_entrega){
			$this->Fecha_entrega = $Fecha_entrega;
		}

		public function getId_libro(){
			return $this->Id_libro;
		}
		public function setId_libro($Id_libro){
			$this->Id_libro = $Id_libro;
		}

		public function getDni_user(){
			return $this->Dni_user;
		}
		public function setDni_user($Dni_user){
			$this->Dni_user = $Dni_user;
		}
			
	}
?>