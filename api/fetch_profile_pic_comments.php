<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';

if (isset($_POST['profile_pic_id'])) {

	require_once '../includes/functions.php';
	$username = $_SESSION['username'];
	$profilePicId = sanitize($_POST['profile_pic_id']);

	if (isset($_POST['comment'])) {
		$comment = sanitize($_POST['comment']);
		$replyToId = (isset($_POST['reply_to_id']) ? sanitize($_POST['reply_to_id']) : null);
		comment_profile_pic($profilePicId, $username, $comment, $replyToId);
	} else if (isset($_POST['delete_id'])) {
		$deleteId = sanitize($_POST['delete_id']);
		delete_profile_pic_comment($deleteId, $username);
	}

	$comments = get_profile_pic_comments($profilePicId);

	foreach ($comments as $comment) {
		echo "<section id='$comment[id]' class='comment'>";
		if ($comment['reply_to']) represent_comment($comment['reply_to']);
		echo "<p class='comment-content'>$comment[comment]</p>"
			. "<p class='comment-info'>"
			. "<span class='author'>$comment[firstname] $comment[lastname]</span> "
			. "<span class='date'>" . date("d/M/y g:iA", strtotime($comment['date'])) . "</span>"
			. "</p>"
			. "<div class='comment-action'>"
			. "<button onclick='replyToComment(\"$comment[id]\")'>Reply</button>"
			. ($username === $comment['username'] ? "<button onclick='post(\"/chitchat/api/fetch_profile_pic_comments.php\", \"profile_pic_id=$profilePicId&delete_id=$comment[id]\", \"commentContainer\")'>Delete</button>" : "")
			. "</div></section>";
	}
}

function represent_comment($id)
{
	$comment = get_profile_pic_comment($id);
	if (!$comment) return;

	echo "<a class='comment-reference' href='#$comment[id]'>"
		. "<p class='comment-content'>$comment[comment]</p>"
		. "<p class='comment-info'><span class='author'>$comment[firstname] $comment[lastname]</span></p>"
		. "</a>";
}
