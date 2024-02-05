<?php
session_start();
include 'connection.php';
include 'functions.php';

$user_data = get_user_data($con, $_SESSION['username']);
$username = $user_data['username'];

$query = "SELECT posts.id, posts.anonymous, users.displayname, posts.text, posts.likecount, CAST(posts.timestamp AS CHAR) AS timestamp
          FROM user_post
          INNER JOIN users ON user_post.user_id = users.id
          INNER JOIN posts ON user_post.post_id = posts.id
          WHERE username = '$username'
          ORDER BY posts.timestamp DESC";

$result = mysqli_query($con, $query);

if ($result) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($posts);
} else {
    echo json_encode(['error' => 'Failed to fetch data']);
}
?>