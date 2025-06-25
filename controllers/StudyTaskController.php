<?php
require_once __DIR__ . '/../models/StudyTask.php';

class StudyTaskController {
    private $model;

    public function __construct() {
        $this->model = new StudyTask();
    }

    public function createTask($data) {
        // Asegúrate de validar o asignar valores por defecto si falta algo
        return $this->model->insertTask(
            $data['date'] ?? '',
            $data['time'] ?? '',
            $data['topic'] ?? '',
            $data['temas'] ?? '',
            $data['progreso'] ?? '',
            $data['notas'] ?? ''
        );
    }

    public function getTasks() {
        return $this->model->getAll();
    }
    public function delete($id) {
        return $this->model->delete($id);
    }



    public function getTaskById($id) {
        return $this->model->getById($id);
    }
    
    public function updateTask($data) {
        return $this->model->update($data);
    }


}
