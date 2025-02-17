<?php
session_start();
require_once 'includes/navigation_guard_user.php';
require_once 'includes/functions.php';

$username = $_SESSION['username'];
delete_account($username);

session_destroy();
die(header("Location: /chitchat"));
