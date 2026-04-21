<?php
    // Solo necesitas llegar al header.php una vez.
    require_once(__DIR__ . '/../../routes/header.php');

    //Obtener datos
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];

    //Consulta SQL para actualizar el usuario
    $sqlupdate = "UPDATE instructors SET id='$id', username='$username',
        password='$password', email='$email', name='$name', 
        lastname='$lastname' WHERE id='$id'";
    
    if ($cone->query($sqlupdate) === TRUE) {
        echo "Instructor actualizado correctamente";
    }
    else {
        echo "Error al actualizar instructor: " . $cone->error;
    }

    $cone ->close();
?>