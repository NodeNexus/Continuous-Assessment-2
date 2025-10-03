<?php
require_once 'database/db.php';
require_once 'classes/Todo.php';

if (isset($_GET['id'])) {
    $todo = new Todo($conn);
    $todo->delete($_GET['id']);
}

header("Location: index.php");
exit();
?>
