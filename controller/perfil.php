<?php 
	// Funciones
	include 'model/functions/functions.php';
	
	// Si el usuario no esta logueado
	if (empty($_SESSION['user'])) {
		header('Location: /');
	}

	if (isset($_POST['btnPubli'])) {
		// Al presionar el boton creamos una publicacion y reiniciamos la vista
		createPubli($_SESSION['user'],$_POST['title_publi'],$_FILES['image_publi'],$_POST['content_publi']);
		header('Location: /perfil');	
	}

	if (isset($_POST['btnPubliEdited'])) {
		// Al presionar el boton, se edita la publicacion y se reinicia la vista
		editPubli($_POST['id_publi'],$_POST['title_edit_publi'],$_POST['content_edit_publi']);
		header('Location: /perfil');
	}

	if (isset($_POST['btnPubliDeleted'])) {
		// Al presionar el boton se elimina la publicacion y se reinicia la vista
		deletePubli($_POST['id_publi']);
		header('Location: /perfil');
	}
	
	// Template
	$tpl = file_get_contents('views/templates/perfil.html');

	// Header
	$tpl = str_replace('{{header}}',getComponents('header_panel'), $tpl);
	
	// Seccion
	$tpl = str_replace('{{section}}','<i class="fa-solid fa-user" style="color: #6ECCAF; margin:10px;"></i>'.strtoupper($get_url[0]),$tpl);
	
	// Footer
	$tpl = str_replace('{{footer}}',getComponents('footer_panel'), $tpl);

	// Vista del perfil
	$tpl = str_replace('{{perfil}}',getComponents('user_perfil'),$tpl);

	// Usuario
	$tpl = str_replace('{{user_name}}',$_SESSION['user'],$tpl);

	// Ventana de Publicacion
	$tpl = str_replace('{{windowPubli}}',getComponents('window_publi'),$tpl);
	
	// Formulario para añadir publicacion
	$tpl = str_replace('{{addPubli}}',getComponents('/forms_publis/form_add_publi'),$tpl);

	// Ventana de edicion de publicacion
	$tpl = str_replace('{{windowEditPubli}}',getComponents('window_edit_publi'),$tpl);
	
	// Formulario para editar publicaciones
	$tpl = str_replace('{{editPubli}}',getComponents('/forms_publis/form_edit_delete_publi'),$tpl);
	
	// Usuario en el menu
	$tpl = str_replace('{{header_user}}',$_SESSION['user'],$tpl);
		
	// Mostramos el Template
	echo $tpl; 
?>