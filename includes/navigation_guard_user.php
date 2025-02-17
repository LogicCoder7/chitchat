<?php
if (!isset($_SESSION['username'])) die(header("Location: /chitchat"));
if ($_SESSION['role'] === 'moderator') die(header('Location: /chitchat/moderator'));
