<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/database_access.php';

$userId = $_SESSION['user_id'];

if (isset($_GET['action']) && isset($_GET['user_id'])) {
	$action = $_GET['action'];
	$memberId = sanitize($_GET['user_id']);

	if ($action === "follow") follow($userId, $memberId);
	else if ($action === "unfollow") unfollow($userId, $memberId);
}

$users = get_users();
$followees = get_followees($userId);
$followers = get_followers($userId);
$view = (isset($_GET['view']) ? $_GET['view'] : "all");

foreach ($users as $user) {
	if (($view != "following" && $view != "followers" && $user['id'] != $userId) ||
		($view == "following" && in_array($user['id'], $followees)) ||
		($view == "followers" && in_array($user['id'], $followers))
	) {
		$profilePics = get_profile_pics($user['id']);
		$profilePicUrl = ($profilePics ? "/chitchat/uploads/profile_pics/{$profilePics[0]['image_name']}" : "/chitchat/assets/img/profile_pic.png");
		echo "<section class='user'>"

			. "<div class='user-preview'>"
			. "<a class='user-link' href='/chitchat/profile.php?user_id=$user[id]'>"
			. "<img class='profile-picture' src='$profilePicUrl'>"
			. "<p class='name'>$user[first_name] $user[last_name]</p>"
			. "<p class='username'>$user[username]</p>"
			. "</a>"
			. "</div>"

			. "<div class='user-action'>"
			. (in_array($user['id'], $followers) && $view != "followers" ? "<p class='follower-indicator'>follows you</p>" : "")
			. "<button value='" . (in_array($user['id'], $followees) ? "unfollow" : "follow") . "' onclick='get(\"/chitchat/api/fetch_users.php?view=$view&user_id=$user[id]&action=\"+this.value, \"userContainer\")'>" . (in_array($user['id'], $followees) ? "Unfollow" : "Follow") . "</button>"
			. "<a href='/chitchat/chat.php?user_id=$user[id]'><button>Chat</button></a>"
			. "</div>"

			. "</section>";
	}
}
