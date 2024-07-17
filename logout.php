<?php
require 'backend/config/constants.php';

// Check if session is started and destroy all sessions
if (session_status() === PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Redirect to home page
header('Location: ' . ROOT_URL);
die();
?>
