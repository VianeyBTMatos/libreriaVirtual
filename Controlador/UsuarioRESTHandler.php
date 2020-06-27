<?php
require_once('CRUDUsuario.php');
require_once('../Modelo/usuario.php');
	
class UsuarioRESTHandler {

	function getAllUsuarios() {	
		 // hace referencia a la clase CRUDUsuario que contiene las operaciones a realizar
    	$crud= new CRUDUsuario();
        
		//Determina si la variable $_SERVER está definida y no es NULL
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
	} else {
		$requestContentType = '';
	}
	//devuelve la posición de la primera coincidencia de la palabra o carácter buscado en una cadena de texto
	if (strpos($requestContentType,'application/json') !== false)
	   {	  //ingresa al a funcion mostrarJSON(), que retorna en resultado con json_encode
				$listausuariosJSON = $crud->mostrarJSON();
			  //el valor que resiva $listaUsuariosJSON dara un resultado y si es falso entrara al if de lo contrario al else que es ok
		   if(empty($listausuariosJSON))
		    {
				 header("HTTP/1.1 404 No se encontraron usuarios");
				echo "Error";
				
						
			} else {
				header("HTTP/1.1 200 OK");
				header("Content-Type: application/json");
				echo($listausuariosJSON);
			}
		}

	//devuelve la posición de la primera coincidencia de la palabra application/xml buscado en una cadena de texto
	if (strpos($requestContentType,'application/xml') !== false)
	{	//ingresa al a funcion mostrar()
		$listaUsuariosXML = $crud->mostrar();
		//el valor que resiva $listaUsuariosXML dara un resultado y si es falso entrara al if de lo contrario al else que es ok
	 if(empty($listaUsuariosXML)) {
		   header("HTTP/1.1 404 No se encontraron usuarios");
		   header("Content-Type: application/xml");
		   
				  
	  } else {
	  
			 header("HTTP/1.1 200 OK");
		  header("Content-Type: application/xml");
		  //retorna el resultado que tenga la funcion XMLPasrse() en formato xml
		  XMLParse($listaUsuariosXML);
			 
			
	  }
  }
  	//si la solicitud esta vacia 
	if ( $requestContentType == ''){
		//ingresa al a funcion mostrat(), que es el que muestra todos los usuarios
		$listaUsuarios = $crud->mostrar();
		   //el valor que resiva $listaUsuarios dara un resultado es falso entrara al if de lo contrario al else que es ok
		if(empty($listaUsuarios)) {
			$statusCode = 404;
			$listaUsuarios = array('error' => 'No se encontraron usuarios!');		
		} else {
			$statusCode = 200;
			
		}
		
		//recorre lo que envia $listaUsuarios y obtiene lo que devuelve la funcion llamado get con los datos de la BD
        foreach ($listaUsuarios as $usuario){
			echo"<br>". $usuario->getDni().",";
			echo $usuario->getNombre().",";
			echo $usuario->getApellidoP().",";
			echo $usuario->getApellidoM().",";
			echo $usuario->getTelefono().",";
			echo $usuario->getDireccion()."<br>";
		} 
	}
		
    		
	}

	function getUsuario($Dni) {
		//crea un enlace en la clase CRUDUsuario();	
		$crud = new CRUDUsuario();
		//Determina si la variable $_SERVER está definida y no es NULL
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
	} else {
		$requestContentType = '';
	}	//devuelve la posición de la primera coincidencia de la palabra application/json buscado en una cadena de texto
	if (strpos($requestContentType,'application/json') !== false)
	   {
				//ingresa al a funcion obtenerUsuarioJSON(), que retorna en resultado con json_encode
			   $usuarioJSON = $crud->obtenerUsuarioJSON($Dni);
				//el valor que resiva $usuarioJSON dara un resultado y si es falso entrara al if de lo contrario al else que es ok
			 if(empty($usuarioJSON)) {
				 header("HTTP/1.1 404 No se encontro el usuario");
				 header("Content-Type: application/json");
			
						
			} else {
				header("HTTP/1.1 200 OK");
				header("Content-Type: application/json");
				echo $usuarioJSON;
			}

	   }
//devuelve la posición de la primera coincidencia de la palabra application/xml buscado en una cadena de texto
	   if (strpos($requestContentType,'application/xml') !== false)
	   {	//ingresa al a funcion obtenerUsuario()
		$usuario = $crud->obtenerUsuario($Dni);
		   //el valor que resiva $usuario dara un resultado y si es falso entrara al if de lo contrario al else que es ok
		if(empty($usuario)) {
			  header("HTTP/1.1 404 Error al intentar buscar");
			  header("Content-Type: application/xml");
			  
					 
		 } else {
			 //retorna el resultado que tenga la variable $usuario get y datos de la DB
			 //propio formato xml
			 header("HTTP/1.1 200 OK");
			 header("Content-Type: application/xml");
			 
			 echo "<Usuario>
						  <DNI>".
							  $usuario->getDni().
						  "</DNI>
						  <Nombre>".
								$usuario->getNombre().
						 "</Nombre>
						 <ApellidoPaterno>".
							  $usuario->getApellidoP().
						  "</ApellidoPaterno>
						  <ApellidoMaterno>".
								$usuario->getApellidoM().
						 "</ApellidoMaterno>
						 <Telefono>".
							  $usuario->getTelefono().
						  "</Telefono>
						  <Direccion>".
							  $usuario->getDireccion().
						 "</Direccion>
				   </Usuario>"
				   ;    
		 }
	 }

//si la solicitud esta vacia
	if ( $requestContentType == ''){ 
		//llama a la funcion obtenerUsuario() de la clase CRUDUsuario() y le envia el parametro optenido
		//anterior mente pormedio del get
	   	$usuario = $crud->obtenerUsuario($Dni);
         
		//lo que devuelve usuario es false entra al if y envia un error de estado de lo contrario se dirige al else
		
		if(empty($usuario)) {
			$statusCode = 404;
			$usuario = array('error' => 'No se encontraró el usuario!');
			//verifica si lo que devuelve getDni esta vacio entonces no se encontro el usuario	
		}if ($usuario->getDni() == null){
			echo "error: usuario no encontrado/a"; 
		}else { //envia los valores optenidos de la clase usuario y la funcion obtenerUsuario
			$statusCode = 200;
			echo "<br>". $usuario->getDni().","; 
			echo $usuario->getNombre().","; 
			echo $usuario->getApellidoP().","; 
			echo $usuario->getApellidoM().","; 
			echo $usuario->getTelefono().","; 
			echo $usuario->getDireccion()."</br>";
			
		}
	}


	}
	

	function insertUsuario($DNI, $Nombre,$APp, $APM,$Telefono, $Direccioin){
		//hace referencia a la clase CRUDUsuario
	   $crud= new CRUDUsuario();
	   //verificar si ya existe la clave
	   $exists = $crud->obtenerUsuario($DNI);
	   if(($exists->getDni() != null) ){
		$statusCode = 404;
		$exists = array('error' => 'Ya existe el DNI !!');
		echo "Ya existe DNI!!";
	   } else {
		$statusCode = 200;
		//hace referencia a la clase usuario para utilizar sus funciones
		$usuario = new usuario();
		$usuario->setDni($DNI);
		$usuario->setNombre($Nombre);
		$usuario->setApellidoP($APp);
		$usuario->setApellidoM($APM);
		$usuario->setTelefono($Telefono);
		$usuario->setDireccion($Direccioin);
		//contiene la funcion insertar que referencia de CRUDUsuario y le envia lo que resive de la url
		$crud->insertar($usuario);
		echo "exito al insertar el usuario!!";
	
	   }
	}

	function insertJson(){
			if (isset($_SERVER['CONTENT_TYPE'])){
				$requestContentType = $_SERVER['CONTENT_TYPE'];
			} 
			//devuelve la posicion de la primera coincidencia de la palabra o caracter buscado en una cadena de texto
			if (strpos($requestContentType,'application/json') != false){
				header("HTTP/1.1 404 Error");
				header("Content-Type: application/json");
				exit();				 
							}	
			//Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena
			// Transmite un fichero completo a una cadena
			$content = trim(file_get_contents("php://input"));
			//Decodifica un string de JSON
			$decoded = json_decode($content, true);
			$data = array();

			if(isset($decoded{'usuario'}['DNI']) and isset($decoded{'usuario'}['Nombre']) and
			isset($decoded{'usuario'}['PrimerApellido']) and isset($decoded{'usuario'}['SegundoApellido']) and
			$decoded{'usuario'}['Direccion']){
				header("HTTP/1.1 200 OK");
				//header("Content-Type: application/json");
				$this->insertUsuario($decoded{'usuario'}['DNI'],$decoded{'usuario'}['Nombre'],
				$decoded{'usuario'}['PrimerApellido'],$decoded{'usuario'}['SegundoApellido'],
				$decoded{'usuario'}['Telefono'],$decoded{'usuario'}['Direccion']);
			} else{
				header("HTTP/1.1 404 Error al intentar insertar");
				header("Content-Type: application/json");
				echo "Error en variables o nulos (solo telefono puede estar nulo)";
			}		
	}

	function updateUsuario($DNI, $Nombre,$APp, $APM,$Telefono, $Direccioin){
		//hace referencia a la clase CRUDUsuario
	   $crud= new CRUDUsuario();
		//hace referencia a la clase usuario para utilizar sus funciones
		$usuario = new usuario();
		$usuario->setDni($DNI);
		$usuario->setNombre($Nombre);
		$usuario->setApellidoP($APp);
		$usuario->setApellidoM($APM);
		$usuario->setTelefono($Telefono);
		$usuario->setDireccion($Direccioin);
		//contiene la funcion insertar que referencia de CRUDUsuario y le envia lo que resive de la url
		$crud->actualizar($usuario);
	   }

	function updateJSON(){
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} 
		//devuelve la posicion de la primera coincidencia de la palabra o caracter buscado en una cadena de texto
		if (strpos($requestContentType,'application/json') != false){
			header("HTTP/1.1 404 Error");
			header("Content-Type: application/json");
			exit();				 
						}	
		//Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena
		// Transmite un fichero completo a una cadena
		$content = trim(file_get_contents("php://input"));
		//Decodifica un string de JSON
		$decoded = json_decode($content, true);
		$data = array();

			header("HTTP/1.1 200 OK");
			//header("Content-Type: application/json");
			$this->updateUsuario($decoded{'usuario'}['DNI'],$decoded{'usuario'}['Nombre'],
			$decoded{'usuario'}['PrimerApellido'],$decoded{'usuario'}['SegundoApellido'],
			$decoded{'usuario'}['Telefono'],$decoded{'usuario'}['Direccion']);
	
}



	function deleteUsuario($Dni){
	   $crud= new CRUDUsuario();
	   //hace referencia a la clase usuario para utilizar sus funciones
	   $usuario = new usuario();
	   $usuario->setDni($Dni);
	   //contiene la funcion insertar que referencia de CRUD y le envia lo que resive de la url
	   $result = $crud->eliminar($usuario);
	   echo "Operación realizada!!";
	}

	function deleteJSON(){
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} 
		//devuelve la posicion de la primera coincidencia de la palabra o caracter buscado en una cadena de texto
		if (strpos($requestContentType,'application/json') != false){
			header("HTTP/1.1 404 Error");
			header("Content-Type: application/json");
			exit();				 
						}	
		//Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena
		// Transmite un fichero completo a una cadena
		$content = trim(file_get_contents("php://input"));
		//Decodifica un string de JSON
		$decoded = json_decode($content, true);
		$data = array();

			header("HTTP/1.1 200 OK");
			$this->deleteUsuario($decoded{'usuario'}['DNI']);
	}
	
}



function XMLParse($listaUsuariosXML) 
		{	
			//llama a la clase XMLWriter que tiene funciones que ayudan a crear el formato xml
			$xml = new XMLWriter();
			//es un contenedor para Net :: HTTP, Net :: HTTPS y Net :: FTP.
			$xml->openURI("php://output");
			//Crea un etiqueta del documento
			$xml->startDocument('1.0', 'UTF-8');
			//Cambia la sangria de apagada/encendida
			$xml->setIndent(true);
			//Crea la etiqueta del elemento inicial
			$xml->startElement('Usuarios');
			//recorre lo que tenga $listaUsuariosXML que fue pasado desde la funcion getAllUsuarios() y lo almacena en usuario
            foreach ($listaUsuariosXML as $usuario)
			{	//Crea la etiqueta del elemento inicial de Usuarios
				$xml->startElement('Usuarios');
				//Crea la etiqueta del elemento Dni			
				$xml->startElement("Dni");
				//Escribe un texto sin formato del XML el valor que tiene getDni en usuario 
				$xml->writeRaw($usuario->getDni());
				//Finaliza el actual elemento
				$xml->endElement();
				//Crea la etiqueta del elemento Nombre
				$xml->startElement("Nombre");
				//Escribe un texto sin formato del XML el valor que tiene getNombre en usuario
				$xml->writeRaw($usuario->getNombre());
				//Finaliza el actual elemento
				$xml->endElement();
				//Crea la etiqueta del elemento ApellidoPaterno
				$xml->startElement("ApellidoPaterno");
				//Escribe un texto sin formato del XML el valor que tiene getApellidoP en usuario
				$xml->writeRaw($usuario->getApellidoP());
				//Finaliza el actual elemento
				$xml->endElement();
				//Crea la etiqueta del elemento ApellidoMaterno
				$xml->startElement("ApellidoMaterno");
				//Escribe un texto sin formato del XML el valor que tiene getApellidoM en usuario
				$xml->writeRaw($usuario->getApellidoM());
				//Finaliza el actual elemento
				$xml->endElement();
				//Crea la etiqueta del elemento Telefono
				$xml->startElement("Telefono");
				//Escribe un texto sin formato del XML el valor que tiene getTelefono en usuario
				$xml->writeRaw($usuario->getTelefono());
				//Finaliza el actual elemento
				$xml->endElement();
				//Crea la etiqueta del elemento Direccion
				$xml->startElement("Direccion");
				//Escribe un texto sin formato del XML el valor que tiene getDireccion en usuario
				$xml->writeRaw($usuario->getDireccion());
				//Finaliza el actual elemento
				$xml->endElement();
				//Finaliza el actual elemento
				$xml->endElement();
			}

			$xml->endDocument();

			//header('Content-type: text/xml');
			$xml->flush();
			return $xml;


		}
?>