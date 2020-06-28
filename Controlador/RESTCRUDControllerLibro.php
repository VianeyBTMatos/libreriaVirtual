<?php
require_once("CRUDRestHandlerLibro.php");

//petición que llega
$metodo =  $_SERVER['REQUEST_METHOD']; 
   
//verifica que tipo de petición es
switch($metodo) {
  //en caso de que sea GET
    case 'GET':

       $search = "";

	  //verificar lo que se realizara 
	  //el valor que la url trae despues de referenciar a RESTUsuarioController.php? en este caso es search
	  //http://localhost:8080/libreriaVirtual/Controlador/RESTUsuarioController.php?
	   if(isset($_GET["search"]))
		//en search se enviara un valor que se obtendrá con el get
		//http://localhost:8080/alumnos/Controladores/RESTUsuarioController.php?search=all
	      $search = $_GET["search"];
		//dependiendo que valor tenda search se enviara la respuesta que se esta pidiendo desde la url
        switch($search){
		//si en este caso es todos este hara los iguiente
			case 'all':
			 	//referencia a la clase UsuarioRESTHandler
				$CRUDRestHandlerLibro = new CRUDRestHandlerLibro();
				//accede a la funcion de de la clase UsuarioRESTHandler llamada getAllUsuarios()
				$CRUDRestHandlerLibro->getAllLibros();
				break;
		//si en este caso es uno este hara los iguiente
			case "specific":
				//referencia a la clase UsuarioRESTHandler
				$CRUDRestHandlerLibro = new CRUDRestHandlerLibro();
				//accede a la funcion de de la clase UsuarioRESTHandler llamada getUsuario()
				//este debe de recibir desde la url un valor con el nombre de Dni
				//http://localhost:8080/libreriaVirtual/Controlador/RESTUsuarioController.php?search=specific&Dni=Valor
				$CRUDRestHandlerLibro->getLibros($_GET["id"]);
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
					//si lo que resive el post en las variables no son vacias en tran al if
				if  ((empty($_POST["id"]) != true) and (empty($_POST["nombre"]) != true) and
				(empty($_POST["autor"]) != true) and (empty($_POST["editorial"]) != true) and
				(empty($_POST["categoria"]) != true) and (empty($_POST["descripcion"]) != true) and
				(empty($_POST["imagen"]) != true)){
					//hace referencia a la clase UsuarioRESTHandler
					$CRUDRestHandlerLibro = new CRUDRestHandlerLibro();
					//le envia a la funcion insertUsuario los valores recividos desde la url
					$CRUDRestHandlerLibro->InsertLibro($_POST["id"],$_POST["Nombre"],
					$_POST["autor"],$_POST["editorial"],$_POST["categoria"],$_POST["descripcion"],$_POST["imagen"]);
				}else {
						header("HTTP/1.1 400  error en variables");
						echo"Variables vacias o error de ellas";
				}
				break;
				case'insertJSON';
				//hace referencia a la clase UsuarioRESTHandler
				$CRUDRestHandlerLibro = new CRUDRestHandlerLibro();
				//se dirige a la funcion 
				$CRUDRestHandlerLibro->insertJson();
				break;
				case'update':
					//hace referencia a la clase UsuarioRESTHandler
					$CRUDRestHandlerLibro = new CRUDRestHandlerLibro();
					//se dirige a la funcion 
					$CRUDRestHandlerLibro->actualizarLibro($_POST["id"],$_POST["Nombre"],
					$_POST["autor"],$_POST["editorial"],$_POST["categoria"],$_POST["descripcion"],$_POST["imagen"]);
				break;
				case'updateJSON';
				//hace referencia a la clase UsuarioRESTHandler
				$CRUDRestHandlerLibro = new CRUDRestHandlerLibro();
				//se dirige a la funcion 
				$CRUDRestHandlerLibro->updateJSON();
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
				//hace referencia a la clase UsuarioRESTHandler
				$CRUDRestHandlerLibro = new CRUDRestHandlerLibro();
				//le envia a la funcion insertUsuario los valores recividos desde la url
				$CRUDRestHandlerLibro->DeleteLibro($_GET["id"] );
			 break;
			 case'deleteJSON':
				//hace referencia a la clase UsuarioRESTHandler
				$CRUDRestHandlerLibro = new CRUDRestHandlerLibro();
				//le envia a la funcion insertUsuario los valores recividos desde la url
				$CRUDRestHandlerLibro->deleteJSON();
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
