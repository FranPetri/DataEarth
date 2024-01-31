<?php 
	// Iniciamos Sesion
	session_start();

	// Deslogueamos la Sesion
	session_unset();

	// Se destruye la Sesion
	session_destroy();

	// Redirigimos a Landing
	header('Location: /');
?>