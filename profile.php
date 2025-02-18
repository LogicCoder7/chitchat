<?php
require_once 'includes/session_start.php';
require_once 'includes/navigation_guard_user.php';

$username = $_SESSION['username'];
$member = (isset($_GET['member']) ? $_GET['member'] : $username);
?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Profile</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/profile.css">
	<link rel="stylesheet" href="assets/css/comment.css">
	<script src="assets/js/async_req.js"></script>
</head>

<body>
	<header class="main-header">
		<?php require_once 'includes/navigation_bar.php'; ?>
		<hr>

		<div id="profileContainer" class="profile-container"></div>
		<script>
			get("api/fetch_profile.php?member=<?php echo $member; ?>", "profileContainer");
		</script>

		<div class="button-container">
			<button onclick="get('api/fetch_posts.php?member=<?php echo $member ?>', 'contentContainer')">Posts</button> |
			<button onclick="get('api/fetch_profile_pics.php?member=<?php echo $member ?>', 'contentContainer')">Profile Pictures</button>
		</div>
	</header>

	<main id="contentContainer" class="content-container"></main>
	<script>
		get("api/fetch_posts.php?member=<?php echo $member; ?>", "contentContainer");
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
				<input type="hidden" name="profile_pic_id">
				<input type="hidden" name="reply_to_id">
				<input type="submit" value="Comment">
			</form>
		</div>
	</section>
	<script src="assets/js/comment.js"></script>
	<script src="assets/js/logout.js"></script>
</body>

</html>