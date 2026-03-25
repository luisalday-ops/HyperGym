<?php
    session_start();
    //Declaracion de variables para cone
    $servername = "localhost";
    $user = "root";
    $pass = '';
    $database = 'test_db';

    //Ingreso a la base de datos
    $cone = new mysqli($servername, $user, $pass, $database);
    if ($cone->connect_error){
        die ('Error de conexion' - $cone->connect_error);
    }

    //Consulta SQL para verificar el usuario y contraseña
    $sql = "SELECT * FROM user";
    $result = $cone->query($sql);
    
    if ($result->num_rows > 0){
        while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['username']}</td>
            <td>{$row['password']}</td>
            <td>{$row['email']}</td>
            <td>{$row['name']}</td>
            <td>{$row['lastname']}</td>
            <td>
                <button onclick=\"mostrarEditarUsuario({$row['id']},
                '{$row['username']}', '{$row['name']}',
                '{$row['lastname']}', '{$row['email']}')\">
                    Editar
                </button>
                <button onclick=\"mostrarEliminarUsuario({$row['id']})\">
                    Eliminar
                </button>
            </td>
        </tr>";
        }
    }
    else {
        echo "<tr><td colspan='7'> No hay usuarios </td></tr>";
    }

    $cone ->close();
?>