<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'USER')
    die();
