<?php
include("connection.php");
include("functions.php");

session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] === 'guest') {
    go_to_login();
} else {
    $username = $_SESSION['username'];
$user_data = get_user_data($con, $username);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $displayname = isset($_POST['displayname']) ? $_POST['displayname'] : 'Anonymous';
    $anonymous = isset($_POST['anonymous']) ? 'Y' : 'N';
    $text = isset($_POST['text']) ? $_POST['text'] : '';

    $insertPostQuery = "INSERT INTO posts (timestamp, anonymous, text, likecount) VALUES (CURRENT_TIMESTAMP, '$anonymous', '$text', 0)";
    $result = mysqli_query($con, $insertPostQuery);

    if ($result) {
        $lastPostId = mysqli_insert_id($con);

        if ($user_data) {
            $userId = $user_data['id'];
            $insertUserPostQuery = "INSERT INTO user_post (user_id, post_id) VALUES ('$userId', '$lastPostId')";
            $userPostResult = mysqli_query($con, $insertUserPostQuery);

            if ($userPostResult) {
                echo '<meta http-equiv="refresh" content="2;url=home.php">';
                echo '<p>Post successful! Redirecting...</p>';
                exit();
            } else {
                echo "Error inserting into user_post table: " . mysqli_error($con);
            }
        } else {
            echo "Error: User not found.";
        }
    } else {
        echo "Error inserting into posts table: " . mysqli_error($con);
    }
}
}
mysqli_close($con);
?>
