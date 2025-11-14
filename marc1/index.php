<?php
session_start();
require 'connect.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $dbPassword);
        $stmt->fetch();

        if ($password === $dbPassword) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;

            header("Location: try.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not found.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<div class="container">
    <form method="POST" class="login-box">
        <h2>LOGIN</h2>

        <?php if (!empty($error)): ?>
        <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <input type="email" name="email" placeholder="Email" required>

        <div class="password-field">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <i class="fa-solid fa-eye" id="togglePassword"></i>
        </div>

        <button type="submit">Login</button>
    </form>
</div>

<script>
const pw = document.getElementById("password");
const toggle = document.getElementById("togglePassword");

toggle.addEventListener("click", () => {
    if (pw.type === "password") {
        pw.type = "text";
        toggle.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        pw.type = "password";
        toggle.classList.replace("fa-eye-slash", "fa-eye");
    }
});
</script>

</body>
</html>
