<?php
    // Solo necesitas llegar al header.php una vez.
    require_once(__DIR__ . '/../../routes/header.php');

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];

    //Consulta SQL para verificar el usuario y contraseña
    $sqlinsert = "INSERT INTO instructors (id, username, password, email, name, lastname) VALUES (NULL,'$username','$password','$email','$name','$lastname')";
    $result = $cone->query($sqlinsert);

    if ($result) {
        //Inicion de sesion exitoso
        echo "Hola y bienvenido";
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['lastname'] = $row['lastname'];
        $_SESSION['password'] = $row['password'];
        header ('Location: welcome_a.php');
        exit();
    }
    else {
        echo "Inicio de sesion fallida. <a href='index.html'> Intentar de nuevo </a>";
    }

    $cone ->close();
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title> Registro de usuario </title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <form action = "formulario.php" method = "post">
            <label for="username">
                Usuario: <input type="text" name="username">
            </label>
            <br><br>
            <label for="password">
                Contraseña: <input type="password" name="password">
            </label>
            <br><br>
            <label for="email">
                Correo electrónico: <input type="email" name="email">
            </label>
            <br><br>
            <label for="name">
                Nombre: <input type="text" name="name">
            </label>
            <br><br>
            <label for="lastname">
                Apellido: <input type="text" name="lastname">
            </label>
            <br><br>
            <button type="submit">
                Registrarme
            </button>
        </form>
    </body>
</html>