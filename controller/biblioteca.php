<?php 
	// Controlador de la vista de Bibloteca

	// Si no hay un usuario logueado 
	if (empty($_SESSION['user'])) {
		header('Location: /');
	}
	
	// Funciones
	include 'model/functions/functions.php';

	// Template
	$tpl = file_get_contents('views/templates/biblioteca.html');
	
	// Header
	$tpl = str_replace('{{header}}',getComponents('header_panel'),$tpl);

	// Seccion que se indicara en el Header
	$tpl = str_replace('{{section}}','<i class="fa-solid fa-leaf" style="color: #6ECCAF; margin:10px;"></i>'.strtoupper($get_url[0]),$tpl);

	if (isset($_POST['validPlants'])) {	
		// Si el usuario es el admin e ingresa a la seccion de validar plantas
		$tpl = str_replace('{{biblioteca}}',getComponents('valid_plants'),$tpl);
	}else{
		// Si el usuario no es administrador mostrar la bibloteca
		$tpl = str_replace('{{biblioteca}}',getComponents('plantCard'),$tpl);
	}


	if ($_SESSION['user'] == 'root') {
		// Si el usuario es el admin incluir el boton de validar plantas
		$tpl = str_replace('{{validPlants}}','<form method="POST" class="h50 dflex aic jcc"><input class=" h100p bornone back_green color_blue2 tango fs20 br10 pd5" type="submit" name="validPlants" value="Validar Plantas"></form>',$tpl);
	}else{
		// Si el usuario no es admin no incluir el boton de validar plantas
		$tpl = str_replace('{{validPlants}}','',$tpl);
	}

	// Ventana de Añadir plantas
	$tpl = str_replace('{{windowAddPlanta}}',getComponents('window_publi'),$tpl);

	// Formulario para añadir las plantas
	$tpl = str_replace('{{addPubli}}',getComponents('forms_publis/form_add_planta'),$tpl);
	
	// Footer
	$tpl = str_replace('{{footer}}',getComponents('footer_panel'),$tpl);
	
	// Usuario en el menu
	$tpl = str_replace('{{header_user}}',$_SESSION['user'],$tpl);
	
	if (isset($_POST['btnPlant'])) {
		// Al presionar el boton se incluye la planta
		$plant = addPlant($_SESSION['user'],$_POST['plant_name'],$_FILES['plant_image']);		
	}	

	if (isset($_POST['btnValid'])) {
		// Al presionar el boton se valida la planta
		$id_plant = $_POST['plant_id'];
		query("UPDATE `plantas` SET `validate` = 1 WHERE `id` = '$id_plant'",true);
	}

	if (isset($_POST['btnNotValid'])) {
		// Al presionar el boton no se valida la planta
		$id_plant = $_POST['plant_id'];
		query("DELETE FROM `plantas` WHERE `id` = '$id_plant'",true);	
	}

	// Mostramos el Template
	echo $tpl;
 ?>