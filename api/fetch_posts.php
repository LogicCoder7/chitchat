<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/functions.php';

$userId = $_SESSION['user_id'];
$memberId = (isset($_GET['member_id']) ? sanitize($_GET['member_id']) : $userId);

if (isset($_GET['post_id']) && isset($_GET['action'])) {
	$postId = sanitize($_GET['post_id']);
	$action = $_GET['action'];
	if ($action === "like") like_post($postId, $userId);
	else if ($action === "unlike") unlike_post($postId, $userId);
	else if ($action === "delete") delete_post($postId, $userId);
	else if ($action === "report") report_post($postId, $userId);
	else if ($action === "unreport") unreport_post($postId, $userId);
}

$posts = get_posts($memberId);

foreach ($posts as $post) {

	echo "<section class='post'>";
	echo "<div class='post-content'>";
	$postUrl = "/chitchat/uploads/posts/$post[post]";

	switch ($post['type']) {
		case "image":
			echo "<a href='$postUrl' target='_blank'><img src='$postUrl'></a>";
			break;
		case "video":
			echo "<video src='$postUrl' controls>";
			break;
		case "text":
			echo "<p>$post[post]</p>";
			break;
	}
	echo "</div>";

	echo "<p class='post-info'>"
		. "<span class='likes'>Likes: " . post_like_num($post['id']) . "</span> | "
		. "<span class='comments'>Comments: " . post_comment_num($post['id']) . "</span> | "
		. "<span class='date'>" . date("d/M/y g:iA", strtotime($post['date_posted'])) . "</span>"
		. "</p>";

	$isLiked = post_liked($post['id'], $userId);
	$isReported = post_reported($post['id'], $userId);

	echo "<div class='post-action'>"
		. "<button value='" . ($isLiked ? 'unlike' : 'like') . "' onclick='get(\"/chitchat/api/fetch_posts.php?member_id=$memberId&post_id=$post[id]&action=\"+this.value, \"contentContainer\")'>" . ($isLiked ? 'Unlike' : 'Like') . "</button>"
		. "<button onclick='openComment($post[id])'>Comment</button>"
		. (
			$userId == $memberId
			? "<button onclick='get(\"/chitchat/api/fetch_posts.php?member_id=$memberId&post_id=$post[id]&action=delete\", \"contentContainer\")'>Delete</button>"
			: "<button value='" . ($isReported ? 'unreport' : 'report') . "' onclick='get(\"/chitchat/api/fetch_posts.php?member_id=$memberId&post_id=$post[id]&action=\"+this.value, \"contentContainer\")'>" . ($isReported ? 'Unreport' : 'Report') . "</button>"
		)
		. "</div>";
	echo "</section>";
}
