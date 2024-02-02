<?php
include 'connection.php';

$query = "SELECT posts.id, users.displayname, posts.text, posts.likecount, CAST(posts.timestamp AS CHAR) AS timestamp
          FROM user_post
          INNER JOIN users ON user_post.user_id = users.id
          INNER JOIN posts ON user_post.post_id = posts.id
          ORDER BY posts.timestamp DESC";


$result = mysqli_query($con, $query);

if ($result) {
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($posts);
} else {
    echo json_encode(['error' => 'Failed to fetch data']);
}
?>
