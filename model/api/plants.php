<?php 
	// Iniciamos Sesion
	session_start();

	// Declaramos como JSON
	header("Content-Type: application/json");

	include '../../model/db/dbTools.php';

	// Declaramos la Base de Datos
	$db = new mysqli(HOST,USER,PASSWORD,DB);

	if (isset($_GET['cant'])) {
		// Transformamos la cantidad de filas tomada por GET en Int
		$cant = intval($_GET['cant']);

		// Sentencia para tomar los datos de los registros teniendo la cantidad declarada
		$ssql = "SELECT `idLectura`,`chipid`,`fechaHora`,`hume_amb`,`tmp_amb`,`hume_ter`,`tmp_ter`,`luz_stat` FROM `sensores` WHERE `chipid` = ".$_SESSION['chipid']." ORDER BY `idLectura` DESC LIMIT $cant"; //$cant o 1
	}
	
	if (empty($_GET)) {
		// Si no se encuentra nada por GET, declarar la sentencia para un registro
		$ssql = "SELECT `idLectura`,`chipid`,`fechaHora`,`hume_amb`,`tmp_amb`,`hume_ter`,`tmp_ter`,`luz_stat` FROM `sensores` WHERE `chipid` = ".$_SESSION['chipid']." ORDER BY `idLectura` DESC LIMIT 1";
	}
	// Realizamos la query a la base de datos
	$response = $db->query($ssql);
		
	// Transformamos $response en un array
	$data_user = $response->fetch_all(MYSQLI_ASSOC);

	// Mostramos $data_user como JSON
	echo json_encode($data_user);
 ?>