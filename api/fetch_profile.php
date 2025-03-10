<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/database_access.php';

$userId = $_SESSION['user_id'];
$memberId = (isset($_GET['user_id']) ? sanitize($_GET['user_id']) : $userId);

$profile       = get_profile($memberId);
$profilePics  = get_profile_pics($memberId);
$profilePicUrl  = ($profilePics ? "/chitchat/uploads/profile_pics/" . $profilePics[0]['image_name'] : "/chitchat/assets/img/profile_pic.png");
$followerNum  = get_follower_num($memberId);
$followeeNum = get_followee_num($memberId);
$postNum      = get_post_num($memberId);

echo "<a class='profile-picture-container' href='$profilePicUrl' target='_blank'><img class='profile-picture' src='$profilePicUrl'></a>"
	. "<p class='name'>$profile[first_name] $profile[last_name]</p>"
	. "<p class='username'>$profile[username]</p>"
	. "<p class='bio'><strong>Bio</strong>: $profile[bio]</p>"
	. "<p class='birth-date><strong>Birthdate</strong>: $profile[dob]</p>"
	. "<p class='stats'>"
	. "<span class='follower'><strong>Followers</strong>: $followerNum</span> | "
	. "<span class='following'><strong>Following</strong>: $followeeNum</span> | "
	. "<span class='post-num'><strong>Posts</strong>: $postNum</span>"
	. "</p>";

echo "<div>" . (
	$memberId == $userId

	? "<a href='/chitchat/upload_profile_pic.php'><button>Change profile picture</button></a> | "
	. "<a href='/chitchat/post.php'><button>Post</button></a> | "
	. "<a href='delete_account.php'><button>Delete Account</button></a>"

	: "<a href='/chitchat/chat.php?user_id=$memberId'><button class='chat-btn'>Chat</button></a>"

) . "</div>";
