<?php
    // Funciones del Usuario
    include 'model/functions/userTools.php';

    // Instanciamos el mensaje
    $message = "";
    
    if (isset($_POST['btnAccept'])) {
        // Al presionar el boton regitramos el usuario y lo instanciamos
        $user = registerUser($_POST['nick'],$_POST['email'],$_POST['pass']);
        if ($user == 3) {
            // Si el usuario ha sido registrado correctamente, redirige a Login
            header('Location: /login');
        }
        if ($user == 2) {
            // Si el email del usuario ya esta registrado, informa al usuario
            $message = "Mail ya registrado";
        }
        if ($user == 1) {
            // Si el nombre del usuario ya esta registrado, informa al usuario
            $message = "Nombre de Usuario ya registrado";
        }
    }
    
    // Template
    $tpl = file_get_contents('views/templates/register.html');
    
    // Header
    $tpl = str_replace('{{header}}',getComponents('header'),$tpl);
    
    // Footer
    $tpl = str_replace('{{footer}}',getComponents('footer'),$tpl);
    
    // Mensaje
    $tpl = str_replace('{{message}}',$message,$tpl);

    // Mostramos el Template
    echo $tpl;
?>
