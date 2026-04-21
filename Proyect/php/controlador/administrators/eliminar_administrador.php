<?php
    // Solo necesitas llegar al header.php una vez.
    require_once(__DIR__ . '/../../routes/header.php');

    //Obtener datos
    $id = $_POST['id'];

    //Consulta SQL para eliminar el usuario
    $sqldelete = "DELETE FROM administrators WHERE id='$id'";

    if ($cone->query($sqldelete) === TRUE) {
        echo "Administrador eliminado correctamente";
    }
    else {
        echo "Error al eliminar administrador: " . $cone->error;
    }

    $cone ->close();
?>