<?php
session_start();
include 'connection.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['field'], $_POST['value'])) {
    $user_data = get_user_data($con, $_SESSION['username']);
    $user_id = $user_data['id'];
    $field = mysqli_real_escape_string($con, $_POST['field']);
    $value = mysqli_real_escape_string($con, $_POST['value']);

    if ($field === 'username') {
        mysqli_query($con, "UPDATE users SET username = '$value' WHERE id = $user_id");
    } elseif ($field === 'displayname') {
        mysqli_query($con, "UPDATE users SET displayname = '$value' WHERE id = $user_id");
    } elseif ($field === 'password') {
        mysqli_query($con, "UPDATE users SET password = '$value' WHERE id = $user_id");
    }

    header('Content-Type: application/json');
    echo json_encode(['message' => 'Update successful']);
    exit();
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request']);
    exit();
}
?>
