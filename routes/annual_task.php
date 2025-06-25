<?php
require_once __DIR__ . '/../controllers/AnnualTaskController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$controller = new AnnualTaskController();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'OPTIONS':
        // Responder a preflight CORS
        http_response_code(200);
        break;

    case 'GET':
        if (isset($_GET['id'])) {
            $controller->getById(intval($_GET['id']));
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
        if (isset($data['id'])) {
            $controller->update(intval($data['id']), $data);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID requerido para actualizar']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'])) {
            $controller->delete(intval($data['id']));
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID requerido para eliminar']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Método no permitido']);
        break;
}
?>
