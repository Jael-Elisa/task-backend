<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config/database.php';
require_once '../controllers/WeeklyTaskController.php';

try {
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        http_response_code(200);
        exit;
    }

    switch ($method) {
        case 'GET':
            WeeklyTaskController::index();
            break;

        case 'POST':
            $input = json_decode(file_get_contents("php://input"), true);
            WeeklyTaskController::store($input);
            break;

        case 'PUT':
            $input = json_decode(file_get_contents("php://input"), true);
            if (!isset($input['id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID requerido para actualizar']);
                exit;
            }
            WeeklyTaskController::update($input);
            break;

        case 'DELETE':
            $input = json_decode(file_get_contents("php://input"), true);
            if (!isset($input['id'])) {
                http_response_code(400);
                echo json_encode(['error' => 'ID requerido para eliminar']);
                exit;
            }
            WeeklyTaskController::delete($input['id']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error interno del servidor',
        'details' => $e->getMessage()
    ]);
}
