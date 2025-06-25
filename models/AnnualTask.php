<?php
require_once __DIR__ . '/../config/database.php';

class AnnualTask {
    private $conn;
    private $table = 'annual_tasks';

    public function __construct() {
        $this->conn = (new Database())->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (titulo, descripcion, fecha_inicio, fecha_fin, progreso, estado) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "ssssss",
            $data['titulo'],
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['progreso'],
            $data['estado']
        );
        return $stmt->execute();
    }

    public function update($id, $data) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET titulo=?, descripcion=?, fecha_inicio=?, fecha_fin=?, progreso=?, estado=? WHERE id=?");
        $stmt->bind_param(
            "ssssssi",
            $data['titulo'],
            $data['descripcion'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['progreso'],
            $data['estado'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id=?");
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
