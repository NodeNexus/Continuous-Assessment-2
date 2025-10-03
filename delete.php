<?php
require 'database/db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$pdo = db_connect();

$conditions = [
    'id' => $_GET['id']
];

db_delete($pdo, 'todos', $conditions);

header("Location: index.php");
