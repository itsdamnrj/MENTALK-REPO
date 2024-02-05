<?php
session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['username'];
    $password = $_POST['password'];
    

    if (!empty($user_name) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = '$user_name'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($user_data['password'] === $password) {
                $_SESSION['username'] = $user_data['username'];
                header("Location: home.php");
                die;
            } else {
                echo "Wrong password.";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "Please enter both username and password.";
    }
} elseif (isset($_GET['guest'])) {
    $guest_username = 'guest';

    $query = "SELECT * FROM users WHERE username = '$guest_username'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $user_data['username'];
        header("Location: home.php");
        die;
    } else {
        echo "Guest user not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentalk</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="stylesheet_register.css" rel="stylesheet">
</head>

<body>
    <div class="header">
        <img src="images/logo2.png">
    </div>

    <div class="form-box">
        <form action="" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required autocomplete="username">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                <i class='bx bxs-lock'></i>
            </div>
            <button type="submit" class="btn">Login</button>

            <div class="register">
                <p>Don't have an account? <a href="register.php">Register</a></p>
            </div>
            <div class="guest">
                <a href="login.php?guest=1">Continue as Guest</a>
            </div>
        </form>
    </div>
</body>
</html>