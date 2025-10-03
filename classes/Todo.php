<?php
class Todo {
    private $conn;
    private $table = "todos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getTodos() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY due_date ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getTodoById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($title, $due_date) {
        if (empty($title) || empty($due_date)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table . " (title, due_date) VALUES (:title, :due_date)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":due_date", $due_date);
        return $stmt->execute();
    }

    public function markComplete($id) {
        $query = "UPDATE " . $this->table . " SET completed = 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function update($id, $title, $due_date) {
        if (empty($title) || empty($due_date)) {
            return false;
        }
        $query = "UPDATE " . $this->table . " SET title = :title, due_date = :due_date WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":due_date", $due_date);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
