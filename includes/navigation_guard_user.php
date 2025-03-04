<?php
if (!isset($_SESSION['user_id'])) die(header("Location: /chitchat"));
if ($_SESSION['role'] === 'content moderator') die(header('Location: /chitchat/moderator'));
