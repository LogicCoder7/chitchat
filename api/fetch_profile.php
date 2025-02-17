<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/functions.php';

$username = $_SESSION['username'];
$member = (isset($_GET['member']) ? sanitize($_GET['member']) : $username);

$profile       = get_profile($member);
$profilePics  = get_profile_pics($member);
$profilePicSrc   = (count($profilePics) ? "/chitchat/uploads/profile_pics/" . $profilePics[0]['source'] : "/chitchat/assets/img/profile_pic.png");
$followerNum  = follower_num($member);
$followingNum = following_num($member);
$postNum      = post_num($member);

echo "<a class='profile-picture-container' href='$profilePicSrc' target='_blank'><img class='profile-picture' src='$profilePicSrc'></a>"
	. "<p class='name'>$profile[firstname] $profile[lastname]</p>"
	. "<p class='username'>$profile[username]</p>"
	. "<p class='bio'><strong>Bio</strong>: $profile[bio]</p>"
	. "<p class='birth-date><strong>Birthdate</strong>: $profile[birthdate]</p>"
	. "<p class='stats'>"
	. "<span class='follower'><strong>Followers</strong>: $followerNum</span> | "
	. "<span class='following'><strong>Following</strong>: $followingNum</span> | "
	. "<span class='post-num'><strong>Posts</strong>: $postNum</span>"
	. "</p>";

echo ($member === $username ? "<div><a href='/chitchat/upload_profile_pic.php'><button>Change profile picture</button></a> | <a href='/chitchat/post.php'><button>Post</button></a> | <a href='delete_account.php'><button>Delete Account</button></a></div>" : "<div><a href='/chitchat/chat.php?member=$member'><button class='chat-btn'>Chat</button></a></div>");
