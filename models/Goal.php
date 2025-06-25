<?php
require_once __DIR__ . '/../config/database.php';

class Goal {
    private $conn;
    private $table = "goals";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();  // ✅ USA PDO
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // ✅ esto es PDO
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} 
            (titulo, descripcion, tipo, fecha_inicio, fecha_fin, progreso, estado) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['tipo'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['progreso'],
            $data['estado']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET 
            titulo = ?, descripcion = ?, tipo = ?, 
            fecha_inicio = ?, fecha_fin = ?, progreso = ?, estado = ? 
            WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['titulo'],
            $data['descripcion'],
            $data['tipo'],
            $data['fecha_inicio'],
            $data['fecha_fin'],
            $data['progreso'],
            $data['estado'],
            $id
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
