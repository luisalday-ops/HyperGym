<?php
    // Solo necesitas llegar al header.php una vez, ya incluye lo necesario.
    require_once(__DIR__ . '/../../routes/header.php');

    //Obtener datos
    $id = $_POST['editId'];

    //Consulta SQL para eliminar el usuario
    $sqldelete = "DELETE FROM 'user' WHERE id=$id";

    if ($cone->query($sqldelete) === TRUE) {
        echo "Usuario eliminado correctamente";
    }
    else {
        echo "Error al eliminar usuario: " . $cone->error;
    }

    $cone ->close();
?>