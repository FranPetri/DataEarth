<?php
	// Funciones del Usuario
	include 'model/functions/userTools.php';

	// Template
	$tpl = file_get_contents('views/templates/login.html');

	if (isset($_POST['btnAccept'])) {
		// Al presionar el boton se valida el usuario
		$user = validateUser($_POST['user'],$_POST['pass']);
		if ($user) {
			// Si el usuario es valido se registra la sesion y se redirige a Panel
			$_SESSION['user'] = $_POST['user'];
			header('Location: /panel');
		}else{
			// Si el usuario no es valido, mostramos el mensaje de error
			$tpl = str_replace('{{alert}}','Credenciales Incorrectas!',$tpl);
		}
	}

	// Cargamos la alerta vacia
	$tpl = str_replace('{{alert}}','',$tpl);

	// Header
    $tpl = str_replace('{{header}}',getComponents('header'), $tpl);

    // Footer
    $tpl = str_replace('{{footer}}',getComponents('footer'), $tpl);

    // Mostramos el Template
    echo $tpl
?>
