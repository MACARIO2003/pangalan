<?php
session_start();
require 'connect.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            $insert = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
            $insert->bind_param("sss", $email, $username, $password); // NOT HASHED
            $insert->execute();

            $success = "Account created successfully! You can now login.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="container">
    <form method="POST" class="login-box">
        <h2>REGISTER</h2>

        <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
        <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email" required>

        <input type="text" name="username" placeholder="Username" required>

        <div class="password-field">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fa-solid fa-eye" id="toggle1"></i>
        </div>

        <div class="password-field">
            <input type="password" name="confirm" id="confirm" placeholder="Confirm Password" required>
            <i class="fa-solid fa-eye" id="toggle2"></i>
        </div>

        <button type="submit">Register</button>
    </form>
</div>

<script>
// password 1
document.getElementById("toggle1").addEventListener("click", function () {
    let pw = document.getElementById("password");
    if (pw.type === "password") {
        pw.type = "text";
        this.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        pw.type = "password";
        this.classList.replace("fa-eye-slash", "fa-eye");
    }
});

// confirm password
document.getElementById("toggle2").addEventListener("click", function () {
    let pw = document.getElementById("confirm");
    if (pw.type === "password") {
        pw.type = "text";
        this.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        pw.type = "password";
        this.classList.replace("fa-eye-slash", "fa-eye");
    }
});
</script>

</body>
</html>
