<?php


// Clear all session variables
$_SESSION = array();

// Clear the global variable
if (isset($GLOBALS['shipper_user'])) {
    unset($GLOBALS['shipper_user']);
}

// Clear the specific session variable
if (isset($_SESSION['shipper_user'])) {
    unset($_SESSION['shipper_user']);
}

// Clear the initialization flag
if (isset($_SESSION['shipper_user_initialized'])) {
    unset($_SESSION['shipper_user_initialized']);
}

// Destroy the session
session_destroy();

// Return success response
header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?>
