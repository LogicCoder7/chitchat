<?php
require_once 'includes/session_start.php';
require_once 'includes/navigation_guard_user.php';
?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/css/general.css">
	<link rel="stylesheet" href="assets/css/following_posts.css">
	<link rel="stylesheet" href="assets/css/comment.css">
	<script src="assets/js/async_req.js"></script>
</head>

<body>
	<header class="main-header">
		<?php require 'includes/navigation_bar.php'; ?>
	</header>

	<main id="postContainer" class="post-container"></main>
	<script>
		get("api/fetch_following_posts.php", "postContainer");
	</script>

	<section id="commentSection" class="comment-section">
		<button id="closeCommentBtn" class="close-comment-btn">x</button>

		<div id="commentContainer" class="comment-container"></div>

		<div class="comment-input-container">
			<div id="replyToContainer" class="reply-to-container">
				<button id="cancelReplyBtn" class="cancel-reply-btn">x</button>
			</div>

			<form id="commentForm" class="comment-form" method="post" action="api/fetch_post_comments.php">
				<textarea name="comment" id="commentInput"></textarea>
				<input type="hidden" name="post_id">
				<input type="hidden" name="reply_to_id">
				<button type="submit" class="comment-btn">Comment</button>
			</form>
		</div>
	</section>

	<script src="assets/js/comment.js"></script>
	<script src="assets/js/confirm_logout.js"></script>
</body>

</html>