<?php
require_once("LibroHandler.php");
$metodo =  $_SERVER['REQUEST_METHOD']; 
   
switch($metodo) {
    case 'GET':
       $buscar = "";

	  
	  //http://localhost:8080/libreriaVirtual/Controlador/LibroController.php?
	   if(isset($_GET["buscar"]))
		//http://localhost:8080/alumnos/Controladores/LibroController.php?buscar=all
	      $buscar = $_GET["buscar"];
		
        switch($buscar){

			case 'all':
				$CRUDRestHandlerLibro = new CRHLibro();
				$CRUDRestHandlerLibro->getAllLibros();
				break;
			case "specific":
				//referencia a la clase
				$CRUDRestHandlerLibro = new CRHLibro();
				//http://localhost:8080/libreriaVirtual/Controlador/LibroController.php?buscar=specific&Id=Valor
				$CRUDRestHandlerLibro->getLibro($_GET["id"]);
				break;
			default:
			  header("HTTP/1.1 400  Method Not Allowed");
			  echo "Error no se encuentra la petición";
			  break;
			}
		break;
	case 'POST':
		$insert;
		if (isset($_GET["option"])){
			$option = $_GET["option"];
			switch($option){
				case'insert':
					
				if  ((empty($_POST["id"]) != true) and (empty($_POST["nombre"]) != true) and
				(empty($_POST["autor"]) != true) and (empty($_POST["editorial"]) != true) and
				(empty($_POST["categoria"]) != true) and (empty($_POST["descripcion"]) != true) and
				(empty($_POST["imagen"]) != true)){
				
					$CRUDRestHandlerLibro = new CRHLibro();
					
					$CRUDRestHandlerLibro->InsertLib($_POST["id"],$_POST["nombre"],
					$_POST["autor"],$_POST["editorial"],$_POST["categoria"],$_POST["descripcion"],$_POST["imagen"]);
				}else {
						header("HTTP/1.1 400  error en variables");
						echo"Variables vacias o error de ellas";
				}
				break;
				case'LibInsertJson';
				$CRUDRestHandlerLibro = new CRHLibro();
				$CRUDRestHandlerLibro->LibInsertJson();
				break;
				case'update':
					
					$CRUDRestHandlerLibro = new CRHLibro();
					//se dirige a la funcion 
					$CRUDRestHandlerLibro->actLibro($_POST["id"],$_POST["Nombre"],
					$_POST["autor"],$_POST["editorial"],$_POST["categoria"],$_POST["descripcion"],$_POST["imagen"]);
				break;
				case'ActJSON';
				$CRUDRestHandlerLibro = new CRHLibro();
				//se dirige a la funcion 
				$CRUDRestHandlerLibro->ActJSON();
				break;
				default:
				header("HTTP/1.1 400  Method Not Allowed");
				echo"No hay peticón en el POST";
				break;
			}
			
		}
        break;
	case 'DELETE':
		$option = "";
		if (isset($_GET["option"])){
			$option = $_GET["option"];

			switch($option){
			 case'delete':
				
				$CRUDRestHandlerLibro = new CRHLibro();
				//le envia a la funcion insertUsuario los valores recividos desde la url
				$CRUDRestHandlerLibro->ElimLibro($_GET["id"] );
			 break;
			 case'deleteJSON':
				//hace referencia a la clase UsuarioRESTHandler
				$CRUDRestHandlerLibro = new CRHLibro();
				//le envia a la funcion insertUsuario los valores recividos desde la url
				$CRUDRestHandlerLibro->ElimJSON();
			 break;
			default:
				header("HTTP/1.1 405  Method Not Allowed");
				echo"opcion no Encontrada";
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
