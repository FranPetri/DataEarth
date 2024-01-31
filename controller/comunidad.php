<?php 
	
	// Si no hay un usuario logueado 
	if (empty($_SESSION['user'])) {
		header('Location: /');
	}
	
	// Funciones
	include 'model/functions/functions.php';

	if (isset($_POST['btnPubli'])) {
		// Al presionar el boton se incluye la publicacion y se reinicia la vista
		createPubli($_SESSION['user'],$_POST['title_publi'],$_FILES['image_publi'],$_POST['content_publi']);
		header('Location: /comunidad');
	}

	// Template
	$tpl = file_get_contents('views/templates/comunidad.html');

	// Header
	$tpl = str_replace('{{header}}',getComponents('header_panel'),$tpl);
	
	// Seccion que se indicara en el Header
	$tpl = str_replace('{{section}}','<i class="fa-solid fa-users" style="color: #6ECCAF; margin:10px;"></i>'.strtoupper($get_url[0]),$tpl);

	// Footer
	$tpl = str_replace('{{footer}}',getComponents('footer_panel'),$tpl);
	
	$tpl = str_replace('{{usuario}}',$_SESSION['user'],$tpl);
	
	// Ventana de Publicaciones
	$tpl = str_replace('{{windowPubli}}',getComponents('window_publi'),$tpl);

	// Formulario para añadir Publicaciones
	$tpl = str_replace('{{addPubli}}',getComponents('/forms_publis/form_add_publi'),$tpl);

	// Usuario en el menu
	$tpl = str_replace('{{header_user}}',$_SESSION['user'],$tpl);
	
	echo $tpl;
 ?>
