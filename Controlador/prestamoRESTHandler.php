<?php

require_once('prestamoRESTController.php');
require_once('prestamoCRUD.php');
require_once('../Modelo/pedidos.php');
	
class CURDRestHandler  {

	function getAllPrestamos() {	
    	$crud = new CrudPrestamos(); // hace referencia a la clase CrudPrestamos que contiene las operaciones a realizar
        
		if (isset($_SERVER['CONTENT_TYPE'])){ //Determina si la variable $_SERVER esta definida y no es NULL
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} else {
			$requestContentType = '';
		}

		if (strpos($requestContentType,'application/json') !== false) //devuelve la posicion de la primera coincidencia de la palabra o caracter buscado en una cadena de texto
		{	
			$listaPrestamosJSON = $crud->mostrarJSON(); //ingresa a la funcion mostrarJSON(), que retorna en resultado con json_encode
			if(empty($listaPrestamosJSON)) { //el valor que resiva $listaPrestamosJSON dara un resultado y si es falso entrara al if de lo contrario al else que es ok
				header("HTTP/1.1 404 No se encontraron Prestamos");
				header("Content-Type: application/json");	
			} else {
				header("HTTP/1.1 200 OK");
				header("Content-Type: application/json");
				echo $listaPrestamosJSON;
			}
		}

			
		if (strpos($requestContentType,'application/xml') !== false) //devuelve la posición de la primera coincidencia de la palabra application/xml buscado en una cadena de texto
		{	
			$listaPrestamosXML = $crud->mostrar(); //ingresa a la funcion mostrar()
			if(empty($listaPrestamosXML)) { //el valor que resiva $listaUsuariosXML dara un resultado y si es falso entrara al if de lo contrario al else que es ok
				header("HTTP/1.1 404 No se encontraron prestamos");
				header("Content-Type: application/xml");		
			} else {
				header("HTTP/1.1 200 OK");
				header("Content-Type: application/xml");
				XMLParse($listaPrestamosXML);//retorna el resultado que tenga la funcion XMLPasrse() en formato xml
			}
		}	

		if ( $requestContentType == ''){ //Si la solicitud esta vacia.
			$listaPrestamos = $crud->mostrar(); //ingresa al a funcion mostrar(), que es el que muestra todos los Prestamos
			
			if(empty($listaPrestamos)) { //el valor que resiva $listaPrestamos dara un resultado si es falso entrara al if de lo contrario al else que es ok
				$statusCode = 404;
				$listaPrestamos = array('error' => 'No se encontraron prestamos!');		
			} else {
				$statusCode = 200;
			}
			
			foreach ($listaPrestamos as $prestamos){ //recorre lo que envia $listPrestamos y obtiene lo que devuelve la funcion llamado get y lo que se necesita
				echo"<br>". $prestamos->getIdPrestamo().",";
				echo $prestamos->getDomicilio().","; 
				echo $prestamos->getTelefono().","; 
				echo $prestamos->getFecha_salida().",";
				echo $prestamos->getFecha_entrega().",";
				echo $prestamos->getId_libro().",";
				echo $prestamos->getDni_user()."<br>";
			} 
		}    		
	}

	function getPrestamos($Id_prestamo) {
		$crud = new CrudPrestamos(); //crea un enlace en la clase CrudPrestamos();
		
		if (isset($_SERVER['CONTENT_TYPE'])){ //Determina si la variable $_SERVER esta definida y no es NULL
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} else {
			$requestContentType = '';
		}

		if (strpos($requestContentType,'application/json') !== false) //devuelve la posicion de la primera coincidencia de la palabra application/json buscado en una cadena de texto
		{
			$PrestamoJSON = $crud->obtenerPrestamoJSON($Id_prestamo); //ingresa al a funcion obtenerPrestamoJSON(), que retorna en resultado con json_encode
				
			if(empty($PrestamoJSON)) { //el valor que resiva $PrestamoJSON dara un resultado y si es falso entrara al if de lo contrario al else que es ok
				header("HTTP/1.1 404 No se encontro el prestamo");
				header("Content-Type: application/json");		
			} else {
				header("HTTP/1.1 200 OK");
				header("Content-Type: application/json");
				echo $PrestamoJSON;
			}
		}
				 
		if (strpos($requestContentType,'application/xml') !== false)
	   {	
			$PrestamoXML = $crud->obtenerPrestamo($Id_prestamo); //ingresa a la funcion obtenerPrestamo()
			
			if(empty($PrestamoXML)) { //el valor que resiva $PrestamoXML dara un resultado y si es falso entrara al if de lo contrario al else que es ok
				header("HTTP/1.1 404 Error al intentar buscar");
				header("Content-Type: application/xml");	 
			} else { //Retorna el resultado que tenga la variable $PrestamoXML get y datos de la DB, propio formato xml
				header("HTTP/1.1 200 OK");
				header("Content-Type: application/xml");
				echo 	"<Prestamos>
							<Id_prestamo>".
								$PrestamoXML->getIdPrestamo().
							"</Id_prestamo>
							<Domicilio>".
								$PrestamoXML->getDomicilio().
							"</Domicilio>
							<Telefono>".
								$PrestamoXML->getTelefono().
							"</Telefono>
							<Fecha_salida>".
									$PrestamoXML->getFecha_salida().
							"</Fecha_salida>
							<Fecha_entrega>".
								$PrestamoXML->getFecha_entrega().
							"</Fecha_entrega>
							<Id_libro>".
								$PrestamoXML->getId_libro().
							"</Id_libro>
							<Dni_user>".
								$PrestamoXML->getDni_user().
							"</Dni_user>
						</Prestamos>"
						;    
			}
		}

		if ( $requestContentType == '')
		{
			$Prestamo = $crud->obtenerPrestamo($Id_prestamo); //llama a la funcion obtenerPrestamo() de la clase Crud() y le envia el parametro obtenido anteriormente por medio del get
			
			if(empty($Prestamo)) { //si lo que devuelve $prestamos es false entra al if y envia un error de estado de lo contrario se dirige al else
				$statusCode = 404;
				$Prestamo = array('error' => 'No se encontrara!');
			}
			
			if ($Prestamo->getIdPrestamo() == null){
				echo "error: Prestamo no encontrado/a"; 
			}else { //envia los valores optenidos de la clase Prestamo y la funcion obtenerPrestamo
				$statusCode = 200;
				echo $Prestamo->getIdPrestamo().",";
				echo $Prestamo->getDomicilio().","; 
				echo $Prestamo->getTelefono().","; 
				echo $Prestamo->getFecha_salida().",";
				echo $Prestamo->getFecha_entrega().",";
				echo $Prestamo->getId_libro().",";
				echo $Prestamo->getDni_user()."<br>";
			}
		}
	}


	function InsertPrestamos($Id_prestamo, $Domicilio, $Telefono, $Fecha_salida, $Fecha_entrega, $Id_libro, $Dni_user) {
	   $crud= new CrudPrestamos(); //hace referencia a la clase CrudPrestamos
	   $exists = $crud->obtenerPrestamo($Id_prestamo); //verificar si ya existe el prestamo con ese id
	   
	   if(($exists->getIdPrestamo() != null) ){
			$statusCode = 404;
			$exists = array('error' => 'Ya existe el ID del prestamo!!');
			echo "Ya existe la ID del prestamo!!";
	   } else {
			$statusCode = 200;
			$Prestamo = new pedidos(); //hace referencia a la clase pedidos para utilizar sus funciones
			$Prestamo->setIdPrestamo($Id_prestamo);
			$Prestamo->setDomicilio($Domicilio);
			$Prestamo->setTelefono($Telefono);
			$Prestamo->setFecha_salida($Fecha_salida);
			$Prestamo->setFecha_entrega($Fecha_entrega);
			$Prestamo->setId_libro($Id_libro);
			$Prestamo->setDni_user($Dni_user);
			
			$crud->insertar($Prestamo); //contiene la funcion insertar que referencia de CRUD y le envia lo que resive de la url
			echo "exito al insertar!!!";	
	   }
	}

	function InsertPrestamosJSON(){
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} 
		
		if (strpos($requestContentType,'application/json') != false){ //devuelve la posicion de la primera coincidencia de la palabra o caracter buscado en una cadena de texto
			header("HTTP/1.1 404 Error");
			header("Content-Type: application/json");
			exit();				 
		}	
		
		$content = trim(file_get_contents("php://input")); //Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena. Transmite un fichero completo a una cadena
		$decoded = json_decode($content, true); //Decodifica un string de JSON
		// $data = file_get_contents($decoded);
		$data = array();

		if	(isset($decoded{'Prestamo'}['Id_prestamo']) and isset($decoded{'Prestamo'}['Domicilio']) and isset($decoded{'Prestamo'}['Telefono']) and 
			isset($decoded{'Prestamo'}['Fecha_salida']) and isset($decoded{'Prestamo'}['Fecha_entrega']) and isset($decoded{'Prestamo'}['Id_libro']) and 
			$decoded{'Prestamo'}['Dni_user'])
		{
			header("HTTP/1.1 200 OK");
			$this->InsertPrestamos($decoded{'Prestamo'}['Id_prestamo'],$decoded{'Prestamo'}['Domicilio'], $decoded{'Prestamo'}['Telefono'],$decoded{'Prestamo'}['Fecha_salida'],
			$decoded{'Prestamo'}['Fecha_entrega'],$decoded{'Prestamo'}['Id_libro'],$decoded{'Prestamo'}['Dni_user']);

		} else{

			header("HTTP/1.1 404 Error al intentar insertar");
			header("Content-Type: application/json");
			echo "Error en variables o nulos (solo telefono puede estar nulo)";
		}		
	}

	function actualizarPrestamos($Id_prestamo, $Domicilio, $Telefono, $Fecha_salida, $Fecha_entrega, $Id_libro, $Dni_user){
		$crud= new CrudPrestamos(); //hace referencia a la clase CRUDUsuario
		$prestamo = new pedidos(); //hace referencia a la clase usuario para utilizar sus funciones
		$prestamo->setIdPrestamo($Id_prestamo);
		$prestamo->setDomicilio($Domicilio);
		$prestamo->setTelefono($Telefono);
		$prestamo->setFecha_salida($Fecha_salida);
		$prestamo->setFecha_entrega($Fecha_entrega);
		$prestamo->setId_libro($Id_libro);
		$prestamo->setDni_user($Dni_user);
		$crud->actualizar($prestamo); //contiene la funcion insertar que referencia de CRUDprestamo y le envia lo que resive de la url
	}

	function actualizarPrestamosJSON(){
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} 
		
		if (strpos($requestContentType,'application/json') != false) //devuelve la posicion de la primera coincidencia de la palabra o caracter buscado en una cadena de texto
		{
			header("HTTP/1.1 404 Error");
			header("Content-Type: application/json");
			exit();				 
		}	
		//Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena
		// Transmite un fichero completo a una cadena
		$content = trim(file_get_contents("php://input"));
		$decoded = json_decode($content, true); //Decodifica un string de JSON
		$data = array();
		header("HTTP/1.1 200 OK");
		$this->actualizarPrestamos($decoded{'prestamo'}['Id_prestamo'],$decoded{'prestamo'}['Domicilio'], $decoded{'prestamo'}['Telefono'],$decoded{'prestamo'}['Fecha_salida'],
		$decoded{'prestamo'}['Fecha_entrega'],$decoded{'prestamo'}['Id_libro'],$decoded{'prestamo'}['Dni_user']);
	}


	function eliminarPrestamo($Id_prestamo){
		$crud= new CrudPrestamos(); //hace referencia a la clase CrudPrestamos para utilizar sus funciones
		$prestamo = new pedidos();
		$prestamo->setIdPrestamo($Id_prestamo);
		$result = $crud->eliminar($prestamo); //contiene la funcion insertar que referencia de CRUD y le envia lo que resive de la url	
	}

	function eliminarPrestamoJSON(){
		if (isset($_SERVER['CONTENT_TYPE']))
		{
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} 
		
		if (strpos($requestContentType,'application/json') != false) //devuelve la posicion de la primera coincidencia de la palabra o caracter buscado en una cadena de texto
		{
			header("HTTP/1.1 404 Error");
			header("Content-Type: application/json");
			exit();	
		}	
		
		$content = trim(file_get_contents("php://input")); //Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena. Transmite un fichero completo a una cadena
		$decoded = json_decode($content, true); //Decodifica un string de JSON
		$data = array();
		header("HTTP/1.1 200 OK");
		$this->eliminarPrestamo($decoded{'prestamo'}['Id_prestamo']);

		
	}	
}

function XMLParse($listaPrestamosXML) 
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
			$xml->startElement('Prestamos');
			//recorre lo que tenga $listaPrestamosXML que fue pasado desde la funcion getAllPrestamos() y lo almacena en prestamos
            foreach ($listaPrestamosXML as $prestamo)
			{	//Crea la etiqueta del elemento inicial de Prestamos
				$xml->startElement('Prestamos');
				
				//Crea la etiqueta del elemento Id_prestamo			
				$xml->startElement("Id_prestamo");
				//Escribe un texto sin formato del XML el valor que tiene getIdPrestamo en prestamo 
				$xml->writeRaw($prestamo->getIdPrestamo());
				//Finaliza el actual elemento
				$xml->endElement();
				
				//Crea la etiqueta del elemento Domicilio
				$xml->startElement("Domicilio");
				//Escribe un texto sin formato del XML el valor que tiene getDomicilio en prestamo
				$xml->writeRaw($prestamo->getDomicilio());
				//Finaliza el actual elemento
				$xml->endElement();
				
				//Crea la etiqueta del elemento Telefono
				$xml->startElement("Telefono");
				//Escribe un texto sin formato del XML el valor que tiene getTelefono en prestamo
				$xml->writeRaw($prestamo->getTelefono());
				//Finaliza el actual elemento
				$xml->endElement();
				
				//Crea la etiqueta del elemento Fecha_salida
				$xml->startElement("Fecha_salida");
				//Escribe un texto sin formato del XML el valor que tiene getFecha_salida en prestamo
				$xml->writeRaw($prestamo->getFecha_salida());
				//Finaliza el actual elemento
				$xml->endElement();
				
				//Crea la etiqueta del elemento Fecha_entrega
				$xml->startElement("Fecha_entrega");
				//Escribe un texto sin formato del XML el valor que tiene getFecha_entrega en prestamo
				$xml->writeRaw($prestamo->getFecha_entrega());
				//Finaliza el actual elemento
				$xml->endElement();
				
				//Crea la etiqueta del elemento Id_libro
				$xml->startElement("Id_libro");
				//Escribe un texto sin formato del XML el valor que tiene getId_libro en prestamo
				$xml->writeRaw($prestamo->getId_libro());
				//Finaliza el actual elemento
				$xml->endElement();
				//Finaliza el actual elemento

				//Crea la etiqueta del elemento Dni_user
				$xml->startElement("Dni_user");
				//Escribe un texto sin formato del XML el valor que tiene getDni_user en prestamo
				$xml->writeRaw($prestamo->getDni_user());
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