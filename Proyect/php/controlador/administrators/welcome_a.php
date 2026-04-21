<?php
    session_start();
    if (isset ($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $id = $_SESSION['id'];
        $name = $_SESSION['name'];
        $lastname = $_SESSION['lastname'];
        $password = $_SESSION['password'];
    }
    else {
        header ("Location: index.html");
        exit();
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <title> Welcome </title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav class="navbar">
            <strong>Usuario:</strong> <?php echo $username; ?>
            <strong>Correo electrónico:</strong> <?php echo $email; ?>
            <strong>Nombre:</strong> <?php echo $name; ?>
            <strong>Apellido:</strong> <?php echo $lastname; ?>
            <strong>Contraseña:</strong> <?php echo $password; ?>
            <a href='logout.php'> Cerrar sesion</a>
        </nav>
        <h1> Bienvenido, <?php echo $username; ?> <?php echo $name; ?> <?php echo $lastname; ?>. </h1>
        <p> Tu correo es <i><?php echo $email; ?><i>, tu contraseña es: <?php echo $password; ?>. </p>
    </body>
</html>