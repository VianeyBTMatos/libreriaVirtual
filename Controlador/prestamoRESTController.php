<?php
require_once("prestamoRESTHandler.php");

//petición que llega
$metodo =  $_SERVER['REQUEST_METHOD']; 
//verifica que tipo de petición es
switch($metodo) 
{
    case 'GET': //en caso de que sea GET
		$prestamos = "";
		if(isset($_GET["prestamos"]))
		$prestamos = $_GET["prestamos"];
		switch($prestamos)
		{ //dependiendo que valor tenga prestamos se enviara la respuesta que se esta pidiendo desde la url
			case 'todos': //si en este caso es todos este hara lo siguiente
				$CRUDRESTHandler = new CURDRestHandler();//referencia a la clase CURDRestHandler
				$CRUDRESTHandler->getAllPrestamos();//accede a la funcion de de la clase CURDRestHandler llamada getAllPrestamos()
				break;
			
			case "search": //si en este caso es search este hara los siguiente
				$CRUDRESTHandler = new CURDRestHandler(); //referencia a la clase CURDRestHandler
				$CRUDRESTHandler->getPrestamos($_GET["Id_prestamo"]); //accede a la funcion de de la clase CURDRestHandler llamada getPrestamos(), este debe de recibir desde la url un valor con el id del prestamo
				break;
			
			default:
				header("HTTP/1.1 400  Method Not Allowed");
				break;
		}
		break;

	case 'POST':
		$option="";
		if( isset($_GET["option"])){
			$option = $_GET["option"];
			switch($option){
				case 'insert':
					echo("Estoy en el switch INSERT -> ");
					//si lo que resive el post no son vacias entran al if
					if ((empty($_POST["Id_prestamo"]) != true) and 
						(empty($_POST["Domicilio"]) != true) and 
						(empty($_POST["Telefono"]) != true) and 
						(empty($_POST["Fecha_salida"]) != true) and 
						(empty($_POST["Fecha_entrega"]) != true) and 
						(empty($_POST["Id_libro"]) != true) and 
						(empty($_POST["Dni_user"]) != true) ) 
					{
						echo(" Estoy en el IF INSERT -> ");
						$CURDRestHandler = new CURDRestHandler(); //hace referencia a la clase CURDRestHandler
						$CURDRestHandler->InsertPrestamos($_POST["Id_prestamo"],$_POST["Domicilio"],$_POST["Telefono"],
						$_POST["Fecha_salida"],$_POST["Fecha_entrega"],$_POST["Id_libro"],$_POST["Dni_user"]); //le envia a la funcion insertUsuario los valores recividos desde la url
					} else {
						header("HTTP/1.1 400  error en variables");
						echo"Variables vacias o error de ellas";
					}
					break;
				case'insertJSON';
					echo ("Estoy en el insert JSON -> ");
					$CURDRestHandler = new CURDRestHandler(); //hace referencia a la clas RESTHandler
					$CURDRestHandler->InsertPrestamosJSON(); //se dirige a la funcion 
					break;
				case 'update':
					echo("Estoy en el case UPDATE ->");
					//hace referencia a la clase CURDRestHandler
					$CURDRestHandler = new CURDRestHandler();
					$CURDRestHandler->actualizarPrestamos($_POST["Id_prestamo"],$_POST["Domicilio"],$_POST["Telefono"], //se dirige a la funcion 
					$_POST["Fecha_salida"],$_POST["Fecha_entrega"],$_POST["Id_libro"],$_POST["Dni_user"]);
					break;
				case'updateJSON';
					echo ("Estoy en el insert update JSON -> ");
					$CURDRestHandler = new CURDRestHandler();
					$CURDRestHandler->actualizarPrestamosJSON();
					break;
				default:
					header("HTTP/1.1 400  Method Not Allowed");
					echo"No hay peticón en el POST";
					break;
			}
		}
		break;

	case 'DELETE':
		echo ("Estas en el case DELETE -> ");
		$option = "";
		
		if (isset($_GET["option"])){
			echo ("Estas en el if del delete -> ");
			$option = $_GET["option"];
			
			switch($option)
			{
				case'delete':
					$PrestamoRESTHandler = new CURDRestHandler(); //hace referencia a la clase CURDRestHandler
					$PrestamoRESTHandler->eliminarPrestamo($_GET["Id_prestamo"]); //le envia a la funcion insertUsuario los valores recividos desde la url
					break;

				case'deleteJSON':
					echo ("Estas en el case delete JSON -> ");
					
					$PrestamoRESTHandler = new CURDRestHandler(); //hace referencia a la clase CURDRestHandler
					$PrestamoRESTHandler->eliminarPrestamoJSON(); //le envia a la funcion insertUsuario los valores recividos desde la url
					break;

			default:
				header("HTTP/1.1 405  Method Not Allowed");
				echo"Opcion no Encontrada";
				break;
			}
		}else{
			header("HTTP/1.1 405  Method Not Allowed");
			echo "metodo no encontrado";
		}
	break;

	default:
		header("HTTP/1.1 405  Method Not Allowed");
		break;
}
?>