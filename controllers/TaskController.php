<?php
require_once __DIR__ . '/../models/Task.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


$task = new Task();
$method = $_SERVER['REQUEST_METHOD'];

function obtenerFilaPorId($task, $id) {
    $data = $task->getTaskById($id); // ← este método debe devolver un array (asociativo)
    return $data ? $data : null;
}


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            // Obtener una tarea específica por ID
            $id = $_GET['id'];
            $row = obtenerFilaPorId($task, $id);
        if ($row) {
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Tarea no encontrada']);
        }

        } else {
            // Obtener todas las tareas
            $result = $task->getTasks();
            $tasks = [];
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
            echo json_encode($tasks);
        }
        break;
    
    case 'POST':
    $data = json_decode(file_get_contents("php://input"));
    if ($task->createTask($data->title, $data->description, $data->status, $data->status, $data->priority, $data->assigned_user, $data->deadline)) {
        echo json_encode(["message" => "Tarea creada"]);
    } else {
        echo json_encode(["message" => "Error al crear"]);
    }
    break;


    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        
        if (
            isset($data->id) &&
            isset($data->title) &&
            isset($data->description) &&
            isset($data->color) &&
            isset($data->priority) &&
            isset($data->assigned_user) &&
            isset($data->deadline)
        ) {
            if ($task->updateTask(
                $data->id,
                $data->title,
                $data->description,
                $data->color,
                $data->priority,
                $data->assigned_user,
                $data->deadline
            )) {
                echo json_encode(["message" => "Tarea actualizada"]);
            } else {
                http_response_code(500);
                echo json_encode(["message" => "Error al actualizar"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Datos incompletos"]);
        }
        break;
    

        case 'DELETE':
            // Obtener el id desde la query (?id=)
            $id = $_GET['id'] ?? null;
        
            if ($id) {
                if ($task->deleteTask($id)) {
                    echo json_encode(["success" => true, "message" => "Tarea eliminada"]);
                } else {
                    http_response_code(500);
                    echo json_encode(["success" => false, "message" => "Error al eliminar"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["success" => false, "message" => "ID no proporcionado"]);
            }
            break;
        

    default:
        http_response_code(405);
        echo json_encode(["message" => "Método no permitido"]);
        break;
}
?>
