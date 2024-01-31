<?php 
	// Funciones
	include 'model/functions/functions.php';

	// Template
	$tpl = file_get_contents('views/templates/control.html');

	// Header
	$tpl = str_replace('{{header}}',getComponents('header_panel'),$tpl);
	
	if (isset($_SESSION['apodo'])) {
		// Si se encuentra el nombre del chip se incluye un boton del mismo
		$tpl = str_replace('{{section}}','<i class="fa-solid fa-microchip" style="color: #6ECCAF; margin:10px;"></i> '.strtoupper($get_url[0]).'<button class="pd5 m15 br5 back_green color_blue2 bornone fs20 tango">'.$_SESSION['apodo'].'</button>',$tpl);
	}else{
		// Si no se muestra la seccion solamente
		$tpl = str_replace('{{section}}','<i class="fa-solid fa-microchip" style="color: #6ECCAF; margin:10px;"></i> '.strtoupper($get_url[0]),$tpl);
	}

	// Si el usuario no esta logueado
	if (empty($_SESSION['user'])) {
		header('Location: /');
	}

	// Si el usuario es Socio y no tiene Chip
	if ($_SESSION['chipid'] == 0 && $_SESSION['socio']) {
		$tpl = str_replace('{{general}}', getComponents('register_chip'),$tpl);
	}
	
	// Si el usuario no es Socio
	if (!$_SESSION['socio']) {
		$tpl = str_replace('{{general}}', getComponents('control_not_socio'),$tpl);
	}

	// Control si el usuario es Socio y tiene Chip
	if ($_SESSION['chipid'] != 0) {
		$tpl = str_replace('{{general}}', getComponents('general'),$tpl);
	}

	// Footer
	$tpl = str_replace('{{footer}}',getComponents('footer_panel'),$tpl);
	
	// Usuario
	$tpl = str_replace('{{usuario}}',$_SESSION['user'],$tpl);

	if (isset($_POST['btnAccept'])) {
		// Al presionar el boton para registrar el chip
		$query_user = query("SELECT `chip_id` FROM `usuarios` WHERE `nick` = '".$_SESSION['user']."'",true);
		
		if ($query_user[0]['chip_id'] == $_POST['chipid']) {
			// Registramos el Chip relacionado al usuario
			$_SESSION['chipid'] = registerChip($_SESSION['user'],$_POST['chipid'],$_POST['apodo']);

			// Tomamos el apodo del Chip que le asigno el usuario
			$_SESSION['apodo'] = query("SELECT `apodo` FROM `sensor` WHERE `chipid` = '".$_SESSION['chipid']."'",true);
			header('Location: /control');	
		}else{
			// Si el chip no esta registrado
			$tpl = str_replace('{{alert}}','Numero de Chip no registrado en la Base de Datos',$tpl);
		}
	}

	// Cargamos la alerta vacia
	$tpl = str_replace('{{alert}}','',$tpl);

	// Usuario en el menu
	$tpl = str_replace('{{header_user}}',$_SESSION['user'],$tpl);

	// Mostramos el Template
	echo($tpl);
 ?>	