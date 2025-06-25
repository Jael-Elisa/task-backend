<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$request = $_SERVER['REQUEST_URI'];
$request = str_replace('/task/backend/routes/api.php', '', $request);

if ($request === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../controllers/AuthController.php';
} else {
    echo json_encode(["status" => "error", "message" => "Ruta no encontrada: $request"]);
}
?>