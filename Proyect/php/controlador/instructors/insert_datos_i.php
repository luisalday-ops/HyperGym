<?php
    // Solo necesitas llegar al header.php una vez.
    require_once(__DIR__ . '/../../routes/header.php');

    //Obtener datos
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];

    //Consulta SQL para actualizar el usuario
    $sqlinsert = "INSERT INTO administrators (username, password, email, name, lastname) VALUES ('$username', '$password', '$email', '$name', '$lastname')";
    
    if ($cone->query($sqlinsert) === TRUE) {
        echo "Instructor agregado correctamente";
        echo "<br><br>";
        echo "<a href='crud_instructors.php'> Volver al CRUD </a>";
    }
    else {
        echo "Error al agregar instructor: " . $cone->error;
    }

    $cone ->close();
?>