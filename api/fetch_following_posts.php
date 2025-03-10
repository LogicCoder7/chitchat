<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/database_access.php';

$userId = $_SESSION['user_id'];

if (isset($_GET['action']) && isset($_GET['post_id'])) {
	$action = $_GET['action'];
	$postId = sanitize($_GET['post_id']);
	if ($action === "like") like_post($postId, $userId);
	else if ($action === "unlike") unlike_post($postId, $userId);
	else if ($action === "report") report_post($postId, $userId);
	else if ($action === "unreport") unreport_post($postId, $userId);
}

$posts = get_followee_posts($userId);

foreach ($posts as $post) {
	echo "<section class='post'>";
	echo "<div class='post-content'>";
	$contentUrl = $post['content_type'] !== "TEXT" ? "/chitchat/uploads/posts/$post[content]" : null;

	switch ($post['content_type']) {
		case "IMAGE":
			echo "<a href='$contentUrl' target='_blank'><img src='$contentUrl'></a>";
			break;
		case "VIDEO":
			echo "<video src='$contentUrl' controls>";
			break;
		case "TEXT":
			echo "<p>$post[content]</p>";
			break;
	}
	echo "</div>";

	echo "<p class='post-info'>"
		. "<span class='author'>$post[first_name] $post[last_name]</span> | "
		. "<span class='likes'>Likes: " . get_post_like_num($post['id']) . "</span> | "
		. "<span class='comments'>Comments: " . get_post_comment_num($post['id']) . "</span> | "
		. "<span class='date'>" . date("d/M/y g:iA", strtotime($post['date_posted'])) . "</span>"
		. "</p>";


	$isLiked = is_post_liked($post['id'], $userId);
	$isReported = is_post_reported($post['id'], $userId);

	echo "<div class='post-action'>"
		. "<button value='" . ($isLiked ? 'unlike' : 'like') . "' onclick='get(\"/chitchat/api/fetch_following_posts.php?post_id=$post[id]&action=\"+this.value, \"postContainer\")'>" . ($isLiked ? 'Unlike' : 'Like') . "</button>"
		. "<button onclick='openComment($post[id])'>Comment</button>"
		. "<button value='" . ($isReported ? 'unreport' : 'report') . "' onclick='get(\"/chitchat/api/fetch_following_posts.php?post_id=$post[id]&action=\"+this.value, \"postContainer\")'>" . ($isReported ? 'Unreport' : 'Report') . "</button>"
		. "</div>";

	echo "</section>";
}
