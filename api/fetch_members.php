<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/functions.php';

$username = $_SESSION['username'];

if (isset($_GET['action']) && isset($_GET['member'])) {
	$action = $_GET['action'];
	$member = sanitize($_GET['member']);

	if ($action === "follow") follow_member($username, $member);
	else if ($action === "unfollow") unfollow_member($username, $member);
}

$members = get_members();
$followings = get_following($username);
$followers = get_followers($username);
$view = (isset($_GET['view']) ? $_GET['view'] : "members");

foreach ($members as $member) {
	if (($view != "following" && $view != "followers" && $member['username'] != $username) ||
		($view == "following" && in_array($member['username'], $followings)) ||
		($view == "followers" && in_array($member['username'], $followers))
	) {
		$profilePic = get_profile_pics($member['username']);
		$profilePic = (count($profilePic) ? "/chitchat/uploads/profile_pics/{$profilePic[0]['source']}" : "/chitchat/assets/img/profile_pic.png");
		echo "<section class='member'>"
			. "<div class='member-preview'>"
			. "<a class='member-link' href='/chitchat/profile.php?member=$member[username]'>"
			. "<img class='profile-picture' src='$profilePic'>"
			. "<p class='name'>$member[firstname] $member[lastname]</p>"
			. "<p class='username'>$member[username]</p>"
			. "</a>"
			. "</div>"
			. "<div class='member-action'>"
			. (in_array($member['username'], $followers) && $view != "followers" ? "<p class='follower-indicator'>follows you</p>" : "")
			. "<button value='" . (in_array($member['username'], $followings) ? "unfollow" : "follow") . "' onclick='get(\"/chitchat/api/fetch_members.php?view=$view&member=$member[username]&action=\"+this.value, \"memberContainer\")'>" . (in_array($member['username'], $followings) ? "Unfollow" : "Follow") . "</button>"
			. "<a href='/chitchat/chat.php?member=$member[username]'><button>Chat</button></a>"
			. "</div>"
			. "</section>";
	}
}
