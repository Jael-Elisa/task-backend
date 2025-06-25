<?php
require_once __DIR__ . '/../models/AnnualTask.php';

class AnnualTaskController {
    private $model;

    public function __construct() {
        $this->model = new AnnualTask();
    }

    public function getAll() {
        $tasks = $this->model->getAll();
        echo json_encode($tasks);
    }

    public function getById($id) {
        $task = $this->model->getById($id);
        if ($task) {
            echo json_encode($task);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Tarea no encontrada']);
        }
    }

    public function create($data) {
        if ($this->model->create($data)) {
            http_response_code(201);
            echo json_encode(['message' => 'Tarea creada']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al crear tarea']);
        }
    }

    public function update($id, $data) {
        if ($this->model->update($id, $data)) {
            echo json_encode(['message' => 'Tarea actualizada']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al actualizar tarea']);
        }
    }

    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(['message' => 'Tarea eliminada']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al eliminar tarea']);
        }
    }
}
?>
