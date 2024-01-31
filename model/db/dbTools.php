<?php 
    // Credenciales para la Base de Datos
    require 'credentials.php';

    // Funcion para la Conexion a la Base de Datos
    function connectDB(){
        // Instanciamos la Clase
        $conexion = new mysqli(HOST,USER,PASSWORD,DB);
        if(!$conexion){
            // Si alguno de los parametros es erroneo informa
            echo('<p style="font-size:5rem;color:red">ERROR CON LA CONEXION DE LA BASE DE DATOS</p>');
            exit;
        }
        return $conexion;
    }

    // Funcion para realizar querys a la base de datos
    // $sentence -> Sentencia SQL, $show -> Mostrar el Error True/False
    function query($sentence,$show){
        // Conexion a la Base de Datos
        $db = connectDB();

        // Realizamos para query con la sentencia pasada por parametro
        $response = $db->query($sentence);

        if($db->errno){
            // Si la sentencia es erronea verificar si se mostrara el error
            if($show){
                // Si $show es True, mostrar el error
                echo('<p style="font-size:5rem;color:red">HAY UN ERROR EN LA SENTENCIA SQL</p>');
                echo $db->error;
            }
            return false;
        }
        if($response !== true){
            // Si la sentencia retorna, transformar $response en un array y retornarlo
            $result = $response->fetch_all(MYSQLI_ASSOC);
            return $result;
        }
        // Si $response es True, retornar -3
        return -3;
    }

?>