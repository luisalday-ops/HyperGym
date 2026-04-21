<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
include(__DIR__ . '/../../controlador/clientes/racha.php');

// Archivo para almacenar los datos (en producción usarías una base de datos)
$dataFile = 'streak_data.json';

// Función para leer los datos
function readStreakData() {
    global $dataFile;
    if (!file_exists($dataFile)) {
        return [
            'current_streak' => 0,
            'last_check' => null,
            'history' => []
        ];
    }
    $content = file_get_contents($dataFile);
    return json_decode($content, true);
}

// Función para guardar los datos
function saveStreakData($data) {
    global $dataFile;
    file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
}

// Obtener la fecha actual (sin hora)
$today = date('Y-m-d');
$response = [];

// Si es GET, solo devolver la racha actual
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data = readStreakData();
    $response = [
        'streak' => $data['current_streak'],
        'last_check' => $data['last_check']
    ];
    echo json_encode($response);
    exit;
}

// Si es POST, procesar la asistencia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = readStreakData();
    $lastCheck = $data['last_check'];
    $currentStreak = $data['current_streak'];
    
    // Verificar si ya marcó hoy
    if ($lastCheck === $today) {
        $response = [
            'status' => 'warning',
            'message' => 'Ya marcaste asistencia hoy',
            'streak' => $currentStreak
        ];
        echo json_encode($response);
        exit;
    }
    
    // Si es el primer registro
    if ($lastCheck === null) {
        $data['current_streak'] = 1;
        $data['last_check'] = $today;
        $data['history'][$today] = 1;
        saveStreakData($data);
        $response = [
            'status' => 'success',
            'message' => '¡Primer día registrado! Comienza tu racha',
            'streak' => 1
        ];
        echo json_encode($response);
        exit;
    }
    
    // Calcular diferencia de días
    $lastDate = new DateTime($lastCheck);
    $todayDate = new DateTime($today);
    $diff = $todayDate->diff($lastDate)->days;
    
    // Si pasaron más de 3 días, la racha se pierde
    if ($diff > 3) {
        $data['current_streak'] = 1;
        $data['last_check'] = $today;
        $data['history'][$today] = 1;
        saveStreakData($data);
        $response = [
            'status' => 'warning',
            'message' => 'Perdiste tu racha por inactividad. ¡Comienza una nueva!',
            'streak' => 1
        ];
        echo json_encode($response);
        exit;
    }
    
    // Si es día consecutivo (diff == 1)
    if ($diff == 1) {
        $data['current_streak'] = $currentStreak + 1;
        $data['last_check'] = $today;
        $data['history'][$today] = $data['current_streak'];
        saveStreakData($data);
        $response = [
            'status' => 'success',
            'message' => '¡Nuevo día registrado!',
            'streak' => $data['current_streak']
        ];
        echo json_encode($response);
        exit;
    }
    
    // Si es el mismo día (ya lo cubrimos antes)
    if ($diff == 0) {
        $response = [
            'status' => 'warning',
            'message' => 'Ya marcaste hoy',
            'streak' => $currentStreak
        ];
        echo json_encode($response);
        exit;
    }
    
    // Si pasaron exactamente 2 o 3 días, se mantiene la racha pero no aumenta
    if ($diff == 2 || $diff == 3) {
        $data['last_check'] = $today;
        $data['history'][$today] = $currentStreak;
        saveStreakData($data);
        $response = [
            'status' => 'success',
            'message' => '¡Racha mantenida! Marcaste después de ' . $diff . ' días',
            'streak' => $currentStreak
        ];
        echo json_encode($response);
        exit;
    }
}
?>