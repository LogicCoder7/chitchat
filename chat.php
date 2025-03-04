<?php
require_once 'includes/session_start.php';
require_once 'includes/navigation_guard_user.php';
require_once 'includes/functions.php';

$memberId = (isset($_GET['member_id']) ? sanitize($_GET['member_id']) : null);
?>

<!DOCTYPE html>

<html>

<head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Chat</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/chat.css">
	<script src="assets/js/async_req.js"></script>
</head>

<body>
	<header class="main-header">
		<?php require_once 'includes/navigation_bar.php'; ?>
	</header>

	<main id="messageContainer" class="message-container"></main>

	<script>
		post("api/fetch_messages.php", "member_id=<?php echo $memberId ?>", "messageContainer")

		// setInterval(() => {
		// 	post("api/fetch_messages.php", "member_id=<?php echo $memberId ?>", "messageContainer")
		// }, 2000);
	</script>

	<section id="inputContainer" class="input-container">
		<div id="replyToSection" class="reply-to-section">
			<button id="cancelReplyBtn" class="cancel-reply-btn">x</button>
		</div>

		<div>
			<button id="textInputBtn">Text</button>
			<button id="fileInputBtn">Image/Video</button>
		</div>

		<form class="message-form" method="post" action="api/fetch_messages.php" enctype="multipart/form-data">
			<textarea name="message"></textarea>
			<input type="hidden" name="member_id" value="<?php echo $memberId ?>">
			<input type="hidden" name="reply_to_id">
			<button type="submit" class="send-btn">Send</button>
		</form>
	</section>
	<script src="assets/js/chat.js"></script>
	<script src="assets/js/logout.js"></script>
</body>

</html>