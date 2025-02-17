<?php
require_once 'includes/session_start.php';
require_once 'includes/navigation_guard_user.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Members</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link rel="stylesheet" type="text/css" href="assets/css/members.css">
	<script src="assets/js/async_req.js"></script>
</head>

<body>
	<header id="headerContainer">
		<?php require_once 'includes/navigation_bar.php'; ?>
		<button onclick="get('/chitchat/api/fetch_members.php?view=members', 'memberContainer')">Members</button> |
		<button onclick="get('/chitchat/api/fetch_members.php?view=following', 'memberContainer')">Following</button> |
		<button onclick="get('/chitchat/api/fetch_members.php?view=followers', 'memberContainer')">Followers</button>
	</header>

	<main id="memberContainer"></main>
	<script>
		get("/chitchat/api/fetch_members.php", "memberContainer");
	</script>
	<script src="assets/js/logout.js"></script>

</body>

</html>