<?php
    include("connection.php");
    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $user_name = $_POST['username'];
        $display_name = $_POST['displayname'];
        $password = $_POST['password'];
    
        if (!empty($user_name) && !empty($display_name) && !empty($password)) {
            $query = "INSERT INTO users (id, username, displayname, password) VALUES ('', '$user_name', '$display_name', '$password')";
            mysqli_query($con, $query);
            header("Location: login.php");
            die;
        } else {
            echo "Please enter some valid information!";
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
    <script src="script.js"></script>

    <div class="header">
        <img src="images/logo2.png">
    </div>
    
    <div class="form-box">
        <form action="" method="post">
            <h1>Register</h1>
            <div class="input-box">
                <input type="text" name="username" placeholder="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="text" name="displayname" placeholder="Display Name" required>
                <i class='bx bxs-user-circle'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class='bx bxs-lock'></i>
            </div>
            <button type="submit" class="btn">Register</button>

            <div class="register">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
</body>

</html>