<?php
require_once 'includes/session_start.php';
require_once 'includes/navigation_guard_user.php';
require_once 'includes/functions.php';

$member = (isset($_GET['member']) ? sanitize($_GET['member']) : null);
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
	<header id="headerContainer">
		<?php require_once 'includes/navigation_bar.php'; ?>
	</header>

	<main id="messageContainer"></main>

	<script>
		post("api/fetch_messages.php", "member=<?php echo $member ?>", "messageContainer")

		setInterval(() => {
			post("api/fetch_messages.php", "member=<?php echo $member ?>", "messageContainer")
		}, 2000);
	</script>

	<section id="inputContainer">
		<div id="replyToSection">
			<button id='cancelReplyBtn'>x</button>
		</div>

		<div style='text-align: left'>
			<button id="textInputBtn">Text</button>
			<button id="fileInputBtn">Image/Video</button>
		</div>

		<form method="post" action="api/fetch_messages.php" enctype="multipart/form-data">
			<textarea name="message"></textarea>
			<input type="hidden" name="member" value="<?php echo $member ?>">
			<input type="hidden" name="reply_to_id">
			<button type="submit">Send</button>
		</form>
	</section>
	<script src="assets/js/chat.js"></script>
	<script src="assets/js/logout.js"></script>
</body>

</html>