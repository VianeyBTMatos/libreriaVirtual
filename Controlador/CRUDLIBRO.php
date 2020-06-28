<?php
require_once('../Modelos/libros.php');

	class CrudLibros{
		// constructor de la clase
		public function __construct(){}

		// Crear
		public function insertar($Libro){
			require('db_con.php');
			$insert=$dbh->prepare('INSERT INTO libros values(:id, :nombre, :autor, :editorial, :categoria, :descripcion, :imagen)');
			$insert->bindValue('id',$Libro->getId());
			$insert->bindValue('nombre',$Libro->getNombre());
			$insert->bindValue('autor',$Libro->getAutor());
			$insert->bindValue('editorial',$Libro->getEditorial());
			$insert->bindValue('categoria', $Libro->getCategoria());
			$insert->bindValue('descripcion',$Libro->getDescripcion());
			$insert->bindValue('imagen',$Libro->getImagen());
			$insert->execute();
		}

		// Delate
		public function eliminar($Libro){
			require('db_con.php');
			$eliminar=$dbh->prepare('DELETE FROM libros WHERE id =:id');
			$eliminar->bindValue('id',$Libro->getId());
			$eliminar->execute();
		}

		// Read
		public function mostrar(){
			require('db_con.php');
			$listaLibros=[];
			$select=$dbh->query('SELECT * FROM libros');
			foreach($select->fetchAll() as $Libro){
				$libros= new Libro();
				$libros->setId($Libros['id']);
				$libros->setNombre($Libro['nombre']);
				$libros->setAutor($Libro['autor']);
				$libro->setEditorial($Libro['editorial']);
				$libro->setCategoria($Libro['categoria']);
				$libro->setDescripcion($Libro['descripcion']);
				$libro->setImagen($Libro['imagen']);
				$listaLibros[]=$libros;
			}
			return $listaLibros;
		}

		
		// Updateg
		public function actualizar($libro){
			require('db_con.php');
			$actualizar=$dbh->prepare('UPDATE libros SET id=:id, nombre=:nombre, autor=:autor, editorial=:editorial, categoria=:categoria, descripcion=:descripcion, imagen=:imagen WHERE nombre=:nombre');
			$actualizar->bindValue('id',$libro->getId());
			$actualizar->bindValue('nombre',$libro->getNombre());
			$actualizar->bindValue('autor',$libro->getAutor());
			$actualizar->bindValue('editorial',$libro->getEditorial());
			$actualizar->bindValue('categoria',$libro->getCategoria());
			$actualizar->bindValue('descripcion',$libro->getDescripcion());
			$actualizar->bindValue('imagen',$libro->getImagen());
			$actualizar->execute();
		}
		// Search
		public function obtenerLibro($nombre){
			require('db_con.php');
			// $listaMaterias=[];
			$select=$dbh->prepare('SELECT * FROM libros WHERE nombre=:nombre');
			$select->bindValue('nombre',$nombre);
			$select->execute();
			$libro=$select->fetch();
			$libros= new Libro();
			$libros->setId($libro['id']);
			$libros->setNombre($libro['nombre']);
			$libros->setAutor($libro['autor']);
			$libros->setEditorial($libro['editorial']);
			$libros->setCategoria($libro['categoria']);
			$libros->setDescripcion($libro['descripcion']);
			$libros->setImagen($libro['imagen']);
			return $libros;
		}

		public function mostrarJSON(){
			require('db_con.php');
			//$listaArticulos=[];
			$select = $dbh->prepare('SELECT * FROM  libros');
			$select->execute();
			$result = $select->fetchAll(PDO::FETCH_ASSOC);
            $listaLibros= json_encode($result);
			
			return $listaLibros;
		}
		
		

		public function obtenerLibroJSON($id){
			require('db_con.php');
			$libros=[];
			$select=$dbh->prepare('SELECT * FROM libros WHERE id=:id');
			$select->bindValue('id',$id);
			$select->execute();
			$result = $select->fetchAll(PDO::FETCH_ASSOC);
            $libros= json_encode($result);
			return ($libros);
		}
	}
?>


