<?php
    // Funciones
    include 'model/functions/functions.php';

    // Si se encuentra un usuario logueado
    if (isset($_SESSION['user'])) {
        header('Location: /logout');
    }
    
    // Template
    $tpl = file_get_contents('views/templates/index.html');
    
    // Header
    $tpl = str_replace('{{header}}',getComponents('header_index'), $tpl);
    
    // Footer
    $tpl = str_replace('{{footer}}',getComponents('footer'), $tpl);

    // Mostramos el Template
    echo $tpl
?>