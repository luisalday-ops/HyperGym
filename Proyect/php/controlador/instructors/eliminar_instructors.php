<?php
    // Solo necesitas llegar al header.php una vez.
    require_once(__DIR__ . '/../../routes/header.php');

    //Obtener datos
    $id = $_POST['id'];

    //Consulta SQL para eliminar el usuario
    $sqldelete = "DELETE FROM instructors WHERE id='$id'";

    if ($cone->query($sqldelete) === TRUE) {
        echo "Instructor eliminado correctamente";
    }
    else {
        echo "Error al eliminar instructor: " . $cone->error;
    }

    $cone ->close();
?>