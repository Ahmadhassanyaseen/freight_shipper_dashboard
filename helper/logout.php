<?php


setcookie("user", "", time() - 3600, "/");

header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
?>
