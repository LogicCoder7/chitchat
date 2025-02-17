<?php
if (!isset($_SESSION['username'])) die(header("Location: /chitchat"));
if ($_SESSION['role'] === 'user') die(header('Location: /chitchat/home.php'));
