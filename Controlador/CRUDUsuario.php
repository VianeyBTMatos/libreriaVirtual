<?php
// incluye la clase Db
require_once('conexion.php');
require_once('../Modelo/usuario.php');

	class CRUDUsuario{
		// Crear
		public function insertar($usuario){
			$db=Db::conectar();
			$insert=$db->prepare('INSERT INTO usuarios values(:Dni, :Nombre, :ApellidoP, :ApellidoM, :Telefono, :Direccion)');
			$insert->bindValue('Dni',$usuario->getDni());
			$insert->bindValue('Nombre',$usuario->getNombre());
			$insert->bindValue('ApellidoP',$usuario->getApellidoP());
			$insert->bindValue('ApellidoM',$usuario->getApellidoM());
			$insert->bindValue('Telefono',$usuario->getTelefono());
			$insert->bindValue('Direccion',$usuario->getDireccion());
			$insert->execute();
		}

		// Delate
		public function eliminar($usuario){
			$db=Db::conectar();
			$eliminar=$db->prepare('DELETE FROM usuarios WHERE Dni=:Dni');
			$eliminar->bindValue('Dni',$usuario->getDni());
			$eliminar->execute();
		}

		// Read
		public function mostrar(){
			$db=Db::conectar();
			$listaMaterias=[];
			$select=$db->query('SELECT * FROM usuarios');
			foreach($select->fetchAll() as $usuario){
				$usuarios = new usuario();
				$usuarios->setDni($usuario['Dni']);
				$usuarios->setNombre($usuario['Nombre']);
				$usuarios->setApellidoP($usuario['ApellidoP']);
				$usuarios->setApellidoM($usuario['ApellidoM']);
				$usuarios->setTelefono($usuario['Telefono']);
				$usuarios->setDireccion($usuario['Direccion']);
				$listaUsuarios[]=$usuarios;
			}
			return $listaUsuarios;
		}

		
		// Updateg
		public function actualizar($usuario){
			$db=Db::conectar();
			$actualizar=$db->prepare('UPDATE usuarios SET Nombre=:Nombre, ApellidoP=:ApellidoP, ApellidoM=:ApellidoM, Telefono=:Telefono, Direccion=:Direccion WHERE Dni=:Dni');
			$actualizar->bindValue('Dni',$usuario->getDni());
			$actualizar->bindValue('Nombre',$usuario->getNombre());
			$actualizar->bindValue('ApellidoP',$usuario->getApellidoP());
			$actualizar->bindValue('ApellidoM',$usuario->getApellidoM());
			$actualizar->bindValue('Telefono',$usuario->getTelefono());
			$actualizar->bindValue('Direccion',$usuario->getDireccion());
			$actualizar->execute();
			echo "operacion realizada";
			
			
		}
		// Search
		public function obtenerUsuario($Dni){
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM usuarios WHERE Dni=:Dni');
			$select->bindValue('Dni',$Dni);
			$select->execute();
			$usuario=$select->fetch();
			$usuarios = new usuario();
			$usuarios->setDni($usuario['Dni']);
			$usuarios->setNombre($usuario['Nombre']);
			$usuarios->setApellidoP($usuario['ApellidoP']);
			$usuarios->setApellidoM($usuario['ApellidoM']);
			$usuarios->setTelefono($usuario['Telefono']);
			$usuarios->setDireccion($usuario['Direccion']);
			return $usuarios;
		}

		public function mostrarJSON(){		
			$db=Db::conectar();
			$select = $db->prepare('SELECT * FROM usuarios');
			$select->execute();
			$result = $select->fetchAll(PDO::FETCH_ASSOC);
			$listaUsuarios = json_encode($result);
			return ($listaUsuarios);
		}
		
		

		public function obtenerUsuarioJSON($Dni){
			$db=Db::conectar();
			$usuario=[];
			$select=$db->prepare('SELECT * FROM usuarios WHERE Dni=:Dni');
			$select->bindValue('Dni',$Dni);
			$select->execute();
			$result = $select->fetchAll(PDO::FETCH_ASSOC);
            $usuario= json_encode($result);
			return ($usuario);
		}
	}
?>




