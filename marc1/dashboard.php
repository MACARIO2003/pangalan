<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'connect.php';
?>
<h1>Welcome, <?= $_SESSION['username'] ?></h1>
<a href="logout.php">Logout</a>

<h2>Projects</h2>
<a href="add_project.php">Add New Project</a>
<table border="1">
    <tr><th>Title</th><th>Description</th><th>Image</th><th>Actions</th></tr>
    <?php
    $result = $conn->query("SELECT * FROM projects");
    while ($row = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td><?= $row['image'] ? "<img src='{$row['image']}' width='100'>" : 'No Image' ?></td>
        <td>
            <a href="edit_project.php?id=<?= $row['id'] ?>">Edit</a> | 
            <a href="delete_project.php?id=<?= $row['id'] ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Messages</h2>
<table border="1">
    <tr><th>Name</th><th>Email</th><th>Message</th><th>Received</th></tr>
    <?php
    $messages = $conn->query("SELECT * FROM messages ORDER BY created_at DESC");
    while ($msg = $messages->fetch_assoc()):
    ?>
    <tr>
        <td><?= htmlspecialchars($msg['name']) ?></td>
        <td><?= htmlspecialchars($msg['email']) ?></td>
        <td><?= htmlspecialchars($msg['message']) ?></td>
        <td><?= $msg['created_at'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>
