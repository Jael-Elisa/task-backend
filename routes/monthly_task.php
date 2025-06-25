<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Respuesta para preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../controllers/MonthlyTaskController.php';

$controller = new MonthlyTaskController();
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $controller->getById($_GET['id']);
        } else {
            $controller->getAll();
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->create($data);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->update($data['id'], $data);
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        $controller->delete($data['id']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Método no permitido']);
        break;
}
?>
