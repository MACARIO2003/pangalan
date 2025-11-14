<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require 'connect.php';

$id = $_GET['id'];

// Get current data
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$project = $stmt->get_result()->fetch_assoc();

if (!$project) {
    die("Project not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    // Image upload logic
    $imagePath = $project['image'];
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/projects/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $imagePath = $targetDir . time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $update = $conn->prepare("UPDATE projects SET title=?, description=?, image=? WHERE id=?");
    $update->bind_param("sssi", $title, $description, $imagePath, $id);

    if ($update->execute()) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $update->error;
    }
}
?>

<h2>Edit Project</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" value="<?= $project['title'] ?>" required><br><br>
    <textarea name="description" required><?= $project['description'] ?></textarea><br><br>

    <p>Current Image:</p>
    <?php if ($project['image']): ?>
        <img src="<?= $project['image'] ?>" width="150"><br><br>
    <?php endif; ?>

    <input type="file" name="image"><br><br>

    <button type="submit">Save Changes</button>
</form>
