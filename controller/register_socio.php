<?php 
	// Funciones del Usuario
	include 'model/functions/userTools.php';

	// Template
	$tpl = file_get_contents('views/templates/register_socio.html');

	// Header
	$tpl = str_replace('{{header}}',getComponents('header_panel'),$tpl);
	
	// Usuario en el menu
	$tpl = str_replace('{{header_user}}',$_SESSION['user'],$tpl);
	
	// Seccion
	$tpl = str_replace('{{section}}','<i class="fa-solid fa-user" style="color: #6ECCAF; margin:10px;"></i>SER SOCIO',$tpl);
	
	// Footer
	$tpl = str_replace('{{footer}}',getComponents('footer_panel'),$tpl);

	if (isset($_POST['btnSocio'])) {
		// Al presionar el boton instanciamos las variables para el registra como socio y redirige a Panel
		$name = $_POST['name'];
		$apel = $_POST['apel'];
		$dire = $_POST['dire'];
		$dni = $_POST['dni'];
		query("UPDATE `usuarios` SET `socio`=1,`name`='$name',`apel`='$apel',`dire`='$dire',`dni`='$dni' WHERE `nick` = '".$_SESSION['user']."'",true);
		header('Location: /panel');
	}

	// Mostramos el Template
	echo $tpl;

 ?>