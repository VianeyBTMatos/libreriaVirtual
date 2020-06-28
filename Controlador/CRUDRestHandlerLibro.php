<?php
require_once('CRUDLIBRO.php');
require_once('../modelo/libros.php');
	
class CRUDRestHandlerLibro  {

	function getAllLibros() {	
		 // hace referencia a la clase CrudLibros que contiene las operaciones a realizar
    	$crud = new CrudLibros();
        
		//Determina si la variable $_SERVER esta definida y no es NULL
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
	} else {
		$requestContentType = '';
	}
	//devuelve la posicion de la primera coincidencia de la palabra o caracter buscado en una cadena de texto
	if (strpos($requestContentType,'application/json') !== false)
	   {	  //ingresa al a funcion mostrarJSON(), que retorna en resultado con json_encode
			  $listaLibrosJSON = $crud->mostrarJSON();
			  //el valor que resiva $listalibrosJSON dara un resultado y si es falso entrara al if de lo contrario al else que es ok
		   if(empty($listaLibrosJSON)) {
				 header("HTTP/1.1 404 No se encontraron Usuarios");
				 header("Content-Type: application/json");
				 
						
			} else {
			
				   header("HTTP/1.1 200 OK");
				header("Content-Type: application/json");
				  echo $listaLibrosJSON;
			}
		}

	//devuelve la posicion de la primera coincidencia de la palabra application/xml buscado en una cadena de texto
	if (strpos($requestContentType,'application/xml') !== false)
	{	//ingresa al a funcion mostrar()
		$listaLibrosxml = $crud->mostrar();
		//el valor que resiva $listaUsuariosxml dara un resultado y si es falso entrara al if de lo contrario al else que es ok
	 if(empty($listaLibrosxml)) {
		   header("HTTP/1.1 404 No se encontraron libros");
		   header("Content-Type: application/xml");
		   
				  
	  } else {
	  
			 header("HTTP/1.1 200 OK");
		  header("Content-Type: application/xml");
		  //retorna el resultado que tenga la funcion XMLPasrse() en formato xml
		  XMLParse($listaLibrosxml);
			 
			
	  }
  }

	if ( $requestContentType == ''){
		//ingresa al a funcion mostrat(), que es el que muestra todos los usuarios
		$listaLibros = $crud->mostrar();
		   //el valor que resiva $listausuarios dara un resultado es falso entrara al if de lo contrario al else que es ok
		if(empty($listaLibros)) {
			$statusCode = 404;
			$listaLibros = array('error' => 'No se encontraron libros!');		
		} else {
			$statusCode = 200;
			
		}
		
		//recorre lo que envia $listalibros y obtiene lo que devuelve la funcion llamado get y lo que se necesita
        foreach ($listaLibros as $libro){
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

	function getLibros($id) {
		//crea un enlace en la clase CrudUsuarios();	
		$crud = new CrudLibros();
		//Determina si la variable $_SERVER esta definida y no es NULL
		if (isset($_SERVER['CONTENT_TYPE'])){
			$requestContentType = $_SERVER['CONTENT_TYPE'];
	} else {
		$requestContentType = '';
	}	//devuelve la posicion de la primera coincidencia de la palabra application/json buscado en una cadena de texto
	if (strpos($requestContentType,'application/json') !== false)
	   {
				//ingresa al a funcion obtenerUsuarioJSON(), que retorna en resultado con json_encode
			   $LibroJSON = $crud->obtenerLibroJSON($id);
				//el valor que resiva $UsuarioJSON dara un resultado y si es falso entrara al if de lo contrario al else que es ok
			 if(empty($LibroJSON)) {
				 header("HTTP/1.1 404 No se encontro el libro");
				 header("Content-Type: application/json");
			
						
			} else {
				header("HTTP/1.1 200 OK");
				header("Content-Type: application/json");
				echo $LibroJSON ;
			}

	   }
//devuelve la posicion de la primera coincidencia de la palabra application/xml buscado en una cadena de texto
	   if (strpos($requestContentType,'application/xml') !== false)
	   {	//ingresa al a funcion obtenerUsuario()
		$libro = $crud->obtenerLibro($id);
		   //el valor que resiva $materia dara un resultado y si es falso entrara al if de lo contrario al else que es ok
		if(empty($libro)) {
			  header("HTTP/1.1 404 No se encontraron libros");
			  header("Content-Type: application/xml");
			  
					 
		 } else {
			 //retorna el resultado que tenga la variable $usuario que es lo que tenga la base de datos
			 //propio formato xml
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
		//llama a la feuncion obtenerMateria() de la clase Crud() y le envia el parametro optenido
		//anterior mente pormedio del get
	   	$libro = $crud->obtenerLibro($id);
         
		//lo que devuelve materia es false entra al if y envia un error de estado de lo contrario se dirige al else
		
		if(empty($libro)) {
			$statusCode = 404;
			$libro = array('error' => 'No se encontrara!');
				
		}if ($libro->getId() == null){//verifica si lo que devuelve getSobreNome esta vacio entonces no se encontro la materia
			echo "error: libro no encontrada"; 
		}else { //envia los valores optenidos de la clase usuario y la funcion get con los datos
            $statusCode = 200;
            

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


	function InsertLibro($id, $nombre, $autor, $editorial, $categoria, $descripcion, $imagen){
		//hace referencia a la clase CrudUsuarios
	   $crud= new CrudLibros();
	   //verificar si ya existe el usuario
	   $exists = $crud->obtenerLibro($id);
	   if(($exists->getId() != null) ){
		$statusCode = 404;
		$exists = array('error' => 'Ya existe el libro!!');
		echo "Ya existe la Clave!!";
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
		   //contiene la funcion insertar que referencia de CRUD y le envia lo que resive de la url
		   $crud->insertar($libro);
		   echo "exito al insertar!!!";
	
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

        if(isset($decoded{'libro'}['id']) and isset($decoded{'libro'}['Nombre']) and
        isset($decoded{'libro'}['autor']) and isset($decoded{'libro'}['editorial']) and 
        isset($decoded{'libro'}['categoria']) and isset($decoded{'libro'}['descripcion']) and 
        isset($decoded{'libro'}['imagen'])
        ){
            header("HTTP/1.1 200 OK");
            //header("Content-Type: application/json");
            $this->insertLibro($decoded{'libro'}['id'],$decoded{'libro'}['Nombre'],
            $decoded{'libro'}['autor'],$decoded{'libro'}['editorial'],
            $decoded{'libro'}['categoria'],$decoded{'libro'}['descripcion'],$decoded{'libro'}['imagen']);
        } else{
            header("HTTP/1.1 404 Error al intentar insertar");
            header("Content-Type: application/json");
            echo "Error en variables o nulos ";
        }		
}

	function actualizarLibro($id, $nombre, $autor, $editorial, $categoria, $descripcion, $imagen){
		$crud= new CrudLibros();
			 //hace referencia a la clase usuario para utilizar sus funciones
			$libro = new Libro();
			$libro->setId($id);
		    $libro->setNombre($nombre);
			$libro->setAutor($autor);
			$libro->setEditorial($editorial);
			$libro->setCategoria($categoria);
			$libro->setDescripcion($descripcion);
			$libro->setImagen($imagen);
			//contiene la funcion insertar que referencia de CRUD y le envia lo que resive de la url
			$result = $crud->actualizar($libro);
          /*  if(empty($result)) {
				$statusCode = 404;
				echo "Error al actualizar!!!!";	
			}else { //envia los valores optenidos de la clase usuario y la funcion get con los datos
				$statusCode = 200;
				echo "exito al Actualizar!!!";				
            }*/
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
			$this->actualizarLibro($decoded{'libro'}['id'],$decoded{'libro'}['Nombre'],
            $decoded{'libro'}['autor'],$decoded{'libro'}['editorial'],
            $decoded{'libro'}['categoria'],$decoded{'libro'}['descripcion'],$decoded{'libro'}['imagen']);
	
}


	function DeleteLibro($id){
		$crud= new CrudLibros();
			 //hace referencia a la clase usuario para utilizar sus funciones
			$libro = new Libro();
			$libro->setId($id);
			//contiene la funcion insertar que referencia de CRUD y le envia lo que resive de la url
			$result = $crud->eliminar($libro);
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
			$this->DeleteLibro($decoded{'libro'}['id']);
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