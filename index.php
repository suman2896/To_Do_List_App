<?php
$taskFile = 'tasks.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['task'])) {
        $task = trim($_POST['task']);
        if ($task !== '') {
            file_put_contents($taskFile, $task . PHP_EOL, FILE_APPEND);
        }
    }

    if (isset($_POST['delete'])) {
        $tasks = file($taskFile, FILE_IGNORE_NEW_LINES);
        unset($tasks[$_POST['delete']]);
        file_put_contents($taskFile, implode(PHP_EOL, $tasks) . PHP_EOL);
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$tasks = file_exists($taskFile) ? file($taskFile, FILE_IGNORE_NEW_LINES) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Simple To-Do List</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      display: flex;
      justify-content: center;
      margin-top: 50px;
    }

    .container {
      background: #fff;
      padding: 20px 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #aaa;
      width: 400px;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    form {
      display: flex;
      margin-bottom: 20px;
    }

    input[type="text"] {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px 0 0 5px;
    }

    button {
      padding: 10px 15px;
      border: none;
      background-color: #28a745;
      color: white;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    li {
      padding: 10px;
      background: #eee;
      margin-bottom: 10px;
      border-radius: 5px;
      display: flex;
      justify-content: space-between;
    }

    .delete-btn {
      background: #dc3545;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 3px;
      cursor: pointer;
    }

  </style>
</head>
<body>
  <div class="container">
    <h2>📝 Simple To-Do List</h2>

    <form action="" method="POST">
      <input type="text" name="task" placeholder="Enter new task..." required>
      <button type="submit">Add</button>
    </form>

    <ul>
      <?php foreach ($tasks as $index => $task): ?>
        <li>
          <?= htmlspecialchars($task) ?>
          <form method="POST" style="margin: 0;">
            <input type="hidden" name="delete" value="<?= $index ?>">
            <button class="delete-btn" type="submit">Delete</button>
          </form>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</body>
</html>
