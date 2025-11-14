<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Message sent successfully!'); window.location.href='contact.html';</script>";
        } else {
            echo "<script>alert('❌ Error saving message.'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please fill out all fields.'); window.history.back();</script>";
    }
}

$conn->close();
?>
