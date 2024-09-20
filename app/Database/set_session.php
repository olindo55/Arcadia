<?php
session_start();
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $_SESSION['selected_id'] = intval($_POST['id']);
    echo json_encode(['status' => 'success', 'id' => $_SESSION['selected_id']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No ID received']);
}
?>