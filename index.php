<?php

require 'config/database.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

echo "Conexión exitosa a la base de datos";

$uri = $_SERVER['REQUEST_URI'];

if (strpos($uri, '/api/study_task') === 0) {
    require __DIR__ . '/routes/study_task.php';
    exit;
}
if (strpos($_SERVER['REQUEST_URI'], '/api/study_task') !== false) {
  require __DIR__ . '/routes/study_task.php';
  exit;
}

?>
