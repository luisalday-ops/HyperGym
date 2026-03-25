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
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];

    //Consulta SQL para actualizar el usuario
    $sqlupdate = "UPDATE user SET id='$id', username='$username',
        password='$password', email='$email', name='$name', 
        lastname='$lastname' WHERE id='$id'";
    
    if ($cone->query($sqlupdate) === TRUE) {
        echo "Usuario actualizado correctamente";
    }
    else {
        echo "Error al actualizar usuario: " . $cone->error;
    }

    $cone ->close();
?>