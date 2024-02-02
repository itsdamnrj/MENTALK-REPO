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
        document.body.innerHTML = generateNavBar();
    </script>
    
    <div class="container">
        <div class="main-content">
            <div class="create-post">
                <div class="user">
                    <h1 id="displayname">@username</h1>
                    <input type="checkbox" id="check" onclick="toggleAnonymous()">
                    <label for="check" class="toggle-button"></label>
                </div>
                
                <script>
                    var clicked = false;
                    function toggleAnonymous() {
                        const displayname = document.getElementById("displayname");
                        clicked = !clicked;
                        displayname.innerText = clicked ? 'Anonymous' : '@username';
                    }
                </script>
                
                <div class="create-post-input">
                    <textarea rows="2" placeholder="What are your thoughts?"></textarea>
                </div>
                <ul class="create-post-links">
                    <li>Post</li>
                </ul>
            </div>
            <div id="post_container"> </div>
        </div>
    </div>

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