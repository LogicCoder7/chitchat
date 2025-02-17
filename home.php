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
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/home.css">
	<link rel="stylesheet" href="assets/css/comment.css">
	<script src="assets/js/async_req.js"></script>
</head>

<body>
	<header>
		<?php require 'includes/navigation_bar.php'; ?>
	</header>

	<main id="postContainer"></main>
	<script>
		get("api/fetch_fyp.php", "postContainer");
	</script>

	<section id="commentSection">
		<button id="closeCommentBtn">x</button>

		<div id="commentContainer"></div>

		<div class='comment-input-container'>
			<div id="replyToContainer">
				<button id='cancelReplyBtn'>x</button>
			</div>

			<form id="commentForm" method="post" action="api/fetch_post_comments.php">
				<textarea name="comment" id="commentInput"></textarea>
				<input type="hidden" name="post_id">
				<input type="hidden" name="reply_to_id">
				<input type="submit" value="Comment">
			</form>
		</div>
	</section>

	<script src="assets/js/comment.js"></script>
	<script src="assets/js/logout.js"></script>

</body>

</html>