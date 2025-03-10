<?php
require_once '../includes/session_start.php';
require_once '../includes/navigation_guard_moderator.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reported Posts</title>
    <link rel="stylesheet" href="../assets/css/general.css">
    <link rel="stylesheet" href="../assets/css/reported_posts.css">
    <script src="../assets/js/async_req.js"></script>
</head>

<body>
    <header class="main-header">
        <h1>Reported Posts</h1>
        <nav class='navigation-bar'>
            <a id='logoutBtn' href="../logout.php">Logout</a>
        </nav>
    </header>

    <main id="reportedPostContainer" class="reported-post-container"></main>
    <script>
        get("../api/fetch_reported_posts.php", "reportedPostContainer");
    </script>
    <script src="../assets/js/confirm_logout.js"></script>
</body>

</html>