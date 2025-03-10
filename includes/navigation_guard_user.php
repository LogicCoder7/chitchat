<?php
if (!isset($_SESSION['user_id'])) die(header("Location: /chitchat"));
if ($_SESSION['role'] === 'CONTENT_MODERATOR') die(header('Location: /chitchat/moderator'));
