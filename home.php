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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentalk</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<body>
    <script src="script.js"></script>
    <script>
        generateNavBar(<?php echo json_encode($user_data); ?>, 'home.php');
    </script>
    
    <div class="container">
        <div class="main-content">
        <form action="create_post.php" method="POST" onsubmit="return submitForm();">
            <div class="create-post">
                <div class="user">
                    <h1 id="displayname"><?php echo isset($user_data['displayname']) ? $user_data['displayname'] : 'error displaying displayname'; ?></h1>
                    <input type="checkbox" id="check" name="anonymous" onclick="toggleAnonymous()">
                    <label for="check" class="toggle-button"></label>
                </div>
                <div class="create-post-form">
                    <div class="create-post-input">
                        <textarea id="postText" rows="2" name="text" placeholder="What are your thoughts?"></textarea>
                    </div>
                    <ul class="create-post-links">
                        <li><button type="submit">Post</button></li>
                    </ul>
                </div>
            </div>
        </form>
            <div id="post_container"> </div>
    </div>

    <script>
        function submitForm() {
            var postText = document.getElementById("postText").value.trim();
            if (postText === "") {
                alert("Please enter your thoughts before posting.");
                return false;
            }
            return true; 
        }

        var clicked = false;
        function toggleAnonymous() {
            const displayname = document.getElementById("displayname");
            clicked = !clicked;
            displayname.innerText = clicked ? 'Anonymous' : '<?php echo $user_data['displayname'];?>';
        }
    </script>

    <script>
        fetchPosts();
    </script>

    <script>
        let footer = generateFooter();
        document.body.innerHTML += footer;
    </script>
</body>
</html>