<?php

$mysql_host = "localhost";
$mysql_username = "root";
$mysql_password = "";
$mysql_database = "chitchat";

$conn = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
if ($conn->connect_error) die("Couldn't connect to database!");

function query($query, $error = "database access")
{
	global $conn;
	$result = $conn->query($query);
	if (!$result) die("Error: " . $error);
	return $result;
}

function sanitize($str)
{
	global $conn;
	return $conn->real_escape_string(htmlentities($str));
}

function insert_id()
{
	global $conn;
	return $conn->insert_id;
}

function create_account($username, $password, $role)
{
	$result = query("SELECT * FROM members WHERE username='$username'", "create_account");
	if (!$result->num_rows) {
		query("INSERT INTO members(username, password, role) VALUES('$username', '$password', '$role')", "create_account");
		return true;
	}
	return false;
}

function verify_login($username, $password)
{
	$result = query("SELECT username, role FROM members WHERE username='$username' AND password='$password'", "verify_login");
	return $result->fetch_array(MYSQLI_ASSOC);
}

function setup_profile($username, $fn, $ln, $bio, $bd)
{
	$result = query("SELECT * FROM profiles WHERE username='$username'", "setup_profile");
	if (!$result->num_rows) query("INSERT INTO profiles(username, firstname, lastname, bio, birthdate) VALUES('$username', '$fn', '$ln', '$bio', '$bd')", "setup_profile");
}

function get_profile($username)
{
	$result = query("SELECT * FROM profiles WHERE username='$username'", "get_profile");
	return $result->fetch_array(MYSQLI_ASSOC);
}

function profile_pic_id()
{
	$result = query("SELECT id FROM profile_pics ORDER BY id DESC LIMIT 1", "profile_pic_id");
	$id = $result->fetch_array();
	return ($id ? ++$id[0] : 1);
}

function record_profile_pic($username, $src)
{
	query("INSERT INTO profile_pics(username, source) VALUES('$username', '$src')", "record_profile_pic");
}

function get_profile_pics($username)
{
	$result = query("SELECT * FROM profile_pics WHERE username='$username' ORDER BY date DESC", "get_profile_pics");
	$profile_pics = array();
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) $profile_pics[] = $tmp;
	return $profile_pics;
}

function post_id()
{
	$result = query("SELECT id FROM posts WHERE type!='text' ORDER BY id DESC LIMIT 1", "post_id");
	$id = $result->fetch_array();
	return ($id ? ++$id[0] : 1);
}

function record_post($username, $post, $type)
{
	query("INSERT INTO posts(username, post, type) VALUES('$username', '$post', '$type')", "record_post");
}

function get_posts($username)
{
	$result = query("SELECT * FROM posts WHERE username='$username' ORDER BY date DESC", "get_posts");
	$posts = array();
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) $posts[] = $tmp;
	return $posts;
}

function post_num($username)
{
	$result = query("SELECT COUNT(*) FROM posts WHERE username='$username'", "post_num");
	$num = $result->fetch_array();
	return $num[0];
}

function get_members()
{
	$result = query("SELECT firstname, lastname, username FROM profiles", "get_members");
	$members = array();
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) $members[] = $tmp;
	return $members;
}

function get_following($username)
{
	$result = query("SELECT username FROM followers WHERE follower='$username'", "get_following");
	$following = array();
	while ($tmp = $result->fetch_array()) $following[] = $tmp[0];
	return $following;
}

function get_followers($username)
{
	$result = query("SELECT follower FROM followers WHERE username='$username'", "get_followers");
	$followers = array();
	while ($tmp = $result->fetch_array()) $followers[] = $tmp[0];
	return $followers;
}

function following_num($username)
{
	$result = query("SELECT COUNT(username) FROM followers WHERE follower='$username'", "following_num");
	$num = $result->fetch_array();
	return $num[0];
}

function follower_num($username)
{
	$result = query("SELECT COUNT(follower) FROM followers WHERE username='$username'", "follower_num");
	$num = $result->fetch_array();
	return $num[0];
}

function follow_member($username, $member)
{
	$result = query("SELECT * FROM followers WHERE username='$member' AND follower='$username'", "follow");
	if (!$result->num_rows) query("INSERT INTO followers(username, follower) VALUES('$member', '$username')", "unfollow");
}

function unfollow_member($username, $member)
{
	query("DELETE FROM followers WHERE username='$member' AND follower='$username'", "unfollow");
}

function get_following_posts($username)
{ //check required on query
	$result = query("SELECT profiles.username, profiles.firstname, profiles.lastname, posts.id, posts.post, posts.type, posts.date FROM profiles, posts, followers WHERE followers.follower='$username' AND followers.username=profiles.username AND followers.username=posts.username ORDER BY posts.date DESC", "get_following_posts");
	$posts = array();
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) $posts[] = $tmp;
	return $posts;
}

function like_profile_pic($id, $username)
{
	$result = query("SELECT * FROM profile_pic_likes WHERE profile_pic_id='$id' AND username='$username'", "like_profile_pic");
	if (!$result->num_rows) query("INSERT INTO profile_pic_likes(profile_pic_id, username) VALUES('$id', '$username')", "like_profile_pic");
}

function unlike_profile_pic($id, $username)
{
	query("DELETE FROM profile_pic_likes WHERE profile_pic_id='$id' AND username='$username'", "unlike_profile_pic");
}

function profile_pic_like_num($id)
{
	$result = query("SELECT COUNT(*) FROM profile_pic_likes WHERE profile_pic_id='$id'", "profile_pic_like_num");
	$num = $result->fetch_array();
	return $num[0];
}

function profile_pic_liked($id, $username)
{
	$result = query("SELECT * FROM profile_pic_likes WHERE profile_pic_id='$id' AND username='$username' LIMIT 1", "profile_pic_liked");
	return $result->num_rows === 1;
}

function like_post($id, $username)
{
	$result = query("SELECT * FROM post_likes WHERE post_id='$id' AND username='$username'", "like_post");
	if (!$result->num_rows) query("INSERT INTO post_likes(post_id, username) VALUES('$id', '$username')", "like_post");
}

function unlike_post($id, $username)
{
	query("DELETE FROM post_likes WHERE post_id='$id' AND username='$username'", "unlike_post");
}

function post_like_num($id)
{
	$result = query("SELECT COUNT(*) FROM post_likes WHERE post_id='$id'", "post_like_num");
	$num = $result->fetch_array();
	return $num[0];
}

function post_liked($id, $username)
{
	$result = query("SELECT * FROM post_likes WHERE post_id='$id' AND username='$username' LIMIT 1", "post_liked");
	return $result->num_rows === 1;
}

function comment_profile_pic($id, $username, $comment, $reply_to)
{
	query("INSERT INTO profile_pic_comments(profile_pic_id, username, comment, reply_to) VALUES('$id', '$username', '$comment', '$reply_to')", "comment_profile_pic");
}

function delete_profile_pic_comment($id, $username)
{
	query("DELETE FROM profile_pic_comments WHERE (id='$id' OR reply_to='$id') AND username='$username'", "delete_profile_pic_comment");
}

function get_profile_pic_comments($id)
{
	$result = query("SELECT profile_pic_comments.id, profile_pic_comments.reply_to, profile_pic_comments.username, profile_pic_comments.comment, profile_pic_comments.date, profiles.firstname, profiles.lastname FROM profile_pic_comments, profiles WHERE profile_pic_comments.profile_pic_id='$id' AND profile_pic_comments.username=profiles.username ORDER BY profile_pic_comments.date", "get_profile_pic_comments");
	$comments = array();
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) $comments[] = $tmp;
	return $comments;
}

function get_profile_pic_comment($id)
{
	$result = query("SELECT profile_pic_comments.id, profile_pic_comments.username, profile_pic_comments.comment, profile_pic_comments.date, profiles.firstname, profiles.lastname FROM profile_pic_comments, profiles WHERE profile_pic_comments.id='$id' AND profile_pic_comments.username=profiles.username", "get_profile_pic_comment");
	return $result->fetch_array(MYSQLI_ASSOC);
}

function profile_pic_comment_num($id)
{
	$result = query("SELECT COUNT(*) FROM profile_pic_comments WHERE profile_pic_id='$id'", "profile_pic_comment_num");
	$num = $result->fetch_array();
	return $num[0];
}

function comment_post($id, $username, $comment, $reply_to)
{
	query("INSERT INTO post_comments(post_id, username, comment, reply_to) VALUES('$id', '$username', '$comment', '$reply_to')", "comment_post");
}

function delete_post_comment($id, $username)
{
	query("DELETE FROM post_comments WHERE (id='$id' OR reply_to='$id') AND username='$username'", "delete_post_comment");
}

function get_post_comments($id)
{
	$result = query("SELECT post_comments.id, post_comments.reply_to, post_comments.username, post_comments.comment, post_comments.date, profiles.firstname, profiles.lastname FROM post_comments, profiles WHERE post_comments.post_id='$id' AND post_comments.username=profiles.username ORDER BY post_comments.date", "fetch_post_comments");
	$comments = array();
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) $comments[] = $tmp;
	return $comments;
}

function get_post_comment($id)
{
	$result = query("SELECT post_comments.id, post_comments.username, post_comments.comment, profiles.firstname, profiles.lastname FROM post_comments, profiles WHERE post_comments.id='$id' AND post_comments.username=profiles.username", "fetch_post_comment");
	return $result->fetch_array(MYSQLI_ASSOC);
}

function post_comment_num($id)
{
	$result = query("SELECT COUNT(*) FROM post_comments WHERE post_id='$id'", "post_comment_num");
	$num = $result->fetch_array();
	return $num[0];
}

function message($sender, $recipent, $message, $type, $reply_to)
{
	query("INSERT INTO messages(sender, recipent, message, type, reply_to) VALUES('$sender', '$recipent', '$message', '$type', '$reply_to')", "message");
}

function get_messages($username, $member)
{
	$result = query("SELECT messages.id, messages.message, messages.type, messages.sender, messages.reply_to, messages.date, profiles.firstname, profiles.lastname FROM messages, profiles WHERE ((sender='$username' AND recipent='$member')OR(sender='$member' AND recipent='$username')) AND sender=profiles.username ORDER BY messages.date", "get_messages");
	$messages = array();
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) $messages[] = $tmp;
	return $messages;
}

function get_message($id, $username, $member)
{
	$result = query("SELECT messages.id, messages.message, messages.type, messages.date, profiles.firstname, profiles.lastname FROM messages, profiles WHERE messages.id='$id' AND ((sender='$username' AND recipent='$member')OR(sender='$member' AND recipent='$username')) AND messages.sender=profiles.username", "get_message");
	return $result->fetch_array(MYSQLI_ASSOC);
}

function message_id()
{
	$result = query("SELECT id FROM messages WHERE type!='text' ORDER BY id DESC LIMIT 1", "message_id");
	$id = $result->fetch_array();
	return ($id ? ++$id[0] : 1);
}

function report_post($post_id, $username)
{
	query("INSERT INTO post_reports(post_id, reporter) VALUES('$post_id', '$username')", "report_post");
}

function unreport_post($post_id, $username)
{
	query("DELETE FROM post_reports WHERE post_id='$post_id' AND reporter='$username'", "unreport_post");
}

function post_reported($post_id, $username)
{
	$result = query("SELECT 1 FROM post_reports WHERE post_id='$post_id' AND reporter='$username'");
	return $result->num_rows === 1;
}

function get_post_reports()
{
	$result = query("SELECT posts.id AS post_id, posts.username AS post_author, posts.post, posts.type AS post_type, posts.date AS post_date, COUNT(post_reports.id) AS report_num from post_reports JOIN posts ON post_reports.post_id = posts.id GROUP BY post_reports.post_id ORDER BY report_num DESC");
	return $result->fetch_all(MYSQLI_ASSOC);
}

function delete_post_reports($post_id)
{
	query("DELETE FROM post_reports WHERE post_id='$post_id'");
}

function delete_profile_pic($id, $username)
{
	$result = query("SELECT * FROM profile_pics WHERE id='$id' AND username='$username'", "delete_profile_pic");
	if ($result->num_rows) {
		query("DELETE FROM profile_pics WHERE id='$id'", "delete_profile_pic");
		query("DELETE FROM profile_pic_likes WHERE profile_pic_id='$id'", "delete_profile_pic");
		query("DELETE FROM profile_pic_comments WHERE profile_pic_id='$id'", "delete_profile_pic");
		$profile_pic = $result->fetch_array(MYSQLI_ASSOC);
		unlink(__DIR__ . "/../uploads/profile_pics/$profile_pic[source]");
	}
}

function delete_post($id, $username)
{
	$result = query("SELECT * FROM posts WHERE id='$id' AND username='$username'", "delete_post");
	if ($result->num_rows) {
		query("DELETE FROM posts WHERE id='$id'", "delete_post");
		query("DELETE FROM post_likes WHERE post_id='$id'", "delete_post");
		query("DELETE FROM post_comments WHERE post_id='$id'", "delete_post");
		$post = $result->fetch_array(MYSQLI_ASSOC);
		if ($post['type'] != "text") unlink(__DIR__ . "/../uploads/posts/$post[post]");
	}
}

function delete_message($id, $username)
{
	$result = query("SELECT * FROM messages WHERE id='$id' AND sender='$username'", "delete_message");
	if ($result->num_rows) {
		query("DELETE FROM messages WHERE id='$id'", "delete_message");
		$message = $result->fetch_array(MYSQLI_ASSOC);
		if ($message['type'] != 'text') unlink(__DiR__ . "/../uploads/messages/$message[message]");
	}
}

function delete_account($username)
{
	query("DELETE FROM members WHERE username='$username'");
	query("DELETE FROM profiles WHERE username='$username'");
	query("DELETE FROM profile_pic_likes WHERE username='$username'");
	query("DELETE FROM profile_pic_comments WHERE username='$username'");
	query("DELETE FROM post_likes WHERE username='$username'");
	query("DELETE FROM post_comments WHERE username='$username'");
	query("DELETE FROM followers WHERE username='$username' OR follower='$username'");

	$result = query("SELECT id FROM profile_pics WHERE username='$username'");
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) delete_profile_pic($tmp['id'], $username);

	$result = query("SELECT id FROM posts WHERE username='$username'");
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) delete_post($tmp['id'], $username);

	$result = query("SELECT id FROM messages WHERE sender='$username' OR recipent='$username'");
	while ($tmp = $result->fetch_array(MYSQLI_ASSOC)) delete_message($tmp['id'], $tmp['sender']);
}
