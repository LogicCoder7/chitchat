<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'content moderator')
    die();
