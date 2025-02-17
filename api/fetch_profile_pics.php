<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/functions.php';

$username = $_SESSION['username'];
$member = (isset($_GET['member']) ? sanitize($_GET['member']) : $username);

if (isset($_GET['profile_pic_id']) && isset($_GET['action'])) {
	$profilePicId = sanitize($_GET['profile_pic_id']);
	$action = $_GET['action'];
	if ($action === "like") like_profile_pic($profilePicId, $username);
	else if ($action === "unlike") unlike_profile_pic($profilePicId, $username);
	else if ($action === "delete") delete_profile_pic($profilePicId, $username);
}

$profilePics = get_profile_pics($member);

foreach ($profilePics as $profilePic) {
	echo "<section class='post'>";

	echo "<div class='post-content'>"
		. "<a href='/chitchat/uploads/profile_pics/$profilePic[source]' target='_blank'><image src='/chitchat/uploads/profile_pics/$profilePic[source]'></a>"
		. "</div>";

	echo "<p class='post-info'>"
		. "<span class='likes'>Likes: " . profile_pic_like_num($profilePic['id']) . "</span> | "
		. "<span class='comments'>Comments: " . profile_pic_comment_num($profilePic['id']) . "</span> | "
		. "<span class='date'>" . date("d/M/y g:iA", strtotime($profilePic['date'])) . "</span>"
		. "</p>";

	$isLiked = profile_pic_liked($profilePic['id'], $username);

	echo "<div class='post-action'>"
		. "<button value='" . ($isLiked ? "unlike" : "like") . "' onclick='get(\"/chitchat/api/fetch_profile_pics.php?member=$member&profile_pic_id=$profilePic[id]&action=\"+this.value, \"contentContainer\")'>" . ($isLiked ? "Unlike" : "Like") . "</button>"
		. "<button onclick='openComment($profilePic[id], false)'>Comment</button>"
		. ($username === $member ? "<button onclick='get(\"/chitchat/api/fetch_profile_pics.php?member=$member&profile_pic_id=$profilePic[id]&action=delete\", \"contentContainer\")'>Delete</button>" : "")
		. "</div>";

	echo "</section>";
}
