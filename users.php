<?php
require_once 'includes/session_start.php';
require_once 'includes/navigation_guard_user.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>People</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/css/general.css">
	<link rel="stylesheet" type="text/css" href="assets/css/people.css">
	<script src="assets/js/async_req.js"></script>
</head>

<body>
	<header class="main-header">
		<?php require_once 'includes/navigation_bar.php'; ?>
		<button onclick="get('/chitchat/api/fetch_users.php?view=all', 'userContainer')">All</button> |
		<button onclick="get('/chitchat/api/fetch_users.php?view=following', 'userContainer')">Following</button> |
		<button onclick="get('/chitchat/api/fetch_users.php?view=followers', 'userContainer')">Followers</button>
	</header>

	<main id="userContainer" class="user-container"></main>
	<script>
		get("/chitchat/api/fetch_users.php", "userContainer");
	</script>
	<script src="assets/js/confirm_logout.js"></script>

</body>

</html>