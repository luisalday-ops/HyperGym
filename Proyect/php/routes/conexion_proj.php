<?php
    //Declaracion de variables para cone
    $servername = "localhost";
    $user = "root";
    $pass = '';
    $database = 'hypergym';

    //Ingreso a la base de datos
    $cone = new mysqli($servername, $user, $pass, $database);
    if ($cone->connect_error){
        // Usamos el punto (.) para concatenar el mensaje de error.
        die ('Error de conexion: ' . $cone->connect_error);
    }
?>