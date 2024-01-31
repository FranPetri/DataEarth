<?php 
	// Funciones
	include 'model/functions/functions.php';

	// Si no hay un usuario logueado
	if (empty($_SESSION['user'])) {
		header('Location: /');
	}

	// Base de Datos
	$db = connectDB();

	// Sentencia para capturar los datos del usuario
	$ssql = 'SELECT * FROM `usuarios` WHERE `nick` = "'.$_SESSION['user'].'"';

	// Datos del usuario
	$user_data = query($ssql,true);

	// ChipId relacionada al usuario
	$_SESSION['chipid'] = $user_data[0]['chip_id'];
	
	// Estado de Socio del usuario
	$_SESSION['socio'] = $user_data[0]['socio'];

	// Si el usuario es socio y tiene Chip
	if ($_SESSION['socio'] == 1 && $_SESSION['chipid'] != 0) {
		// Instanciamos la sesion de socio como True
		$_SESSION['socio'] = true;
		
		// Instanciamos la sesion de chip como el valor del dato del usuario
		$_SESSION['chipid'] = $user_data[0]['chip_id'];
		
		// Tomamos el apodo del chip
		$take_apodo = query("SELECT `apodo` FROM `sensor` WHERE `user` = '".$_SESSION['user']."'",true);
		

		if (count($take_apodo) > 0) {
			// Instanciamos el apodo
			$_SESSION['apodo'] = $take_apodo[0]['apodo'];
		}
	}
	
	// Template
	$tpl = file_get_contents('views/templates/panel.html');
	
	// Header
	$tpl = str_replace('{{header}}',getComponents('header_panel'),$tpl);
	
	// Seccion
	$tpl = str_replace('{{section}}','<i class="fa-solid fa-house" style="color: #6ECCAF; margin:10px;"></i>'.strtoupper($get_url[0]),$tpl);
	
	// Footer
	$tpl = str_replace('{{footer}}',getComponents('footer_panel'),$tpl);

	if ($_SESSION['user'] == 'root') {
		// Si el usuario es admin mostrar su bienvenida
		$tpl = str_replace('{{panel}}',getComponents('welcome_admin'),$tpl);
	}

	// Verificamos si el usuario es Socio y tiene chip
	if ($user_data[0]['socio'] && $user_data[0]['chip_id'] != 0) {
		// Si el usuario es socio
		// Daremos la Bienvenida de usuario Socio -------------------------
		$tpl = str_replace('{{panel}}',getComponents('socio_welcome'),$tpl);	
	}

	if ($user_data[0]['socio'] && $user_data[0]['chip_id'] == 0) {
		// Si el usuario es socio pero no tiene chip
		$tpl = str_replace('{{panel}}',getComponents('socio_welcome'),$tpl);
	}
	if (!$user_data[0]['socio']){
		// Si el usuario no es socio
		// Daremos la Bienvenida de usuario no Socio -----------------
		$tpl = str_replace('{{panel}}',getComponents('welcome'),$tpl);
	}

	// Usuario
	$tpl = str_replace('{{usuario}}',$_SESSION['user'],$tpl);

	// Usuario del Menu
	$tpl = str_replace('{{header_user}}',$_SESSION['user'],$tpl);
	
	// Mostramos el Template
	echo $tpl;
 ?>