<?php
include ("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestData = json_decode(file_get_contents('php://input'), true);
    $postId = $requestData['postId'];
    $isLiked = $requestData['isLiked'];

    if ($isLiked) {
        $sql = "UPDATE posts SET likecount = likecount - 1 WHERE id = $postId AND likecount > 0";
    } else {
        $sql = "UPDATE posts SET likecount = likecount + 1 WHERE id = $postId";
    }

    if ($con->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'error: ' . $con->error;
    }
} else {
    echo 'error: Unsupported request method';
}

$con->close();
?>
