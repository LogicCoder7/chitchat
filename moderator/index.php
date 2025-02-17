<?php
require_once '../includes/session_start.php';
require_once '../includes/navigation_guard_moderator.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/reports.css">
    <script src="../assets/js/async_req.js"></script>
</head>

<body>
    <header>
        <h1>Reports</h1>
        <nav class='navigation-bar'>
            <a id='logoutBtn' href="../logout.php">Logout</a>
        </nav>
    </header>

    <main id="reportContainer"></main>
    <script>
        get("../api/fetch_post_reports.php", "reportContainer");
    </script>
    <script src="../assets/js/logout.js"></script>

</body>

</html>