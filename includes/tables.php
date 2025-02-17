<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "chitchat";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) die("Couldn't connect to database!");

function query($query, $error = "")
{
	global $conn;
	$result = $conn->query($query);
	if (!$result) die("Error: " . $error);
	return $result;
}

function create_table_members()
{
	query("DROP TABLE IF EXISTS `members`", "members1");
	query("CREATE TABLE members(username VARCHAR(32) PRIMARY KEY, password VARCHAR(32), role VARCHAR(32))", "members");
}

function create_table_profiles()
{
	query("DROP TABLE IF EXISTS `profiles`", "profiles");
	query("CREATE TABLE profiles(username VARCHAR(32) PRIMARY KEY, firstname VARCHAR(32), lastname VARCHAR(32), bio VARCHAR(50), birthdate DATE, FULLTEXT(firstname), FULLTEXT(lastname))", "profiles");
}

function create_table_profile_pics()
{
	query("DROP TABLE IF EXISTS `profile_pics`", "profile_pics");
	query("CREATE TABLE profile_pics(id INT UNSIGNED PRIMARY key AUTO_INCREMENT, username VARCHAR(32), source VARCHAR(128), date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)", "profile_pics");
}

function create_table_posts()
{
	query("DROP TABLE IF EXISTS `posts`", "posts");
	query("CREATE TABLE posts(id INT UNSIGNED PRIMARY key AUTO_INCREMENT, username VARCHAR(32), post VARCHAR(128), type VARCHAR(10), date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)", "posts");
}

function create_table_profile_pic_likes()
{
	query("DROP TABLE IF EXISTS `profile_pic_likes`", "profile_pic_likes");
	query("CREATE TABLE profile_pic_likes(id INT UNSIGNED PRIMARY key AUTO_INCREMENT, profile_pic_id INT UNSIGNED, username VARCHAR(32))", "profile_pic_likes");
}

function create_table_post_likes()
{
	query("DROP TABLE IF EXISTS `post_likes`", "post_likes");
	query("CREATE TABLE post_likes(id INT UNSIGNED PRIMARY key AUTO_INCREMENT, post_id INT UNSIGNED, username VARCHAR(32))", "post_likes");
}

function create_table_profile_pic_comments()
{
	query("DROP TABLE IF EXISTS `profile_pic_comments`", "profile_pic_comments");
	query("CREATE TABLE profile_pic_comments(id INT UNSIGNED PRIMARY key AUTO_INCREMENT, reply_to INT UNSIGNED, profile_pic_id INT UNSIGNED, username VARCHAR(32), comment VARCHAR(128), date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)", "profile_pic_comments");
}

function create_table_post_comments()
{
	query("DROP TABLE IF EXISTS `post_comments`", "post_comments");
	query("CREATE TABLE post_comments(id INT UNSIGNED PRIMARY key AUTO_INCREMENT, reply_to INT UNSIGNED, post_id INT UNSIGNED, username VARCHAR(32), comment VARCHAR(128), date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)", "post_comments");
}

function create_table_messages()
{
	query("DROP TABLE IF EXISTS `messages`", "messages");
	query("CREATE TABLE messages(id INT UNSIGNED PRIMARY key AUTO_INCREMENT, reply_to INT UNSIGNED, sender VARCHAR(32), recipent VARCHAR(32), message VARCHAR(128), type VARCHAR(10), date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)", "messages");
}

function create_table_followers()
{
	query("DROP TABLE IF EXISTS `followers`", "followers");
	query("CREATE TABLE followers(username VARCHAR(32), follower VARCHAR(32))", "followers");
}

function create_table_post_reports()
{
	query("DROP TABLE IF EXISTS `post_reports`", "reports");
	query("CREATE TABLE post_reports(id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, post_id INT UNSIGNED, reporter VARCHAR(32))");
}

function create_all_tables()
{
	create_table_members();
	create_table_profiles();
	create_table_profile_pics();
	create_table_posts();
	create_table_profile_pic_likes();
	create_table_post_likes();
	create_table_profile_pic_comments();
	create_table_post_comments();
	create_table_messages();
	create_table_followers();
	create_table_post_reports();
}

// create_all_tables();
create_table_post_reports();
