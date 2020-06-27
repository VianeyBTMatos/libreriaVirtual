<?php
require_once("UsuarioRestHandler.php");

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
				$UsuarioRESTHandler = new UsuarioRESTHandler();
				//accede a la funcion de de la clase UsuarioRESTHandler llamada getAllUsuarios()
				$UsuarioRESTHandler->getAllUsuarios();
				break;
		//si en este caso es uno este hara los iguiente
			case "specific":
				//referencia a la clase UsuarioRESTHandler
				$UsuarioRESTHandler = new UsuarioRESTHandler();
				//accede a la funcion de de la clase UsuarioRESTHandler llamada getUsuario()
				//este debe de recibir desde la url un valor con el nombre de Dni
				//http://localhost:8080/libreriaVirtual/Controlador/RESTUsuarioController.php?search=specific&Dni=Valor
				$UsuarioRESTHandler->getUsuario($_GET["Dni"]);
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
				if  ((empty($_POST["DNI"]) != true) and (empty($_POST["Nombre"]) != true) and
				(empty($_POST["PrimerApellido"]) != true) and (empty($_POST["SegundoApellido"]) != true) and
				(empty($_POST["Direccion"]) != true) ){
					//hace referencia a la clase UsuarioRESTHandler
					$UsuarioRestHandler = new UsuarioRESTHandler();
					//le envia a la funcion insertUsuario los valores recividos desde la url
					$UsuarioRestHandler->insertUsuario($_POST["DNI"],$_POST["Nombre"],
					$_POST["PrimerApellido"],$_POST["SegundoApellido"],$_POST["Telefono"],$_POST["Direccion"]);
				}else {
						header("HTTP/1.1 400  error en variables");
						echo"Variables vacias o error de ellas";
				}
				break;
				case'insertJSON';
				//hace referencia a la clase UsuarioRESTHandler
				$UsuarioRestHandler = new UsuarioRESTHandler();
				//se dirige a la funcion 
				$UsuarioRestHandler->insertJson();
				break;
				case'update':
					//hace referencia a la clase UsuarioRESTHandler
					$UsuarioRestHandler = new UsuarioRESTHandler();
					//se dirige a la funcion 
					$UsuarioRestHandler->updateUsuario($_POST["DNI"],$_POST["Nombre"],
					$_POST["PrimerApellido"],$_POST["SegundoApellido"],$_POST["Telefono"],$_POST["Direccion"]);
				break;
				case'updateJSON';
				//hace referencia a la clase UsuarioRESTHandler
				$UsuarioRestHandler = new UsuarioRESTHandler();
				//se dirige a la funcion 
				$UsuarioRestHandler->updateJSON();
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
				$UsuarioRESTHandler = new UsuarioRESTHandler();
				//le envia a la funcion insertUsuario los valores recividos desde la url
				$UsuarioRESTHandler->deleteUsuario($_GET["DNI"] );
			 break;
			 case'deleteJSON':
				//hace referencia a la clase UsuarioRESTHandler
				$UsuarioRESTHandler = new UsuarioRESTHandler();
				//le envia a la funcion insertUsuario los valores recividos desde la url
				$UsuarioRESTHandler->deleteJSON();
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