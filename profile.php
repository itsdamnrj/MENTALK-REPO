<?php 
    session_start();
	include("connection.php");
	include("functions.php");
	if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        die;
    }
    $user_data = get_user_data($con, $_SESSION['username']);
?>

<head>
    <meta charset="UTF-8">
    <meta http-quiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentalk</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
<script src="script.js"></script>
    <script>
        generateNavBar(<?php echo json_encode($user_data); ?>, 'profile.php');
    </script>

    <div class="container">
        <div class="main-content">
            <div class="profile-container" >
            <div class="ds-top"></div>
            <div class="avatar-holder">
                <img src="images/profile-icon.png" alt="Profile Icon">
            </div>
                <h1>Profile Information</h1>
                <div style="display: flex;">
                    <h3 style="font-weight: 500;">Username: <span id="username"><?php echo $user_data['username'];?></span></h3>
                    <a href="#" onclick="editField('username')" style="font-size: smaller; color:#fff; margin-left: 4px;"><sup style="text-decoration:underline;">Edit</sup></a>
                </div>
                <div style="display: flex;">
                    <h3 style="font-weight: 500;">Display Name: <span id="displayname"><?php echo $user_data['displayname'];?></span></h3>
                    <a href="#" onclick="editField('displayname')" style="font-size: smaller; color:#fff; margin-left: 4px;"><sup style="text-decoration:underline;">Edit</sup></a>
                </div>
                <div style="display: flex;">
                    <h3 style="margin-bottom: 15px; font-weight: 500;">Password: <span id="password"><?php echo str_repeat('*', strlen($user_data['password']));?></span></h3>
                    <a href="#" onclick="editField('password')" style="font-size: smaller; color:#fff; margin-left: 4px;"><sup style="text-decoration:underline;">Edit</sup></a>
                </div>
            </div>
            <div>
                <h1 style="margin-bottom: -10px; margin-top: 15px; font-size: 30px;">Recent Posts:</h1>
            </div>
            <div id="post_container"></div>
        </div>
    </div>

    <script>
        fetchUserPosts(<?php echo json_encode($user_data); ?>);
    </script>

    <script>
        let footer = generateFooter();
        document.body.innerHTML += footer;
    </script>
    
    <script>
        let profileMenu = document.getElementById("profileMenu");
        function toggleMenu(){
            profileMenu.classList.toggle("open-menu");
        }
    </script>

</body>

</html>
