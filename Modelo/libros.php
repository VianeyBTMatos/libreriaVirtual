<?php
class Libro{
		private $Id;
		private $Nombre;
        private $Autor;
        private $Editorial;
        private $Categoria;
        private $Descripción;
		private $Imagen;
		
		function __construct(){}

		public function getId(){
		return $this->Id;
		}

		public function setId($Id){
			$this->Id = $Id;
		}

		public function getNombre(){
			return $this->Nombre;
		}

		public function setNombre($Nombre){
			$this->Nombre = $Nombre;
		}
		public function getAutor(){
			return $this->Autor;
		}

		public function setAutor($Autor){
			$this->Autor = $Autor;
		}  
		public function getEditorial(){
			return $this->Editorial;
		}

		public function setEditorial($Editorial){
			$this->Editorial = $Editorial;
        }
        public function getCategoria(){
			return $this->Categoria;
		}

		public function setCategoria($Categoria){
			$this->Categoria = $Categoria;
        }
        public function getDescripcion(){
			return $this->Descripción;
		}

		public function setDescripcion($Descripción){
			$this->Descripción = $Descripción;
        }
        public function getImagen(){
			return $this->Imagen;
		}

		public function setImagen($Imagen){
			$this->Imagen = $Imagen;
		}
		
	}
?>