<?php 
	// Iniciamos Sesion
	session_start();

	// Declaramos como JSON
	header("Content-Type: application/json");

	include '../../model/db/dbTools.php';

	// Declaramos la base de datos
	$db = new mysqli(HOST,USER,PASSWORD,DB);
	
	if (isset($_GET['page'])) {
		// Declaarmos la cantidad de paginas tomada por GET en Int
		$page = intval($_GET['page']);
		
		// Transformamos la cantidad de paginas en una menos * tres
		$page = ($page-1)*3;

		// Sentencia para tomar las publcaciones como limite 3 por pagina
		$ssql = "SELECT * FROM `publicaciones` ORDER BY 'fechaPubli' DESC LIMIT $page,3";		
	}

	if (isset($_GET['user'])) {
		// Declaramos el usuario por GET
		$user = $_GET['user'];

		// Sentencia para tomar todas las publicaciones de un usuario en orden por fecha descendiente
		$ssql = "SELECT * FROM `publicaciones` WHERE `user` = '$user'  ORDER BY 'fechaPubli' DESC";
	}
		
	// Realizamos la query a la base de datos
	$response = $db->query($ssql);
	
	// Tranformamos $response en un array 
	$data_user = $response->fetch_all(MYSQLI_ASSOC);

	// Mostramos $data_user como JSON
	echo json_encode($data_user);
 ?>