<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    $task = $_POST['task'];
    $sql = "INSERT INTO tasks (user_id, task) VALUES ('$user_id', '$task')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    $sql = "DELETE FROM tasks WHERE id='$task_id' AND user_id='$user_id'";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$sql = "SELECT * FROM tasks WHERE user_id='$user_id'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My To-Do List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">My To-Do List</h1>
        <form action="todo.php" method="POST">
            <div class="form-group">
                <label for="task">New Task</label>
                <input type="text" class="form-control" id="task" name="task" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Task</button>
        </form>
        <h2 class="mt-4">Tasks</h2>
        <ul class="list-group">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo $row['task']; ?>
                    <a href="todo.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
<?php $conn->close(); ?>
