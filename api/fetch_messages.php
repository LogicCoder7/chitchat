<?php
require_once '../includes/session_start.php';
require '../includes/request_guard_user.php';
$username = $_SESSION['username'];

if (isset($_POST['member'])) {

	require_once '../includes/functions.php';
	$errorMessage = null;
	$member = sanitize($_POST['member']);
	$replyToId = (isset($_POST['reply_to_id']) ? sanitize($_POST['reply_to_id']) : null);

	if ($_FILES) {
		$imageTypes = array("jpg", "jpeg", "png", "gif");
		$videoTypes = array("mp4", "mkv", "ogg");
		$file = pathinfo($_FILES['message']['name']);
		$ext = $file['extension'];

		if (in_array($ext, $imageTypes) || in_array($ext, $videoTypes)) {
			$fileName = message_id();
			$fileType = (in_array($ext, $imageTypes) ? "image" : "video");
			$fileDestination = "../uploads/messages/$fileName";
			move_uploaded_file($_FILES['message']['tmp_name'], $fileDestination);
			message($username, $member, $fileName, $fileType, $replyToId);
		} else $errorMessage = "Unsupported image/video type!";
	} else if (isset($_POST['message'])) {
		$message = sanitize($_POST['message']);
		message($username, $member, $message, "text", $replyToId);
	} else if (isset($_POST['delete_id'])) {
		$deleteId = sanitize($_POST['delete_id']);
		delete_message($deleteId, $username);
	}

	$messages = get_messages($username, $member);

	foreach ($messages as $message) {
		echo "<section id='$message[id]' class='message'>";

		if ($message['reply_to']) represent_message($message['reply_to'], $username, $member);

		echo "<div class='message-content'>";
		$messageUrl = "/chitchat/uploads/messages/$message[message]";

		switch ($message['type']) {
			case "image":
				echo "<a href='$messageUrl' target='_blank'><img src='$messageUrl'></a>";
				break;
			case "video":
				echo "<video src='$messageUrl' controls>";
				break;
			case "text":
				echo "<p>$message[message]</p>";
				break;
		}
		echo "</div>";

		echo  "<p class='message-info'>"
			. "<span class='author'>$message[firstname] $message[lastname]</span> "
			. "<span class='date'>" . date("d/M/y g:iA", strtotime($message['date'])) . "</span>"
			. "</p>";

		echo  "<div class='message-action'>"
			. "<button onclick='replyToMessage(\"$message[id]\")'>Reply</button>"
			. ($username === $message['sender'] ? "<button onclick='post(\"/chitchat/api/fetch_messages.php\", \"member=$member&delete_id=$message[id]\", \"messageContainer\")'>Delete</button>" : "")
			. "</div>";

		echo "</section>";
	}
}


function represent_message($messageId, $username, $member)
{
	$message = get_message($messageId, $username, $member);
	if (!$message) return;
	echo "<a class='message-reference' href='#$message[id]' >";

	echo "<div class='message-content'>";
	$messageUrl = "/chitchat/uploads/messages/$message[message]";
	switch ($message['type']) {
		case "image":
			echo "<img src='$messageUrl'>";
			break;
		case "video":
			echo "<video src='$messageUrl'>";
			break;
		case "text":
			echo "<p>$message[message]</p>";
			break;
	}
	echo "</div>";

	echo "<div class='message-info'><p>"
		. "<span class='author'>$message[firstname] $message[lastname]</span>"
		. "</p></div>";

	echo "</a>";
}
