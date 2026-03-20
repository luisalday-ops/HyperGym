<?php
    session_start();
    include("conexion.php");

    $username = $_POST['username'];
    $password = $_POST['password'];

    //Consulta SQL para verificar el usuario y contraseña
    $sql = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = $cone->query($sql);

    if ($result->num_rows > 0) {
        //Inicion de sesion exitoso
        echo "Hola y bienvenido";
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['password'] = $row['password'];
        header ('Location: welcome.php');
        exit();
    }
    else {
        echo "Inicio de sesion fallida. <a href='index.html'> Intentar de nuevo </a>";
    }

    $cone ->close();
?>