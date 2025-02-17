<?php
session_start();
require_once 'includes/navigation_guard_user.php';

$username = $_SESSION['username'];
$errorMessage = null;

if ($_FILES) {
	$imageTypes = array("jpg", "jpeg", "png", "gif");
	$file = pathinfo($_FILES['file']['name']);
	$ext = $file['extension'];

	if (in_array($ext, $imageTypes)) {
		require_once 'includes/functions.php';
		$fileName = profile_pic_id();
		$fileDestination = "uploads/profile_pics/$fileName";
		move_uploaded_file($_FILES['file']['tmp_name'], $fileDestination);
		record_profile_pic($username, $fileName);
		die(header("Location: profile.php"));
	} else $errorMessage = "Unsupported image type!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upload Profile Picture</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">

	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/upload_profile_pic.css">
	<script src="assets/js/async_req.js"></script>
</head>

<body>
	<header>
		<?php require_once 'includes/navigation_bar.php'; ?>
	</header>

	<main id="content_container">
		<h1>Upload Profile Picture</h1>

		<form method="post" action="upload_profile_pic.php" enctype="multipart/form-data">
			<p class="error"><?php echo "$errorMessage"; ?></p>
			<input type="file" name="file">
			<button type="submit">Upload</button>
		</form>
	</main>
	<script src="assets/js/logout.js"></script>
</body>

</html>