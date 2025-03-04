<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/functions.php';

$userId = $_SESSION['user_id'];

if (isset($_GET['action']) && isset($_GET['member_id'])) {
	$action = $_GET['action'];
	$memberId = sanitize($_GET['member_id']);

	if ($action === "follow") follow_member($userId, $memberId);
	else if ($action === "unfollow") unfollow_member($userId, $memberId);
}

$members = get_members();
$followings = get_following($userId);
$followers = get_followers($userId);
$view = (isset($_GET['view']) ? $_GET['view'] : "members");

foreach ($members as $member) {
	if (($view != "following" && $view != "followers" && $member['id'] != $userId) ||
		($view == "following" && in_array($member['id'], $followings)) ||
		($view == "followers" && in_array($member['id'], $followers))
	) {
		$profilePic = get_profile_pics($member['id']);
		$profilePic = (count($profilePic) ? "/chitchat/uploads/profile_pics/{$profilePic[0]['image_name']}" : "/chitchat/assets/img/profile_pic.png");
		echo "<section class='member'>"
			. "<div class='member-preview'>"
			. "<a class='member-link' href='/chitchat/profile.php?member_id=$member[id]'>"
			. "<img class='profile-picture' src='$profilePic'>"
			. "<p class='name'>$member[first_name] $member[last_name]</p>"
			. "<p class='username'>$member[username]</p>"
			. "</a>"
			. "</div>"
			. "<div class='member-action'>"
			. (in_array($member['id'], $followers) && $view != "followers" ? "<p class='follower-indicator'>follows you</p>" : "")
			. "<button value='" . (in_array($member['id'], $followings) ? "unfollow" : "follow") . "' onclick='get(\"/chitchat/api/fetch_members.php?view=$view&member_id=$member[id]&action=\"+this.value, \"memberContainer\")'>" . (in_array($member['id'], $followings) ? "Unfollow" : "Follow") . "</button>"
			. "<a href='/chitchat/chat.php?member_id=$member[id]'><button>Chat</button></a>"
			. "</div>"
			. "</section>";
	}
}
