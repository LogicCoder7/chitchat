<?php

$mysql_host = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "chitchat_test";

$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($conn->connect_error) die("Couldn't connect to database!");

function sanitize($str)
{
	global $conn;
	return $conn->real_escape_string(htmlentities($str));
}

function clearResult()
{
	global $conn;
	while ($conn->more_results())
		$conn->next_result();
}

function create_account($username, $password, $role)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_add_user(?, ?, ?)");
	$stmt->bind_param("sss", $username, $password, $role);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_column() : false;
}

function verify_login($username, $password)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_user(?, ?)");
	$stmt->bind_param("ss", $username, $password);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_array(MYSQLI_ASSOC) : null;
}

function setup_profile($userId, $firstName, $lastName, $bio, $dob)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_add_profile(?, ?, ?, ?, ?)");
	$stmt->bind_param("issss", $userId, $firstName, $lastName, $bio, $dob);
	$stmt->execute();
}

function get_profile($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_profile(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_array(MYSQLI_ASSOC) : null;
}

function profile_pic_id()
{
	global $conn;
	$result = $conn->query("CALL sp_get_next_profile_pic_id()");
	$id = $result->fetch_column();
	clearResult();
	return $id ? $id : 1;
}

function record_profile_pic($userId, $imageName)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_add_profile_pic(?, ?)");
	$stmt->bind_param("is", $userId, $imageName);
	$stmt->execute();
}

function get_profile_pics($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_profile_pics(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_all(MYSQLI_ASSOC) : null;
}

function post_id()
{
	global $conn;
	$result = $conn->query("CALL sp_get_next_post_id()");
	$id = $result->fetch_column();
	clearResult();
	return $id ? $id : 1;
}

function record_post($userId, $post, $type)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_post(?, ?, ?)");
	$stmt->bind_param("iss", $userId, $post, $type);
	$stmt->execute();
}

function get_posts($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_posts(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_all(MYSQLI_ASSOC) : null;
}

function post_num($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_post_num(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_column() : null;
}

function get_members()
{
	global $conn;
	$result = $conn->query("CALL sp_get_users()");
	clearResult();
	return $result->fetch_all(MYSQLI_ASSOC);
}

function get_following($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_followees(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($followees[] = $result->fetch_column());
	array_pop($followees);
	return $followees;
}

function get_followers($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_followers(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	while ($followers[] = $result->fetch_column());
	array_pop($followers);
	return $followers;
}

function following_num($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_followee_num(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_column() : null;
}

function follower_num($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_follower_num(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_column() : null;
}

function follow_member($followerId, $followeeId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_follow(?, ?)");
	$stmt->bind_param("ii", $followerId, $followeeId);
	$stmt->execute();
}

function unfollow_member($followerId, $followeeId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_unfollow(?, ?)");
	$stmt->bind_param("ii", $followerId, $followeeId);
	$stmt->execute();
}

function get_following_posts($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_followee_posts(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_all(MYSQLI_ASSOC) : null;
}

function like_profile_pic($profilePicId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_like_profile_pic(?, ?)");
	$stmt->bind_param("ii", $profilePicId, $userId);
	$stmt->execute();
}

function unlike_profile_pic($profilePicId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_unlike_profile_pic(?, ?)");
	$stmt->bind_param("ii", $profilePicId, $userId);
	$stmt->execute();
}

function profile_pic_like_num($profilePicId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_profile_pic_like_num(?)");
	$stmt->bind_param("i", $profilePicId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_column() : null;
}

function profile_pic_liked($profilePicId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_is_profile_pic_liked(?, ?)");
	$stmt->bind_param("ii", $profilePicId, $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result->num_rows === 1;
}

function like_post($postId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_like_post(?, ?)");
	$stmt->bind_param("ii", $postId, $userId);
	$stmt->execute();
}

function unlike_post($postId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_unlike_post(?, ?)");
	$stmt->bind_param("ii", $postId, $userId);
	$stmt->execute();
}

function post_like_num($postId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_post_like_num(?)");
	$stmt->bind_param("i", $postId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_column() : null;
}

function post_liked($postId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_is_post_liked(?, ?)");
	$stmt->bind_param("ii", $postId, $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result->num_rows === 1;
}

function comment_profile_pic($profilePicId, $userId, $replyToId, $comment)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_comment_on_profile_pic(?, ?, ?, ?)");
	$stmt->bind_param("iiis", $profilePicId, $userId, $replyToId, $comment);
	$stmt->execute();
}

function delete_profile_pic_comment($commentId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_delete_profile_pic_comment(?, ?)");
	$stmt->bind_param("ii", $commentId, $userId);
	$stmt->execute();
}

function get_profile_pic_comments($profilePicId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_profile_pic_comments(?)");
	$stmt->bind_param("i", $profilePicId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_all(MYSQLI_ASSOC) : null;
}

function get_profile_pic_comment($commentId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_profile_pic_comment(?)");
	$stmt->bind_param("i", $commentId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_array(MYSQLI_ASSOC) : null;
}

function profile_pic_comment_num($profilePicId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_profile_pic_comment_num(?)");
	$stmt->bind_param("i", $profilePicId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_column() : null;
}

function comment_post($postId, $userId, $replyToId, $comment)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_comment_on_post(?, ?, ?, ?)");
	$stmt->bind_param("iiis", $postId, $userId, $replyToId, $comment);
	$stmt->execute();
}

function delete_post_comment($commentId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_delete_post_comment(?, ?)");
	$stmt->bind_param("ii", $commentId, $userId);
	$stmt->execute();
}

function get_post_comments($postId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_post_comments(?)");
	$stmt->bind_param("i", $postId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_all(MYSQLI_ASSOC) : null;
}

function get_post_comment($commentId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_post_comment(?)");
	$stmt->bind_param("i", $commentId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_array(MYSQLI_ASSOC) : null;
}

function post_comment_num($postId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_post_comment_num(?)");
	$stmt->bind_param("i", $postId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_column() : null;
}

function message($author, $recipent, $replyToId, $message, $type)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_message(?, ?, ?, ?, ?)");
	$stmt->bind_param("iiiss", $author, $recipent, $replyToId, $message, $type);
	$stmt->execute();
}

function get_messages($userId1, $userId2)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_messages(?, ?)");
	$stmt->bind_param("ii", $userId1, $userId2);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_all(MYSQLI_ASSOC) : null;
}

function get_message($messageId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_message(?)");
	$stmt->bind_param("i", $messageId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_array(MYSQLI_ASSOC) : null;
}

function get_messages_involving_user($userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_get_messages_involving_user(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result ? $result->fetch_array(MYSQLI_ASSOC) : null;
}

function message_id()
{
	global $conn;
	$result = $conn->query("CALL sp_get_next_message_id()");
	$id = $result->fetch_column();
	clearResult();
	return $id ? $id : 1;
}

function report_post($postId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_report_post(?, ?)");
	$stmt->bind_param("ii", $postId, $userId);
	$stmt->execute();
}

function unreport_post($postId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_delete_post_report(?, ?)");
	$stmt->bind_param("ii", $postId, $userId);
	$stmt->execute();
}

function post_reported($postId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_is_post_reported(?, ?)");
	$stmt->bind_param("ii", $postId, $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	return $result->num_rows === 1;
}

function get_post_reports()
{
	global $conn;
	$result = $conn->query("CALL sp_get_reported_posts()");
	clearResult();
	return $result->fetch_all(MYSQLI_ASSOC);
}

function delete_post_reports($postId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_delete_post_reports(?)");
	$stmt->bind_param("i", $postId);
	$stmt->execute();
}

function delete_profile_pic($profilePicId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_delete_profile_pic(?, ?)");
	$stmt->bind_param("ii", $profilePicId, $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!$result || !$result->num_rows) return;
	$imageName = $result->fetch_column();
	unlink(__DIR__ . "/../uploads/profile_pics/$imageName");
}

function delete_post($postId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_delete_post(?, ?)");
	$stmt->bind_param("ii", $postId, $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!$result || !$result->num_rows) return;
	$fileName = $result->fetch_column();
	unlink(__DIR__ . "/../uploads/posts/$fileName");
}

function delete_message($messageId, $userId)
{
	global $conn;
	$stmt = $conn->prepare("CALL sp_delete_message(?, ?)");
	$stmt->bind_param("ii", $messageId, $userId);
	$stmt->execute();
	$result = $stmt->get_result();
	if (!$result || !$result->num_rows) return;
	$fileName = $result->fetch_column();
	unlink(__DIR__ . "/../uploads/messages/$fileName");
}

function delete_account($userId)
{
	$profilePics = get_profile_pics($userId);
	foreach ($profilePics as $profilePic)
		delete_profile_pic($profilePic['id'], $userId);

	$posts = get_posts($userId);
	foreach ($posts as $post)
		delete_post($post['id'], $userId);

	$messages = get_messages_involving_user($userId);
	foreach ($messages as $message)
		delete_message($message['id'], $message['author']);

	global $conn;
	$stmt = $conn->prepare("CALL sp_delete_user(?)");
	$stmt->bind_param("i", $userId);
	$stmt->execute();
}
