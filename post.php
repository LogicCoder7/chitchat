<?php
session_start();
require_once 'includes/navigation_guard_user.php';

$userId = $_SESSION['user_id'];
$errorMessage = null;

if ($_FILES) {
	$imageTypes = array("jpg", "jpeg", "png", "gif");
	$videoTypes = array("mp4", "mkv", "ogg");
	$file = pathinfo($_FILES['post']['name']);
	$ext = $file['extension'];

	if (in_array($ext, $imageTypes) || in_array($ext, $videoTypes)) {
		require_once 'includes/database_access.php';
		$fileName = get_next_post_id();
		$fileType = (in_array($ext, $imageTypes) ? "IMAGE" : "VIDEO");
		$fileDestination = "uploads/posts/$fileName";
		move_uploaded_file($_FILES['post']['tmp_name'], $fileDestination);
		post($userId, $fileName, $fileType);
		die(header("Location: profile.php"));
	} else $errorMessage = "Unsupported image/video type!";
} else if (isset($_POST['post'])) {
	require_once 'includes/database_access.php';
	$post = sanitize($_POST['post']);
	post($userId, $post, "TEXT");
	die(header("Location: profile.php"));
}
?>

<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Post</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="assets/css/general.css">
	<link rel="stylesheet" href="assets/css/post.css">
	<script src="assets/js/async_req.js"></script>
</head>

<body>
	<header class="main-header">
		<?php require_once 'includes/navigation_bar.php'; ?>
	</header>

	<main class="form-container">
		<h1>Post</h1>
		<form class="post-form" method='post' action='post.php' enctype='multipart/form-data'>
			<p class="error"><?php echo $errorMessage ?></p>
			<button type="button" id="postImageBtn">Image/Video</button>
			<button type="button" id="postTextBtn">Text</button>
			<textarea name='post' autofocus></textarea>
			<button type='submit'>Post</button>
		</form>
	</main>
	<script src="assets/js/toggle_post_content.js"></script>
	<script src="assets/js/confirm_logout.js"></script>
</body>

</html>