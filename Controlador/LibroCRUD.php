<?php
require_once('conexion.php');
require_once('../Modelo/libros.php');

	class CLibros{
		// constructor de la clase
		public function __construct(){}

		// Crear
		public function insertL($Libro){
			$db=Db::conectar();
			$insert=$db->prepare('INSERT INTO libros values(:id, :nombre, :autor, :editorial, :categoria, :descripcion, :imagen)');
			$insert->bindValue('id',$Libro->getId());
			$insert->bindValue('nombre',$Libro->getNombre());
			$insert->bindValue('autor',$Libro->getAutor());
			$insert->bindValue('editorial',$Libro->getEditorial());
			$insert->bindValue('categoria', $Libro->getCategoria());
			$insert->bindValue('descripcion',$Libro->getDescripcion());
			$insert->bindValue('imagen',$Libro->getImagen());
			$insert->execute();
		}

		// eliminar
		public function EliminarLib($Libro){
			$db=Db::conectar();
			$eliminar=$db->prepare('DELETE FROM libros WHERE id =:id');
			$eliminar->bindValue('id',$Libro->getId());
			$eliminar->execute();
		}

		// leer
		public function VisLib(){
			$db=Db::conectar();
			$listaLibros=[];
			$select=$db->query('SELECT * FROM libros');
			foreach($select->fetchAll() as $Libro){
				$libros= new Libro();
				$libros->setId($Libro['id']);
				$libros->setNombre($Libro['nombre']);
				$libros->setAutor($Libro['autor']);
				$libros->setEditorial($Libro['editorial']);
				$libros->setCategoria($Libro['categoria']);
				$libros->setDescripcion($Libro['descripcion']);
				$libros->setImagen($Libro['imagen']);
				$listaLibros[]=$libros;
			}
			return $listaLibros;
		}

		
		// Actualizar
		public function ActLib($libro){
			$db=Db::conectar();
			$actualizar=$db->prepare('UPDATE libros SET id=:id, nombre=:nombre, autor=:autor, editorial=:editorial, categoria=:categoria, descripcion=:descripcion, imagen=:imagen WHERE id=:id');
			$actualizar->bindValue('id',$libro->getId());
			$actualizar->bindValue('nombre',$libro->getNombre());
			$actualizar->bindValue('autor',$libro->getAutor());
			$actualizar->bindValue('editorial',$libro->getEditorial());
			$actualizar->bindValue('categoria',$libro->getCategoria());
			$actualizar->bindValue('descripcion',$libro->getDescripcion());
			$actualizar->bindValue('imagen',$libro->getImagen());
			$actualizar->execute();
		}
		// Buscar
		public function BuscarLib($id){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM libros WHERE id=:id');
			$select->bindValue('id',$id);
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
		public function VisLibJSON(){
			$db=Db::conectar();
			$select = $db->prepare('SELECT * FROM  libros');
			$select->execute();
			$result = $select->fetchAll(PDO::FETCH_ASSOC);
			$resp = $this->converter($result);
			return $resp;
		}
		public function converter($array){
			array_walk_recursive($array, function(&$item){
				$item = utf8_encode( $item ); 
			});
			return json_encode( $array );
	  }	
		public function BuscarLibJSON($id){
			$db=Db::conectar();
			$libro=[];
			$select=$db->prepare('SELECT * FROM libros WHERE id=:id');
			$select->bindValue('id',$id);
			$select->execute();
			$result = $select->fetchAll(PDO::FETCH_ASSOC);
            $libros= json_encode($result);
			return ($libro);
		}
	}
?>


