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

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $db_password);
        $stmt->fetch();

        if ($password === $db_password) {
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Email not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="style.css">

<style>
/* LOGIN PAGE */
body.login {
  background-image: url("arc3.jpg");
}

/* Center form card */
.login-container {
  margin: 180px auto;
  padding: 30px;
  width: 350px;
  background: rgba(255,255,255,0.06);
  backdrop-filter: blur(12px);
  border-radius: 20px;
  box-shadow: 0 6px 25px rgba(0, 0, 0, 1);
  color: white;
}

.login-container h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #f8b705;
}

/* Inputs */
.login-container input {
  width: 100%;
  padding: 12px;
  margin: 10px 0 18px;
  border-radius: 10px;
  border: none;
  background: rgba(14, 13, 13, 0.17);
  color: #fff;
  font-size: 1rem;
}

/* Password wrapper */
.password-wrapper {
  position: relative;
}

.toggle-password {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
  color: #f8b705;
  font-size: 18px;
}

/* Button */
.login-container button {
  width: 100%;
  padding: 12px;
  border-radius: 10px;
  border: none;
  cursor: pointer;
  background: #f8b705;
  color: black;
  font-weight: bold;
  transition: 0.3s;
}

.login-container button:hover {
  background: #333;
  color: white;
  box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
}

/* Error message */
.error {
  background: rgba(255,0,0,0.3);
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
  text-align: center;
  color: #ffdddd;
}
</style>
</head>

<body class="login">

<div class="login-container">
    <form method="POST">
        <h2>LOGIN</h2>

        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <div class="password-wrapper">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePassword()">👁</span>
        </div>

        <button type="submit">Login</button>
    </form>
</div>

<script>
function togglePassword() {
    let pass = document.getElementById("password");
    pass.type = pass.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
