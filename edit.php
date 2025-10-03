<?php
require_once 'database/db.php';
require_once 'classes/Todo.php';

$todo = new Todo($conn);

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$currentTodo = $todo->getTodoById($id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $due_date = $_POST['due_date'];

    if (!empty($title) && !empty($due_date)) {
        if ($todo->update($id, $title, $due_date)) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Failed to update todo.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Todo</title>
    <link rel="stylesheet" href="assets/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Edit Todo</h1>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($currentTodo['title']); ?>" required>
            <label>Due Date</label>
            <input type="date" name="due_date" value="<?php echo $currentTodo['due_date']; ?>" required>
            <button type="submit">Update</button>
        </form>
        <a href="index.php">Back to List</a>
    </main>
</body>
</html>
