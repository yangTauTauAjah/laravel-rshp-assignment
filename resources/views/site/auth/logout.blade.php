<?php
session_start();

// Clear all session data
$_SESSION = array();

// Destroy the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Set flash message for successful logout
session_start();
$_SESSION['flash_msg'] = "Anda telah berhasil logout.";

// Redirect to home page
header("Location: /index.php");
exit();
?>