<?php
require_once 'includes/session_start.php';
require_once 'includes/navigation_guard_user.php';

$userId = $_SESSION['user_id'];
$errorMessage = array('firstname' => null, 'lastname' => null, 'dob' => null);
$firstname = $lastname = $bio = $dob = null;

if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
	require_once 'includes/functions.php';
	$firstname = sanitize($_POST['firstname']);
	$lastname = sanitize($_POST['lastname']);
	$bio = sanitize($_POST['bio']);
	$dob = sanitize($_POST['dob']);

	require_once 'includes/validations.php';
	$firstname = fix_name($firstname);
	$lastname = fix_name($lastname);
	$errorMessage['firstname'] = validate_name($firstname);
	$errorMessage['lastname'] = validate_name($lastname);
	$errorMessage['dob'] = validate_birthdate($dob);

	if (!$errorMessage['firstname'] && !$errorMessage['lastname'] && !$errorMessage['dob']) {
		setup_profile($userId, $firstname, $lastname, $bio, $dob);
		die(header("Location: profile.php"));
	}
}
?>

<!DOCTYPE html>

<html>

<head>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Setup</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/setup.css">
</head>

<body>
	<header class="main-header">
		<h1>ChitChat</h1>
	</header>

	<main class="form-container">
		<h2 class="form-heading">Profile Setup</h2>
		<form class="profile-setup-form" method="post" action="setup.php">
			<label for="firstname">First name</label>
			<input type="text" id="firstname" class="text-field" name="firstname" value="<?php echo $firstname ?>" required autofocus>
			<p class="error"><?php echo $errorMessage['firstname'] ?></p>

			<label for="lastname">Last name</label>
			<input type="text" id="lastname" class="text-field" name="lastname" value="<?php echo $lastname ?>" required>
			<p class="error"><?php echo $errorMessage['lastname'] ?></p>

			<label for="bio">Bio</label>
			<input type="text" id="bio" class="text-field" name="bio" value="<?php echo $bio ?>">

			<label for="dob">Birth date</label>
			<input type="date" id="dob" class="text-field" name="dob" value="<?php echo $dob ?>" required>
			<p class="error"><?php echo $errorMessage['dob'] ?></p>

			<button type="submit" class="submit-btn">Submit</button>
		</form>
	</main>
</body>

</html>