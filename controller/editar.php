<?php 
	// Funciones
	include 'model/functions/userTools.php';
	
	// Si el usuario no esta logueado
	if (empty($_SESSION['user'])) {
		header('Location: /');
	}

	// Si se cancela la edicion
	if (isset($_POST['btnCancel'])) {
		header('Location: /perfil');
	}	

	if (isset($_POST['btnDeleteUser'])) {
		// Al presionar el boton se elimina el usuario y se redirige a Landing
		deleteUser($_SESSION['user']);
		header('Location: /');
	}

	// Template
	$tpl = file_get_contents('views/templates/perfil.html');

	// Header
	$tpl = str_replace('{{header}}',getComponents('header_panel'), $tpl);
	
	// Seccion en el header
	$tpl = str_replace('{{section}}','<i class="fa-solid fa-pen-to-square" style="color: #6ECCAF; margin:10px;"></i>'.strtoupper($get_url[0]),$tpl);
	
	// Footer
	$tpl = str_replace('{{footer}}',getComponents('footer_panel'), $tpl);

	// Tpl para editar el perfil
	$tpl = str_replace('{{perfil}}',getComponents('user_editar_perfil'),$tpl);

	// Nombre del usuario
	$tpl = str_replace('{{user_name}}',$_SESSION['user'],$tpl);

	// Usuario en el menu
	$tpl = str_replace('{{header_user}}',$_SESSION['user'],$tpl);

	// Ventana para eliminar usuario
	$tpl = str_replace('{{windowDelete}}',getComponents('window_delete'),$tpl);
	
	// Formulario para eliminar usuario
	$tpl = str_replace('{{addPubli}}',getComponents('forms_publis/form_delete_user'),$tpl);
	
	if (isset($_POST['btnEdit'])) {
		// Al presionar el boton se edita el usuario
		$check_edit = editUser($_SESSION['user'],$_POST['apodo_edit'],$_FILES['avatar_edit'],$_FILES['banner_edit']);
		
		// Si no se ingresa ningun dato
		if (!$check_edit) {
			$tpl = str_replace('{{alert}}','No se ha ingresado ningun dato',$tpl);	
		}

		// Si las imagenes no son validas
		if ($check_edit == 3) {
			$tpl = str_replace('{{alert}}','Imagenes No Validas!',$tpl);	
		}

		// Si se valida la edicion, se redirige al Landing
		if ($check_edit === true) {
			header('Location: /');	
		}
	}

	// Cargamos la Alerta vacia
	$tpl = str_replace('{{alert}}','',$tpl);	

	// Mostramos el Template
	echo $tpl; 
?>