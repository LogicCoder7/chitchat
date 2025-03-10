<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/database_access.php';

$userId = $_SESSION['user_id'];
$memberId = (isset($_GET['user_id']) ? sanitize($_GET['user_id']) : $userId);

if (isset($_GET['profile_pic_id']) && isset($_GET['action'])) {
	$profilePicId = sanitize($_GET['profile_pic_id']);
	$action = $_GET['action'];
	if ($action === "like") like_profile_pic($profilePicId, $userId);
	else if ($action === "unlike") unlike_profile_pic($profilePicId, $userId);
	else if ($action === "delete") delete_profile_pic($profilePicId, $userId);
}

$profilePics = get_profile_pics($memberId);

foreach ($profilePics as $profilePic) {
	echo "<section class='profile-pic'>";

	echo "<div>";
	$profilePicUrl = "/chitchat/uploads/profile_pics/$profilePic[image_name]";
	echo "<a href='$profilePicUrl' target='_blank'><image class='profile-pic-image' src='$profilePicUrl'></a>"
		. "</div>";

	echo "<p class='profile-pic-info'>"
		. "<span class='likes'>Likes: " . get_profile_pic_like_num($profilePic['id']) . "</span> | "
		. "<span class='comments'>Comments: " . get_profile_pic_comment_num($profilePic['id']) . "</span> | "
		. "<span class='date'>" . date("d/M/y g:iA", strtotime($profilePic['date_uploaded'])) . "</span>"
		. "</p>";

	$isLiked = is_profile_pic_liked($profilePic['id'], $userId);

	echo "<div class='profile-pic-action'>"
		. "<button value='" . ($isLiked ? "unlike" : "like") . "' onclick='get(\"/chitchat/api/fetch_profile_pics.php?user_id=$memberId&profile_pic_id=$profilePic[id]&action=\"+this.value, \"contentContainer\")'>" . ($isLiked ? "Unlike" : "Like") . "</button>"
		. "<button onclick='openComment($profilePic[id], false)'>Comment</button>"
		. ($userId == $memberId ? "<button onclick='get(\"/chitchat/api/fetch_profile_pics.php?user_id=$memberId&profile_pic_id=$profilePic[id]&action=delete\", \"contentContainer\")'>Delete</button>" : "")
		. "</div>";

	echo "</section>";
}
