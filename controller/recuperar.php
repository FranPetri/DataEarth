<?php 
	// Funciones
	include 'model/functions/userTools.php';

	// Template
	$tpl = file_get_contents('views/templates/recuperar.html');
	
	// Footer
	$tpl = str_replace('{{footer}}',getComponents('footer'),$tpl);

	if (isset($_POST['btnRecover'])) {
		// AL presionar el boton se carga el formulario para ingresar la nueva contraseña
		$tpl = str_replace('{{form}}',getComponents('forms_publis/form_pass'),$tpl);
		
		// Instanciamos la sesion de email
		$email = $_SESSION['email'];

		// Instanciamos la contraseña y la confirmacion
		$pass = $_POST['pass'];
		$check = $_POST['check_pass'];

		if ($pass == $check) {
			// Si las contraseñas son iguales, cargarlas en la base de datos y redirige a logout
			query("UPDATE `usuarios` SET `pass`='$pass' WHERE `email` = '$email'",true);
			header('Location: /logout');
		}else{
			// Si las contraseñas son diferentes informar al usuario
			$tpl = str_replace('{{alert_pass}}','Contraseñas diferentes!',$tpl);
		}
	}else{
		// Si no se ha cargado el mail, cargar el formulario para ingresar el mail
		$tpl = str_replace('{{form}}',getComponents('forms_publis/form_email'),$tpl);
	}


	if (isset($_POST['btnAccept'])) {
		
		// Al presioanar el mail instanciar la sesion de email
		$_SESSION['email'] = $_POST['email'];
		$email = $_SESSION['email'];

		if (query("SELECT * FROM `usuarios` WHERE `email` = '$email'",true)) {
			// Si el email coincide con el de un usuario cargar el formulario para ingresar la contraseña
			$tpl = str_replace('{{form}}',getComponents('forms_publis/form_pass'),$tpl);
		}else{
			// Si el email no coincide volver a cargar el formulario para el email e informar al usuario
			$tpl = str_replace('{{form}}',getComponents('forms_publis/form_email'),$tpl);
			$tpl = str_replace('{{alert_email}}','Email Invalido',$tpl);
		}
	}
	
	// Cargar por predefinido el formulario para el email
	$tpl = str_replace('{{form}}',getComponents('forms_publis/form_email'),$tpl);

	// Cargar la alerta vacia
	$tpl = str_replace('{{alert_email}}','',$tpl);

	// Mostrar el Template
	echo $tpl;
 ?>