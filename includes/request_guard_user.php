<?php
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user')
    die();
