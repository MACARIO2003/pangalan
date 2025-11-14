<?php
session_start();

// Remove all session data
session_unset();

// Destroy the session
session_destroy();

// Redirect back to login page
header("Location: index.html");
exit;
?>
