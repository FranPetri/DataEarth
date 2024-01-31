<?php 
	// Iniciamos Sesion
	session_start();

	// Declaramos como JSON
	header("Content-Type: application/json");

	include '../../model/db/dbTools.php';

	// Declaramos la Base de Datos
	$db = new mysqli(HOST,USER,PASSWORD,DB);
	
	// Tomamos el usuario por GET y lo instanciamos como variable
	$user = $_GET['user'];

	// Sentencia para tomar los datos del usuario
	$ssql = "SELECT * FROM `usuarios` WHERE `nick` = '$user'";		
	
	// Realizamos la query a la base de datos
	$response = $db->query($ssql);

	// Transformamos $response en un array
	$data_user = $response->fetch_all(MYSQLI_ASSOC);

	// Mostramos $data_user como JSON
	echo json_encode($data_user);
 ?>