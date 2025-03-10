<?php
session_start();
require_once 'includes/navigation_guard_user.php';
require_once 'includes/database_access.php';

$userId = $_SESSION['user_id'];
delete_user($userId);

session_destroy();
die(header("Location: /chitchat"));
