 <?php
class StudyTask {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost:3310", "root", "", "task");
        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function insertTask($date, $time, $topic, $temas, $progreso, $notas) {
        $stmt = $this->conn->prepare("INSERT INTO study_tasks (date, time, topic, temas, progreso, notas) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $date, $time, $topic, $temas, $progreso, $notas);
        return $stmt->execute();
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM study_tasks");
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM study_tasks WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM study_tasks WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // 👈 importante que devuelva solo 1 fila como array asociativo
    }

    public function update($data) {
        $stmt = $this->conn->prepare("
            UPDATE study_tasks 
            SET topic = ?, date = ?, time = ?, temas = ?, progreso = ?, notas = ? 
            WHERE id = ?
        ");

        $stmt->bind_param("ssssssi",
            $data['topic'],
            $data['date'],
            $data['time'],
            $data['temas'],
            $data['progreso'],
            $data['notas'],
            $data['id']
        );

        return $stmt->execute();
    }



}
