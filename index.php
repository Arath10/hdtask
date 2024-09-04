<?php
session_start();

// Initialize users array if it doesn't exist
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

// Handle actions: add, delete, and display users
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

if ($action == 'add') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Add a new user to the session
        $user = [
            'id' => count($_SESSION['users']) + 1,
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'age' => $_POST['age']
        ];
        $_SESSION['users'][] = $user;
        header('Location: index.php');
        exit;
    }
} elseif ($action == 'delete') {
    $id = $_GET['id'];
    // Remove the user with the given id
    $_SESSION['users'] = array_filter($_SESSION['users'], function($user) use ($id) {
        return $user['id'] != $id;
    });
    // Reindex array after deletion
    $_SESSION['users'] = array_values($_SESSION['users']);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management System</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #dddddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .button { text-decoration: none; background-color: #4CAF50; color: white; padding: 8px 16px; border-radius: 5px; display: inline-block; }
        .button.delete { background-color: #f44336; }
    </style>
</head>
<body>
    <h1>User Management System</h1>

    <?php if ($action == 'list'): ?>
        <a href="index.php?action=add" class="button">Add New User</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($_SESSION['users']) > 0): ?>
                    <?php foreach ($_SESSION['users'] as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['age']; ?></td>
                            <td>
                                <a href="index.php?action=delete&id=<?php echo $user['id']; ?>" class="button delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    <?php elseif ($action == 'add'): ?>
        <h2>Add New User</h2>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required><br><br>
            <button type="submit" class="button">Add User</button>
        </form>
        <br>
        <a href="index.php" class="button">Back to List</a>
    <?php endif; ?>
</body>
</html>