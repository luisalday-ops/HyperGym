<?php
    // Solo necesitas llegar al header.php una vez.
    require_once(__DIR__ . '/../../routes/header.php');

    // Verificar que se reciba el id
    if(isset($_GET['id'])){

        $id = $_GET['id'];

        $sql = "SELECT * FROM user WHERE id='$id'";
        $resultado = $conn->query($sql);

        if($resultado->num_rows > 0){
            $row = $resultado->fetch_assoc();
        } else {
            echo "Usuario no encontrado";
            exit();
        }

    } else {
        echo "ID no recibido";
        exit();
    }
    
    $cone ->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuario</title>
</head>
    <body>

    <h2>Editar Usuario</h2>

    <form action="guardar_edicion_usuario.php" method="POST">

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label>Usuario:</label><br>
        <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
        <br><br>

        <label>Password:</label><br>
        <input type="text" name="password" value="<?php echo $row['password']; ?>" required>
        <br><br>

        <button type="submit">Guardar Cambios</button>

    </form>

    <br>
    <a href="crud.php">Volver</a>

    </body>
</html>