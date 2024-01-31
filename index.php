<?php
	// Principal de la App
	session_start();

	// Incluir la configuracion
	require 'config/configuration.php';

	// Asignar url del Index
	$index_url = '/'; //CAMBIAR

	$get_url = array_values( // Lo asigna como array
		array_filter( // Filtramos los espacios vacios
			explode('/',str_replace($index_url,'',$_SERVER['REQUEST_URI'])) // Explode de la URL
		)
	);

	$method = $_SERVER['REQUEST_METHOD']; // Declaramos el metodo de la App 

	if(isset($get_url[0])){ // Si encontramos la url del archivo
		if(file_exists('controller/'.$get_url[0].'.php')){  // Y existe el archivo
			include 'controller/'.$get_url[0].'.php'; // Mostramos el archivo
		}
		else{
			include 'controller/404.php'; // Si no mostramos 404
		}
	}
	else{
		include 'controller/landing.php'; // Si no mostramos la Landing
	}
?>