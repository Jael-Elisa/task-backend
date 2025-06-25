<?php
// 🟢 CORS - Muy importante para permitir acceso desde React
// Encabezados CORS
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Si es una solicitud de preflight (OPTIONS), solo respondemos y salimos
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../controllers/StudyTaskController.php';

$controller = new StudyTaskController();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);

        // Log de prueba (opcional)
        file_put_contents("log.txt", json_encode($data));

        $success = $controller->createTask($data);
        echo json_encode(['success' => $success]);
        break;

   case 'GET':
    if (isset($_GET['id'])) {
        // Obtener una tarea específica por ID
        $id = $_GET['id'];
        $task = $controller->getTaskById($id); // Debes implementar este método en tu controlador
        echo json_encode($task);
    } else {
        // Obtener todas las tareas
        $tasks = $controller->getTasks();
        echo json_encode($tasks);
    }
    break;

    case 'DELETE':
        // Lee el cuerpo JSON
        $input = json_decode(file_get_contents('php://input'), true);
        if(isset($input['id'])) {
            $deleted = $controller->delete($input['id']);
            if ($deleted) {
                http_response_code(200);
                echo json_encode(['message' => 'Tarea eliminada con éxito']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error al eliminar tarea']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID no proporcionado']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['id'])) {
            $controller->updateTask($data);
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Falta el ID"]);
        }
        break;



    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
