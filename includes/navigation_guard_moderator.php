<?php
if (!isset($_SESSION['user_id'])) die(header("Location: /chitchat"));
if ($_SESSION['role'] === 'USER') die(header('Location: /chitchat/following_posts.php'));
