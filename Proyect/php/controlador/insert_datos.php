<?php
    session_start();
    //Declaracion de variables para cone
    $servername = "localhost";
    $user = "root";
    $pass = '';
    $database = 'test_db';

    //Ingreso a la base de datos
    $cone = new mysqli($servername, $user, $pass, $database);
    if ($cone->connect_error){
        die ('Error de conexion' - $cone->connect_error);
    }

    //Obtener datos
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];

    //Consulta SQL para actualizar el usuario
    $sqlinsert = "INSERT INTO user (username, password, email, name, lastname) VALUES ('$username', '$password', '$email', '$name', '$lastname')";
    
    if ($cone->query($sqlinsert) === TRUE) {
        echo "Usuario agregado correctamente";
        echo "<br><br>";
        echo "<a href='crud.php'> Volver al CRUD </a>";
    }
    else {
        echo "Error al agregar usuario: " . $cone->error;
    }

    $cone ->close();
?>