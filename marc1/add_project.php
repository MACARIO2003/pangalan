<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    // Handle image upload
    $imagePath = null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/projects/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $imagePath = $targetDir . time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $stmt = $conn->prepare("INSERT INTO projects (title, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $imagePath);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<h2>Add New Project</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Project Title" required><br><br>
    <textarea name="description" placeholder="Project Description" required></textarea><br><br>
    <input type="file" name="image"><br><br>
    <button type="submit">Add Project</button>
</form>
