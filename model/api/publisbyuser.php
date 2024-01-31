<?php 
	// Iniciamos Sesion
	session_start();

	// Declaramos como JSON
	header("Content-Type: application/json");

	include '../../model/db/dbTools.php';

	// Declaramos la Base de Datos
	$db = new mysqli(HOST,USER,PASSWORD,DB);
			
	// Sentencia para tomar las publicaciones del usuario
	$ssql = "SELECT * FROM `publicaciones` WHERE `user` = '".$_SESSION['user']."'";

	// Realizamos la query a la base de datos
	$response = $db->query($ssql);
		
	// Transformamos $response en un array
	$data_user = $response->fetch_all(MYSQLI_ASSOC);

	// Mostramos $data_user como JSON
	echo json_encode($data_user);
 ?>