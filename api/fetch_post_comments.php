<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
require_once '../includes/functions.php';

if (isset($_POST['post_id'])) {
	$userId = $_SESSION['user_id'];
	$postId = sanitize($_POST['post_id']);
	$replyToId = (isset($_POST['reply_to_id']) && !empty($_POST['reply_to_id']) ? sanitize($_POST['reply_to_id']) : null);

	if (isset($_POST['comment'])) {
		$comment = sanitize($_POST['comment']);
		comment_post($postId, $userId, $replyToId, $comment);
	} else if (isset($_POST['delete_id'])) {
		$deleteId = sanitize($_POST['delete_id']);
		delete_post_comment($deleteId, $userId);
	}

	$comments = get_post_comments($postId);

	foreach ($comments as $comment) {
		echo "<section id='$comment[id]' class='comment'>";
		if ($comment['reply_to']) represent_comment($comment['reply_to']);
		echo "<p class='comment-content'>$comment[comment]</p>"
			. "<p class='comment-info'>"
			. "<span class='author'>$comment[first_name] $comment[last_name]</span> "
			. "<span class='date'>" . date("d/M/y g:iA", strtotime($comment['date_commented'])) . "</span>"
			. "</p>"
			. "<div class='comment-action'>"
			. "<button onclick='replyToComment(\"$comment[id]\")'>Reply</button>"
			. ($userId == $comment['author'] ? "<button onclick='post(\"/chitchat/api/fetch_post_comments.php\", \"post_id=$postId&delete_id=$comment[id]\", \"commentContainer\")'>Delete</button>" : "")
			. "</div></section>";
	}
}

function represent_comment($id)
{
	$comment = get_post_comment($id);
	if (!$comment) return;

	echo "<a class='comment-reference' href='#$comment[id]'>"
		. "<p class='comment-content'>$comment[comment]</p>"
		. "<p class='comment-info'><span class='author'>$comment[first_name] $comment[last_name]</span></p>"
		. "</a>";
}
