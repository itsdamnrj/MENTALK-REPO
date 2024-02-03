function generateNavBar() {
    return `
    <nav class="navbar">
        <div class="navbar-left">
            <a href="index.php" class="logo"><img src="images/logo.png"></a>
        </div>
        <div class="navbar-right">
            <ul>
                <li><a href="index.php" class="active-link"><img src="images/home.png"> <span>Home</span></a></li>
                <li onclick="toggleMenu()"><a href="#"><img src="images/profile.png"> <span>My Profile</span></a></li>
            </ul>
        </div>
        <div class="profile-menu-wrap" id="profileMenu">
            <div class="profile-menu">
                <div class="user-info">
                    <h3>@lilya_uwu</h3>
                </div>
                <hr>
                <a href="profile.html" class="profile-menu-link"><img src="images/profile.png"> <p>Edit Profile</p> <span></span></a>
                <a href="#" class="profile-menu-link"><img src="images/feedback.png"> <p>Give Feedback</p> <span></span></a>
                <a href="#" class="profile-menu-link"><img src="images/help.png"> <p>Help & Support</p> <span></span></a>
                <a href="#" class="profile-menu-link"><img src="images/logout.png"> <p>Logout</p> <span></span></a>
            </div>
        </div>
    </div>
    `;
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

const fetchPosts = async () => {
    const response = await fetch('fetch_posts.php');
    const posts = await response.json();
    posts.forEach(post => createPostCard(post.id, post));
};

function createPostCard(postId, posts) {
    const postElement = document.createElement('div');
    postElement.classList.add('post');

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
            <div class="post-activity-link" id="likeButton" onclick="likePost(${postId})">
                <img id="likeImage" src="images/like.png">
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
    const likeButton = document.getElementById(`likeButton`);
    const likeImage = document.getElementById('likeImage');
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
                //likeButton.style.color = isLiked ? '' : '#fff';
                likeImage.src = isLiked ? 'images/like.png' : 'images/liked.png'
            } else {
                console.error('Error updating like count:', data);
            }
        })
        .catch(error => {
            console.error('Error updating like count:', error);
        });
}

fetchPosts();