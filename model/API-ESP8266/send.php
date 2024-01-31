<?php
	session_start();
	include '../../model/db/dbTools.php';

	header("Content-Type: application/json");
	
	// Hay variables en el vector de POST?
	if(count($_POST)>0){
		var_dump($_POST);
		// Respuesta para el esp8266
		$body = array('errno' => 0,
				'error' => "Datos recibidos y almacenados.");

		// Sección para capturar las variables del vector de POST
		// y enviarlas a un tabla de una base de datos o un archivo de texto,
		// tambien se puede colocar en la respuesta Json variables con
		// el estado de algún actuador.
		//=============================

		$db = connectDB();
		$res = $db->query("INSERT INTO `sensores` (`chipid`, `hume_amb`, `tmp_amb`, `hume_ter`, `tmp_ter`, `luz_stat`, `last_agua`, `fechaHora`) VALUES ('".$_POST["chipid"]."', '".$_POST["hume_amb"]."', '".$_POST["tmp_amb"]."', '".$_POST["hume_ter"]."', '".$_POST["tmp_ter"]."', '".$_POST["luz_stat"]."', '".$_POST["last_agua"]."',  CURRENT_TIMESTAMP); ");

		// Recorremos el vector de post (para DEBUG, así vemos los datos en la terminal del esp8266)
		foreach ($_POST as $item => $value) {
			// agrega a la respuesta la variable y su valor
			$body[$item] = $value;	
		}

		//cambiamos el estado del led
		$body["led"] = 1;
	
	// No hay variables en el vector de POST
	}else{ 
		// Respuesta para el esp8266
		$body = array('errno' => 1,
				'error' => "No hay datos por POST.");
	}

	// muestra la respuesta
	echo json_encode($body);
 ?>