<?php
// 1. Iniciar sesión si no ha sido iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * 2. Definir la ruta raíz del proyecto de forma absoluta.
 * __DIR__ nos da la ruta de 'php/routes'. 
 * Subimos dos niveles para llegar a 'Proyect/'.
 */
define('ROOT_PATH', realpath(__DIR__ . '/../../') . DIRECTORY_SEPARATOR);

// 3. Incluir la conexión usando la constante ROOT_PATH
// Esto garantiza que siempre encuentre el archivo desde cualquier vista.
$conexion_file = ROOT_PATH . 'php' . DIRECTORY_SEPARATOR . 'routes' . DIRECTORY_SEPARATOR . 'conexion_proj.php';

if (file_exists($conexion_file)) {
    require_once($conexion_file);
} else {
    die("Error fatal: No se pudo cargar el archivo de conexión en: " . $conexion_file);
}

// 4. (Opcional) Verificación de seguridad global
// Si quieres que todas las páginas requieran login, descomenta esto:
/*
if (!isset($_SESSION['username'])) {
    header("Location: " . "/WebApplications/Proyect/index.html");
    exit();
}
*/
?>