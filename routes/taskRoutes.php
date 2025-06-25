<?php
require_once __DIR__ . '/../models/Task.php';

// CORS para permitir peticiones desde React
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$task = new Task();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $title = $data->title ?? '';
    $description = $data->description ?? '';
    $color = $data->color ?? '#000000';
    $status = 'pendiente'; // Por defecto
    $priority = $data->priority ?? 'media';
    $assigned_user = $data->assigned_user ?? null;
    $deadline = $data->deadline ?? null;

    if ($task->createTask($title, $description, $color, $status, $priority, $assigned_user, $deadline)) {
        echo json_encode(['success' => true, 'message' => 'Tarea creada']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al crear tarea']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}
switch ($method) {
    case 'GET':
        // Obtener todas las tareas
        $result = $task->getTasks();
        $tasks = [];

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }

        echo json_encode($tasks);
        break;

    // Otros casos POST, PUT, DELETE si tienes
}
?>
