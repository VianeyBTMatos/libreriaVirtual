<?php
require_once('conexion.php');
require_once('../Modelo/pedidos.php');

	class CrudPrestamos{
		// constructor de la clase
        public function __construct(){}
		
		// Leer
		public function mostrar(){
			$db=Db::conectar();
			$select=$db->query('SELECT * FROM prestamos');
			foreach($select->fetchAll() as $prestamo){
				$prestamos= new pedidos();
				$prestamos->setIdPrestamo($prestamo['Id_prestamo']);
				$prestamos->setDomicilio($prestamo['Domicilio']);
				$prestamos->setTelefono($prestamo['Telefono']);
				$prestamos->setFecha_salida($prestamo['Fecha_salida']);
				$prestamos->setFecha_entrega($prestamo['Fecha_entrega']);
				$prestamos->setId_libro($prestamo['Id_libro']);
				$prestamos->setDni_user($prestamo['Dni_user']);
				$listaPrestamos[]=$prestamos;
			}
			return $listaPrestamos;
		}

		// Mostrar Prestamos JSON
        public function mostrarJSON(){
			$db=Db::conectar();
			$select = $db->prepare('SELECT * FROM  prestamos');
			$select->execute();
			$result = $select->fetchAll(PDO::FETCH_ASSOC);
            $listaPrestamos = json_encode($result);
			return $listaPrestamos;
        }
		
		//Buscar prestamo JSON
		public function obtenerPrestamoJSON($Id_prestamo){ //cambiar por busqueda de prestamo mediante id
			$db=Db::conectar();
			$prestamos=[];
			$select=$db->prepare('SELECT * FROM prestamos WHERE Id_prestamo=:Id_prestamo');
			$select->bindValue('Id_prestamo',$Id_prestamo);
			$select->execute();
			$result = $select->fetchAll(PDO::FETCH_ASSOC);
            $prestamos= json_encode($result);
			return ($prestamos);
		}

		// Buscar
		public function obtenerPrestamo($Id_prestamo){ //cambiar por busqueda de prestamo mediante id
			$db=Db::conectar();
			$select=$db->prepare('SELECT * FROM prestamos WHERE Id_prestamo=:Id_prestamo');
			$select->bindValue('Id_prestamo',$Id_prestamo);
			$select->execute();
			$prestamo=$select->fetch();
			$prestamos= new pedidos();
				$prestamos->setIdPrestamo($prestamo['Id_prestamo']);
				$prestamos->setDomicilio($prestamo['Domicilio']);
				$prestamos->setTelefono($prestamo['Telefono']);
				$prestamos->setFecha_salida($prestamo['Fecha_salida']);
				$prestamos->setFecha_entrega($prestamo['Fecha_entrega']);
				$prestamos->setId_libro($prestamo['Id_libro']);
				$prestamos->setDni_user($prestamo['Dni_user']);
			return $prestamos;
		}
		
		// Crear
		public function insertar($Prestamo){
			$db=Db::conectar();
			$insert=$db->prepare('INSERT INTO prestamos values(:Id_prestamo, :Domicilio, :Telefono, :Fecha_salida, :Fecha_entrega, :Id_libro, :Dni_user)');
			$insert->bindValue('Id_prestamo',$Prestamo->getIdPrestamo());
			$insert->bindValue('Domicilio',$Prestamo->getDomicilio());
			$insert->bindValue('Telefono',$Prestamo->getTelefono());
			$insert->bindValue('Fecha_salida',$Prestamo->getFecha_salida());
			$insert->bindValue('Fecha_entrega',$Prestamo->getFecha_entrega());
			$insert->bindValue('Id_libro',$Prestamo->getId_libro());
			$insert->bindValue('Dni_user',$Prestamo->getDni_user());
			$insert->execute();
		}

		// Actualizar
		public function actualizar($Prestamo){
			$db=Db::conectar();
			$actualizar=$db->prepare('UPDATE prestamos SET Domicilio=:Domicilio, Telefono=:Telefono, Fecha_salida=:Fecha_salida, Fecha_entrega=:Fecha_entrega, Id_libro=:Id_libro, Dni_user=:Dni_user WHERE Id_prestamo=:Id_prestamo');
			$actualizar->bindValue('Id_prestamo',$Prestamo->getIdPrestamo());
			$actualizar->bindValue('Domicilio',$Prestamo->getDomicilio());
			$actualizar->bindValue('Telefono',$Prestamo->getTelefono());
			$actualizar->bindValue('Fecha_salida',$Prestamo->getFecha_salida());
			$actualizar->bindValue('Fecha_entrega',$Prestamo->getFecha_entrega());
			$actualizar->bindValue('Id_libro',$Prestamo->getId_libro());
			$actualizar->bindValue('Dni_user',$Prestamo->getDni_user());
			$actualizar->execute();
			echo "operacion realizada";
		}
		
		// Delate
		public function eliminar($Prestamo){
			$db=Db::conectar();
			$eliminar=$db->prepare('DELETE FROM prestamos WHERE Id_prestamo=:Id_prestamo');
			$eliminar->bindValue('Id_prestamo',$Prestamo->getIdPrestamo());
			$eliminar->execute();
			echo "Operación realizada!!";	
		}
	}
?>

