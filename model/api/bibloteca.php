<?php 
	// Iniciamos Sesion
	session_start();

	// Declaramos como JSON
	header("Content-Type: application/json");

	include '../../model/db/dbTools.php';

	// Declaramos la base de datos
	$db = new mysqli(HOST,USER,PASSWORD,DB);

	// Tomamos todos los datos de las plantas
	$ssql = "SELECT * FROM `plantas`";

	// Realizamos la query a la base de datos
	$response = $db->query($ssql);
		
	// Transformamos $response en un array 
	$response = $response->fetch_all(MYSQLI_ASSOC);

	// Mostramos $response como un json
	echo json_encode($response);
 ?>