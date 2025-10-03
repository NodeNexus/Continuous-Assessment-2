<?php
require_once 'database/db.php';
require_once 'classes/Todo.php';

$todo = new Todo($conn);
$todos = $todo->getTodos()->fetchAll(PDO::FETCH_ASSOC);

$today = date("Y-m-d");
$dueToday = array_filter($todos, function($t) use ($today) {
    return $t['due_date'] == $today;
});
?>
<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <link rel="stylesheet" href="assets/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>Todo List</h1>
        <a href="create.php">Create New Todo</a>
        <h2>All Todos</h2>
        <ul>
            <?php foreach ($todos as $t): ?>
                <li>
                    <?php echo htmlspecialchars($t['title']); ?> (Due: <?php echo $t['due_date']; ?>)
                    <?php if (!$t['completed']): ?>
                        <a href="mark-complete.php?id=<?php echo $t['id']; ?>">Mark Completed</a>
                    <?php else: ?>
                        <strong>[Completed]</strong>
                    <?php endif; ?>
                    | <a href="edit.php?id=<?php echo $t['id']; ?>">Edit</a>
                    | <a href="delete.php?id=<?php echo $t['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Due Today</h2>
        <ul>
            <?php if (count($dueToday) > 0): ?>
                <?php foreach ($dueToday as $t): ?>
                    <li><?php echo htmlspecialchars($t['title']); ?> (Due Today)</li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No todos due today.</li>
            <?php endif; ?>
        </ul>
    </main>
</body>
</html>
