<?php
require_once '../config/Database.php';  // Asegúrate que la ruta sea correcta
require_once '../models/Goal.php';

class GoalController {
    private $model;

    public function __construct() {
        $db = (new Database())->connect();  // conexión correcta
        $this->model = new Goal($db);
    }

    public function getAll() {
        return $this->model->getAll();
    }

    public function getById($id) {
        $goal = $this->model->getById($id);
        echo json_encode($goal);
    }

    public function create($data) {
        if ($this->model->create($data)) {
            http_response_code(201);
            echo json_encode(['message' => 'Meta creada']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al crear meta']);
        }
    }

    public function update($id, $data) {
        if ($this->model->update($id, $data)) {
            echo json_encode(['message' => 'Meta actualizada']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al actualizar meta']);
        }
    }

    public function delete($id) {
        if ($this->model->delete($id)) {
            echo json_encode(['message' => 'Meta eliminada']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error al eliminar meta']);
        }
    }
}
