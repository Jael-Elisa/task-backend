<?php
require_once __DIR__ . '/../config/database.php';

class WeeklyTask {
    public static function all() {
        $database = new Database();
        $db = $database->connect();

        $stmt = $db->query("SELECT * FROM weekly_tasks ORDER BY task_date ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $database = new Database();
        $db = $database->connect();

        $stmt = $db->prepare("SELECT * FROM weekly_tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $database = new Database();
        $db = $database->connect();

        $stmt = $db->prepare("INSERT INTO weekly_tasks (title, description, task_date, status) VALUES (:title, :description, :task_date, :status)");
        $stmt->execute([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'task_date' => $data['task_date'],
            'status' => $data['status'] ?? 'pendiente'
        ]);

        return self::find($db->lastInsertId());
    }

    public static function update($data) {
        $database = new Database();
        $db = $database->connect();

        $stmt = $db->prepare("UPDATE weekly_tasks SET title = :title, description = :description, task_date = :task_date, status = :status WHERE id = :id");
        $stmt->execute([
            'id' => $data['id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'task_date' => $data['task_date'],
            'status' => $data['status'] ?? 'pendiente'
        ]);

        return self::find($data['id']);
    }

    public static function delete($id) {
        $database = new Database();
        $db = $database->connect();

        $stmt = $db->prepare("DELETE FROM weekly_tasks WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
