<?php
require_once __DIR__ . '/../config/database.php';

class MonthlyTask {
    private $conn;
    private $table = 'monthly_tasks';

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY fecha ASC";
        $result = $this->conn->query($sql);
        $tasks = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row;
            }
        }
        return $tasks;
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (fecha, titulo, descripcion, estado, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssss",
            $data['fecha'],
            $data['titulo'],
            $data['descripcion'],
            $data['estado']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET fecha = ?, titulo = ?, descripcion = ?, estado = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssssi",
            $data['fecha'],
            $data['titulo'],
            $data['descripcion'],
            $data['estado'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
