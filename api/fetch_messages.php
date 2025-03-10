<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
$userId = $_SESSION['user_id'];

if (isset($_POST['user_id'])) {

	require_once '../includes/database_access.php';
	$errorMessage = null;
	$memberId = sanitize($_POST['user_id']);
	$replyToId = (isset($_POST['reply_to_id']) && !empty($_POST['reply_to_id']) ? sanitize($_POST['reply_to_id']) : null);

	if ($_FILES) {
		$imageTypes = array("jpg", "jpeg", "png", "gif");
		$videoTypes = array("mp4", "mkv", "ogg");
		$file = pathinfo($_FILES['message']['name']);
		$ext = $file['extension'];

		if (in_array($ext, $imageTypes) || in_array($ext, $videoTypes)) {
			$fileName = get_next_message_id();
			$fileType = (in_array($ext, $imageTypes) ? "IMAGE" : "VIDEO");
			$fileDestination = "../uploads/messages/$fileName";
			move_uploaded_file($_FILES['message']['tmp_name'], $fileDestination);
			message($userId, $memberId, $replyToId, $fileName, $fileType);
		} else $errorMessage = "Unsupported image/video type!";
	} else if (isset($_POST['message'])) {
		$message = sanitize($_POST['message']);
		message($userId, $memberId, $replyToId, $message, "text");
	} else if (isset($_POST['delete_id'])) {
		$deleteId = sanitize($_POST['delete_id']);
		delete_message($deleteId, $userId);
	}

	$messages = get_messages($userId, $memberId);

	foreach ($messages as $message) {
		echo "<section id='$message[id]' class='message'>";

		if ($message['reply_to']) represent_message($message['reply_to']);

		echo "<div class='message-content'>";
		$messageUrl = $message['content_type'] != "TEXT" ? "/chitchat/uploads/messages/$message[content]" : null;

		switch ($message['content_type']) {
			case "IMAGE":
				echo "<a href='$messageUrl' target='_blank'><img src='$messageUrl'></a>";
				break;
			case "VIDEO":
				echo "<video src='$messageUrl' controls>";
				break;
			case "TEXT":
				echo "<p>$message[content]</p>";
				break;
		}
		echo "</div>";

		echo  "<p class='message-info'>"
			. "<span class='author'>$message[first_name] $message[last_name]</span> "
			. "<span class='date'>" . date("d/M/y g:iA", strtotime($message['date_messaged'])) . "</span>"
			. "</p>";

		echo  "<div class='message-action'>"
			. "<button onclick='replyToMessage(\"$message[id]\")'>Reply</button>"
			. ($userId == $message['author'] ? "<button onclick='post(\"/chitchat/api/fetch_messages.php\", \"user_id=$memberId&delete_id=$message[id]\", \"messageContainer\")'>Delete</button>" : "")
			. "</div>";

		echo "</section>";
	}
}


function represent_message($messageId)
{
	$message = get_message($messageId);
	if (!$message) return;
	echo "<a class='message-reference' href='#$message[id]' >";

	echo "<div class='message-content'>";
	$messageUrl = $message['content_type'] !== "TEXT" ? "/chitchat/uploads/messages/$message[content]" : null;
	switch ($message['content_type']) {
		case "IMAGE":
			echo "<img src='$messageUrl'>";
			break;
		case "VIDEO":
			echo "<video src='$messageUrl'>";
			break;
		case "TEXT":
			echo "<p>$message[content]</p>";
			break;
	}
	echo "</div>";

	echo "<div class='message-info'><p>"
		. "<span class='author'>$message[first_name] $message[last_name]</span>"
		. "</p></div>";

	echo "</a>";
}
