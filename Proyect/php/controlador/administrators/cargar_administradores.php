<?php
    //Incluimos la conexion a la base de datos
    //DIR es para obtener la ruta absoluta del archivo actual, y luego navegamos hacia el archivo de conexión.
    // Solo necesitas llegar al header.php una vez.
    require_once(__DIR__ . '/../../routes/header.php');

    //Consulta SQL para verificar el usuario y contraseña
    $sql = "SELECT * FROM administrators";
    $result = $cone->query($sql);
    
    if ($result && $result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['username']}</td>
            <td>{$row['password']}</td>
            <td>{$row['email']}</td>
            <td>{$row['schedules']}</td>
            <td>{$row['rol']}</td>
            <td>{$row['name']}</td>
            <td>{$row['lastname']}</td>
            <td>
                <button onclick=\"mostrarEditarAdministrador({$row['id']},
                '{$row['username']}', '{$row['name']}',
                '{$row['lastname']}', '{$row['email']}')\">
                    Editar
                </button>
                <button onclick=\"mostrarEliminarAdministrador({$row['id']})\">
                    Eliminar
                </button>
            </td>
        </tr>";
        }
    }
    else {
        echo "<tr><td colspan='9'> No hay administradores </td></tr>";
    }

    $cone ->close();
?>