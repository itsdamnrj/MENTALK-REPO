function generateNavBar(user_data, currentPage) {
    const navbarHtml = `
        <nav class="navbar">
            <div class="navbar-left">
                <a href="home.php" class="logo"><img src="images/logo.png"></a>
            </div>
            <div class="navbar-right">
                <ul>
                    <li><a href="home.php" class="${currentPage === 'home.php' ? 'active-link' : ''}"><img src="images/home.png"> <span>Home</span></a></li>
                    <li onclick="toggleMenu()"><a href="#" class="${currentPage === 'profile.php' ? 'active-link' : ''}"><img src="images/profile.png"> <span>My Profile</span></a></li>
                </ul>
            </div>
            <div class="profile-menu-wrap" id="profileMenu">
                <div class="profile-menu">
                    <div class="user-info">
                        <h3>${user_data.displayname ? user_data.displayname : 'error displaying displayname'}</h3>
                    </div>
                    <hr>
                    <a href="profile.php" class="profile-menu-link"><img src="images/setting.png"> <p>Edit Profile</p> <span></span></a>
                    <a href="#" class="profile-menu-link"><img src="images/feedback.png"> <p>Give Feedback</p> <span></span></a>
                    <a href="#" class="profile-menu-link"><img src="images/help.png"> <p>Help & Support</p> <span></span></a>
                    <a href="logout.php" class="profile-menu-link"><img src="images/logout.png"> <p>Logout</p> <span></span></a>
                </div>
            </div>
        </nav>
    `;
    document.body.innerHTML = navbarHtml;
}

function generateFooter() {
    return `
    <section class="footer">
        <ul class="list">
            <li>
                <a href="#">Terms & Conditions</a>
            </li>
            <li>
                <a href="#">Privacy Policy</a>
            </li>
        </ul>
        <p class="copyright">
            All Rights Reserves &copy; 2024
        </p>
    </section>
    `;
}

const postContainer = document.getElementById('post_container');

const fetchPosts = async (user_data) => {
    const response = await fetch('fetch_posts.php');
    const posts = await response.json();
    posts.forEach(post => createPostCard(post.id, post));
};

function createPostCard(postId, posts, user_data) {
    const postElement = document.createElement('div');
    postElement.classList.add('post');

    const isAnonymous = posts.anonymous === 'Y';
    const author = isAnonymous ? 'Anonymous' : posts.displayname;
    const timestamp = new Date(posts.timestamp);
    const timeAgo = formatTimeAgo(timestamp);
    const postText = posts.text;
    const likedCount = posts.likecount;

    const postInnerHTML = `
        <div class="post-author">
            <div>
                <h1>${author}</h1>
                <small>${timeAgo}</small>
            </div>
        </div>
        <p>${postText}</p>
        <div class="post-stats">
            <div>
                <img src="images/like.png">
                <span class="liked-count" data-post-id="${postId}">${likedCount}</span>
            </div>
        </div>
        <div class="post-activity">
            <div class="post-activity-link" id="likeButton_${postId}" onclick="likePost(${postId})">
                <img id="likeImage_${postId}" src="images/like.png">
                <span id="likeText_${postId}">Like</span> 
            </div>
        </div>
    `;

    postElement.innerHTML = postInnerHTML;

    document.getElementById('post_container').appendChild(postElement);
}

function formatTimeAgo(timestamp) {
    const postDate = new Date(timestamp);
    const now = new Date();
    const diffInSeconds = Math.floor((now - postDate) / 1000);

    if (diffInSeconds < 60) {
        return 'just now';
    } else if (diffInSeconds < 3600) {
        const minutes = Math.floor(diffInSeconds / 60);
        if (minutes == 1) {
            return `${minutes} minute ago`;
        }
        else {
            return `${minutes} minutes ago`;
        }
    } else if (diffInSeconds < 86400) {
        const hours = Math.floor(diffInSeconds / 3600);
        if (hours == 1) {
            return `${hours} hour ago`;
        }
        else {
            return `${hours} hours ago`;
        }
    } else {
        const days = Math.floor(diffInSeconds / 86400);
        if (days == 1) {
            return `${days} day ago`;
        }
        else {
            return `${days} days ago`;
        }
    }
}

function likePost(postId) {
    const likedCountElement = document.querySelector(`.liked-count[data-post-id="${postId}"]`);
    const likeText = document.getElementById(`likeText_${postId}`);
    const likeButton = document.getElementById(`likeButton_${postId}`);
    const likeImage = document.getElementById(`likeImage_${postId}`);
    const isLiked = likeButton.classList.contains('liked');

    fetch('like_post.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            postId: postId,
            isLiked: isLiked,
        }),
    })
        .then(response => response.text())
        .then(data => {
            if (data === 'success') {
                likeButton.classList.toggle('liked');
                const currentLikedCount = parseInt(likedCountElement.innerText);
                likedCountElement.innerText = isLiked ? currentLikedCount - 1 : currentLikedCount + 1;
                likeText.innerText = isLiked ? 'Like' : 'Liked';
                likeButton.style.color = isLiked ? '' : '#e1a730';
                likeImage.src = isLiked ? 'images/like.png' : 'images/liked.png';
            } else {
                console.error('Error updating like count:', data);
            }
        })
        .catch(error => {
            console.error('Error updating like count:', error);
        });
}

function toggleMenu() {
    let profileMenu = document.getElementById("profileMenu");
    if (profileMenu) {
        profileMenu.classList.toggle("open-menu");
    }
}

const fetchUserPosts = async (user_data) => {
    try {
        const response = await fetch('fetch_user_post.php');
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const posts = await response.json();
        posts.forEach(post => createUserPostCard(post.id, post, user_data));
    } catch (error) {
        console.error('Error fetching user posts:', error);
    }
};

function createUserPostCard(postId, posts, user_data) {
    const postElement = document.createElement('div');
    postElement.classList.add('post');
    postElement.id = `post_${postId}`;

    posts.displayname = user_data.displayname;

    const author = posts.displayname;
    const timestamp = new Date(posts.timestamp);
    const timeAgo = formatTimeAgo(timestamp);
    const postText = posts.text;
    const likedCount = posts.likecount;

    const postInnerHTML = `
        <div class="post-author">
            <div>
                <h1>${author}</h1>
                <small>${timeAgo}</small>
            </div>
        </div>
        <p>${postText}</p>
        <div class="post-stats">
            <div>
                <img src="images/like.png">
                <span class="liked-count" data-post-id="${postId}">${likedCount}</span>
            </div>
        </div>
        <div class="post-activity">
            <div class="post-activity-link" id="deleteButton" onclick="deletePost(${postId})">
                <img id="deleteImage" src="images/delete.png">
                <span id="deleteText">Delete</span> 
            </div>
        </div>
    `;

    postElement.innerHTML = postInnerHTML;

    document.getElementById('post_container').appendChild(postElement);
}

function deletePost(postId) {
    fetch('delete_post.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'postId=' + encodeURIComponent(postId),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.text();
    })
    .then(responseText => {
        console.log('Server response:', responseText);
        const postElement = document.getElementById(`post_${postId}`);
        if (postElement) {
            postElement.remove();
        }
    })
}

function editField(fieldName) {
    var currentValue = document.getElementById(fieldName).textContent;
    var newValue = prompt('Enter new ' + fieldName + ':', currentValue);

    if (newValue !== null) {
        document.getElementById(fieldName).textContent = newValue;

        var formData = new FormData();
        formData.append('field', fieldName);
        formData.append('value', newValue);

        fetch('update_profile.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            location.reload();
        })
        .catch(error => {
            console.error('Error updating profile:', error.message);
        });
    }
}

