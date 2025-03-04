<?php
if (!isset($_SESSION['user_id'])) die(header("Location: /chitchat"));
if ($_SESSION['role'] === 'user') die(header('Location: /chitchat/home.php'));
