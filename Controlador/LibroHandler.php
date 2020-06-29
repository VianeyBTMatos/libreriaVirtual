<?php
require_once('LibroCRUD.php');
require_once('../Modelo/libros.php');
	
class CRHLibro  {

	function getAllLibros() {	
		 // hace referencia a la clase 
    	$crud = new CLibros();
		//establecer si la variable $_SERVER esta definida y no es NULL
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
	} else {
		$requestContentType = '';
	}
	if (strpos($requestContentType,'application/json') !== false)
	   {	  //ingresa al a funcion VisLibJSON(), 
			  $listLibJSON = $crud->VisLibJSON();
		   if(empty($listLibJSON)) {
				 header("HTTP/1.1 404 No se encontraron Usuarios");
				 header("Content-Type: application/json");
			} else {
				   header("HTTP/1.1 200 OK");
				header("Content-Type: application/json");
				  echo $listLibJSON;
			}
		}
	if (strpos($requestContentType,'application/xml') !== false)
	{	//ingresa al a funcion VisLib()
		$listLibxml = $crud->VisLib();
	 if(empty($listLibxml)) {
		   header("HTTP/1.1 404 No se encontraron libros");
		   header("Content-Type: application/xml");
		   
	  } else {
	  
			 header("HTTP/1.1 200 OK");
		  header("Content-Type: application/xml");
		  XMLParse($listLibxml); 
	  }
  }

	if ( $requestContentType == ''){
		$listLib = $crud->VisLib();
		 	if(empty($listLib)) {
			$statusCode = 404;
			$listLib = array('error' => 'No se encontraron libros!');		
		} else {
			$statusCode = 200;
			
		}
	  foreach ($listLib as $libro){
                 echo $libro->getId().",";
                 echo $libro->getNombre().",";
                 echo $libro->getAutor().",";
                 echo $libro->getEditorial().",";
                 echo $libro->getCategoria().",";
                 echo $libro->getDescripcion().",";
				 echo $libro->getImagen()."<br>";
		} 
	}
		
    		
	}

	function getLibro($id) {	
		$crud = new CLibros();
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
	} else {
		$requestContentType = '';
	}	
	if (strpos($requestContentType,'application/json') !== false)
	   {
			   $LibroJSON = $crud->BuscarLibJSON($id);
			 if(empty($LibroJSON)) {
				 header("HTTP/1.1 404 No se encontro el libro");
				 header("Content-Type: application/json");
			} else {
				header("HTTP/1.1 200 OK");
				header("Content-Type: application/json");
				echo $LibroJSON ;
			}

	   }
	
	   if (strpos($requestContentType,'application/xml') !== false)
	   {	
		$libro = $crud->BuscarLib($id);
		  
		if(empty($libro)) {
			  header("HTTP/1.1 404 No se encontro");
			  header("Content-Type: application/xml");	 
		 } else {
			 header("HTTP/1.1 200 OK");
			 header("Content-Type: application/xml");
			 
			 echo "<libro>
						  <id>".
							  $libro->getId().
						  "</id>
						  <Nombre>".
								$libro->getNombre().
						  "</Nombre>
						  <Autor>".
							  $libro->getAutor().
						  "</Autor>
						  <Editorial>".
								$libro->getEditorial().
                          "</Editorial>
                          <Categoria>".
                                $libro->getCategoria().
                          "</Categoria>
                          <Descripcion>".
                                $libro->getDescripcion().
                          "</Descripcion>
                          <Imagen>".
                                $libro->getImagen().
                          "</Imagen>
					  </libro>"
				   ;    
		 }
	 }
	if ( $requestContentType == ''){ 
	   	$libro = $crud->BuscarLib($id);
		if(empty($libro)) {
			$statusCode = 404;
			$libro = array('error' => 'No se encontrara!');			
		}if ($libro->getId() == null){
			echo "error: libro no encontrado"; 
		}else { 
			$statusCode = 200;
            echo "<br>".$libro->getId().",";
            echo $libro->getNombre().",";
            echo $libro->getAutor().",";
            echo $libro->getEditorial().",";
            echo $libro->getCategoria().",";
			echo $libro->getDescripcion().",";
            echo $libro->getImagen()."<br>";		
		}
	}
	}
	function InsertLib($id, $nombre, $autor, $editorial, $categoria, $descripcion, $imagen){
		
	   $crud= new CLibros();
	
	   $exists = $crud->BuscarLib($id);
	   if(($exists->getId() != null) ){
		$statusCode = 404;
		$exists = array('error' => 'Ya existe el id del libro!!');
		echo "id en existencia";
	   } else {
		$statusCode = 200;
			//hace referencia a la clase libro para utilizar sus funciones
		   $libro = new Libro();
            $libro->setId($id);
		    $libro->setNombre($nombre);
			$libro->setAutor($autor);
			$libro->setEditorial($editorial);
			$libro->setCategoria($categoria);
			$libro->setDescripcion($descripcion);
			$libro->setImagen($imagen);
		   $crud->insertL($libro);
		   echo "exito al agregar";
	
	   }
    }
    function LibInsertJson(){
        // if (isset($_SERVER['CONTENT_TYPE'])){
        //     $requestContentType = $_SERVER['CONTENT_TYPE'];
        // } 
        // if (strpos($requestContentType,'application/json') != false){
        //     header("HTTP/1.1 404 Error");
        //     header("Content-Type: application/json");
        //     exit();				 
        //                 }	
        // $content = trim(file_get_contents("php://input"));
 
        // $decoded = json_decode($content, true);
        // $data = array();

        // if(isset($decoded{'libro'}['id']) and isset($decoded{'libro'}['Nombre']) and
        // isset($decoded{'libro'}['autor']) and isset($decoded{'libro'}['editorial']) and 
        // isset($decoded{'libro'}['categoria']) and isset($decoded{'libro'}['descripcion']) and 
        // isset($decoded{'libro'}['imagen'])
        // ){
        //     header("HTTP/1.1 200 OK");
        //     $this->LibInsertJson($decoded{'libro'}['id'],$decoded{'libro'}['Nombre'],
        //     $decoded{'libro'}['autor'],$decoded{'libro'}['editorial'],
        //     $decoded{'libro'}['categoria'],$decoded{'libro'}['descripcion'],$decoded{'libro'}['imagen']);
        // } else{
        //     header("HTTP/1.1 404 Error al intentar insertar");
        //     header("Content-Type: application/json");
        //     echo "Error en variables o nulos ";
		// }
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

		if(
			isset($decoded{'libro'}['id']) and 
			isset($decoded{'libro'}['nombre']) and
			isset($decoded{'libro'}['autor']) and 
			isset($decoded{'libro'}['editorial']) and
			isset($decoded{'libro'}['categoria']) and
			isset($decoded{'libro'}['descripcion']) and
			$decoded{'libro'}['imagen'])
		{
			header("HTTP/1.1 200 OK");
			//header("Content-Type: application/json");
			$this->InsertLib($decoded{'libro'}['id'],
							$decoded{'libro'}['nombre'],
							$decoded{'libro'}['autor'],
							$decoded{'libro'}['editorial'],
							$decoded{'libro'}['categoria'],
							$decoded{'libro'}['descripcion'],
							$decoded{'libro'}['imagen']);
		} else{
			header("HTTP/1.1 404 Error al intentar insertar");
			header("Content-Type: application/json");
			echo "Error en variables o nulos (solo telefono puede estar nulo)";
		}
				
}

	function actLibro($id, $nombre, $autor, $editorial, $categoria, $descripcion, $imagen){
		$crud= new CLibros();
			$libro = new Libro();
			$libro->setId($id);
		    $libro->setNombre($nombre);
			$libro->setAutor($autor);
			$libro->setEditorial($editorial);
			$libro->setCategoria($categoria);
			$libro->setDescripcion($descripcion);
			$libro->setImagen($imagen);
			$crud->ActLib($libro);
          
    }
    function ActJSON(){
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} 
		
		if (strpos($requestContentType,'application/json') != false){
			header("HTTP/1.1 404 Error");
			header("Content-Type: application/json");
			exit();				 
						}	
	
		$content = trim(file_get_contents("php://input"));

		$decoded = json_decode($content, true);
		$data = array();

			header("HTTP/1.1 200 OK");

			$this->actLibro($decoded{'libro'}['id'],$decoded{'libro'}['Nombre'],
            $decoded{'libro'}['autor'],$decoded{'libro'}['editorial'],
            $decoded{'libro'}['categoria'],$decoded{'libro'}['descripcion'],$decoded{'libro'}['imagen']);
	
}


	function ElimLibro($id){
		$crud= new CLibros();
			
			$libro = new Libro();
			$libro->setId($id);
			$result = $crud->EliminarLib($libro);
			echo "Operación realizada!!";	
				
    }
    function ElimJSON(){
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
		} 
		
		if (strpos($requestContentType,'application/json') != false){
			header("HTTP/1.1 404 Error");
			header("Content-Type: application/json");
			exit();		
			}		 
		$content = trim(file_get_contents("php://input"));
		$decoded = json_decode($content, true);
		$data = array();

			header("HTTP/1.1 200 OK");
			$this->ElimLibro($decoded{'libro'}['id']);
	}
	
}

function XMLParse($listaLibrosxml) 
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
			$xml->startElement('Libros');
			//recorre lo que tenga $listaUsuariosxml que fue pasado desde la funcion getAllMaterias() y lo almacena en usuarios
            foreach ($listaLibrosxml as $libro)
			{	//Crea la etiqueta del elemento inicial de usuarios
				$xml->startElement('Libros');
				//Crea la etiqueta del elemento nombre
				$xml->startElement("id");
				//Escribe un texto sin formato del XML el valor que tiene getNome en usuarios 
				$xml->writeRaw($libro->getId());
				//Finaliza el actual elemento
				$xml->endElement();
				//Crea la etiqueta del elemento apellido
				$xml->startElement("nombre");
				//Escribe un texto sin formato del XML el valor que tiene getSobreNome en usuarios
				$xml->writeRaw($libro->getNombre());
				//Finaliza el actual elemento
				$xml->endElement();
				//Crea la etiqueta del elemento Edad
				$xml->startElement("autor");
				//Escribe un texto sin formato del XML el valor que tiene getIdade en usuarios
				$xml->writeRaw($libro->getAutor());
				//Finaliza el actual elemento
				$xml->endElement();
				//Crea la etiqueta del elemento Ciudad
				$xml->startElement("Editorial");
				//Escribe un texto sin formato del XML el valor que tiene getOrigem en usuarios
				$xml->writeRaw($libro->getEditorial());
				//Finaliza el actual elemento
                $xml->endElement();
                $xml->startElement("Categoria");
				//Escribe un texto sin formato del XML el valor que tiene getOrigem en usuarios
				$xml->writeRaw($libro->getCategoria());
				//Finaliza el actual elemento
                $xml->endElement();
                $xml->startElement("Descripcion");
				//Escribe un texto sin formato del XML el valor que tiene getOrigem en usuarios
				$xml->writeRaw($libro->getDescripcion());
				//Finaliza el actual elemento
                $xml->endElement();
                $xml->startElement("Imagen");
				//Escribe un texto sin formato del XML el valor que tiene getOrigem en usuarios
				$xml->writeRaw($libro->getImagen());
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