<?php
session_start();

// Initialize the task list if it doesn't exist
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Handle form submission to add a task
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $_SESSION['tasks'][] = $task;
    }
}

// Handle request to delete a task
if (isset($_GET['delete'])) {
    $taskIndex = $_GET['delete'];
    if (isset($_SESSION['tasks'][$taskIndex])) {
        unset($_SESSION['tasks'][$taskIndex]);
        $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Re-index the array
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            padding: 0;
        }
        .task-list {
            margin-top: 20px;
        }
        .task {
            margin-bottom: 10px;
        }
        .delete-button {
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>To-Do List</h1>

<!-- Form to add a new task -->
<form action="" method="POST">
    <label for="task">New Task:</label>
    <input type="text" name="task" id="task" required>
    <button type="submit">Add Task</button>
</form>

<!-- Display task list -->
<h2>Your Tasks</h2>
<div class="task-list">
    <?php if (!empty($_SESSION['tasks'])): ?>
        <ul>
            <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                <li class="task">
                    <?php echo htmlspecialchars($task); ?>
                    <a href="?delete=<?php echo $index; ?>" class="delete-button">[Delete]</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tasks added yet.</p>
    <?php endif; ?>
</div>

</body>
</html>
