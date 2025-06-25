<?php
require_once __DIR__ . '/../config/database.php';

class Task {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function createTask($title, $description, $color, $status, $priority, $assigned_user, $deadline) {
        $stmt = $this->conn->prepare("INSERT INTO tasks (title, description, color, status, priority, assigned_user, deadline, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssis", $title, $description, $color, $status, $priority, $assigned_user, $deadline);
        return $stmt->execute();
    }

    public function getTasks() {
    $query = "SELECT * FROM tasks";
    return $this->conn->query($query);
}

    



public function updateTask($id, $title, $description, $color, $priority, $assigned_user, $deadline) {
    $conn = (new Database())->getConnection();
    $stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, color = ?, priority = ?, assigned_user = ?, deadline = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $title, $description, $color, $priority, $assigned_user, $deadline, $id);
    return $stmt->execute();
}


    public function deleteTask($id) {
        $stmt = $this->conn->prepare("DELETE FROM study_tasks WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function getTaskById($id) {
        $conn = (new Database())->getConnection(); // o usa $this->conn si ya está en la clase
        $stmt = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    
        $result = $stmt->get_result();
    
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); // devuelve un array asociativo con la tarea
        } else {
            return null;
        }
    }
    
    
}
?>
