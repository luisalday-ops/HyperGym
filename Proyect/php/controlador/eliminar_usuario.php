<?php
    session_start();
    include("conexion.php");

    //Obtener datos
    $id = $_POST['id'];

    //Consulta SQL para eliminar el usuario
    $sqldelete = "DELETE FROM user WHERE id='$id'";

    if ($cone->query($sqldelete) === TRUE) {
        echo "Usuario eliminado correctamente";
    }
    else {
        echo "Error al eliminar usuario: " . $cone->error;
    }

    $cone ->close();
?>