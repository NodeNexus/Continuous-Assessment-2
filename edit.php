<?php
require 'database/db.php';
require 'classes/Todo.php';

$pdo = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (empty($_POST['description']) || empty($_POST['due_date'])) {
        $errorMessage = "Description and Due Date are required";
    } else {
        $fields = [
            'description' => $_POST['description'],
            'due_date' => $_POST['due_date'],
            'is_completed' => isset($_POST['is_completed']) ? 1 : 0,
        ];
        
        $conditions = [
            'id' => $_GET['id']
        ];

        $result = db_update($pdo, 'todos', $fields, $conditions);

        if ($result) {
            $successMessage = "Todo updated successfully";
            $row = db_fetch_one($pdo, 'todos', $conditions);
        } else {
            $errorMessage = "Failed to update todo";
        }
    }
}

if (!isset($row)) {
    if (!isset($_GET['id'])) {
        header("Location: index.php");
        exit;
    }
    
    $conditions = ['id' => $_GET['id']];
    $row = db_fetch_one($pdo, 'todos', $conditions);

    if (!$row) {
        header("Location: index.php");
        exit;
    }
}

$todoToEdit = new Todo($row['description'], $row['due_date']);
if ($row['is_completed']) {
    $todoToEdit->markAsCompleted();
}
$todoToEdit->id = $row['id'];

require 'views/edit.html';
