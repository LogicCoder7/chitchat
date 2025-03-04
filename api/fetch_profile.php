<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/functions.php';

$userId = $_SESSION['user_id'];
$memberId = (isset($_GET['member_id']) ? sanitize($_GET['member_id']) : $userId);

$profile       = get_profile($memberId);
$profilePics  = get_profile_pics($memberId);
$profilePicSrc   = (count($profilePics) ? "/chitchat/uploads/profile_pics/" . $profilePics[0]['image_name'] : "/chitchat/assets/img/profile_pic.png");
$followerNum  = follower_num($memberId);
$followingNum = following_num($memberId);
$postNum      = post_num($memberId);

echo "<a class='profile-picture-container' href='$profilePicSrc' target='_blank'><img class='profile-picture' src='$profilePicSrc'></a>"
	. "<p class='name'>$profile[first_name] $profile[last_name]</p>"
	. "<p class='username'>$profile[username]</p>"
	. "<p class='bio'><strong>Bio</strong>: $profile[bio]</p>"
	. "<p class='birth-date><strong>Birthdate</strong>: $profile[dob]</p>"
	. "<p class='stats'>"
	. "<span class='follower'><strong>Followers</strong>: $followerNum</span> | "
	. "<span class='following'><strong>Following</strong>: $followingNum</span> | "
	. "<span class='post-num'><strong>Posts</strong>: $postNum</span>"
	. "</p>";

echo ($memberId == $userId ? "<div><a href='/chitchat/upload_profile_pic.php'><button>Change profile picture</button></a> | <a href='/chitchat/post.php'><button>Post</button></a> | <a href='delete_account.php'><button>Delete Account</button></a></div>" : "<div><a href='/chitchat/chat.php?member_id=$memberId'><button class='chat-btn'>Chat</button></a></div>");
