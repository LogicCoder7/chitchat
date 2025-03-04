<?php
const LOGIN = 1, SIGNUP = 2;
$formType = LOGIN;
$errorMessage = array('request' => null, 'username' => null, 'password' => null);
$username = $password = null;

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['form_type'])) {
	require_once 'includes/functions.php';
	$username = strtolower(sanitize($_POST['username']));
	$password = sanitize($_POST['password']);
	$formType = sanitize($_POST['form_type']);

	require_once 'includes/validations.php';
	$errorMessage['username'] = validate_username($username);
	$errorMessage['password'] = validate_password($password);

	if (!$errorMessage['username'] && !$errorMessage['password']) {
		if ($formType == LOGIN) {
			$user = verify_login($username, $password);
			if ($user) {
				session_start();
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['role'] = $user['role'];
				if ($user['role'] === 'user') die(header('Location: home.php'));
				else if ($user['role'] === 'content moderator') die(header('Location: moderator/'));
			} else {
				$errorMessage['request'] = 'Invalid Username/Password combination!';
			}
		} else if ($formType == SIGNUP) {
			$userId = create_account($username, $password, 'user');
			if ($userId) {
				session_start();
				$_SESSION['user_id'] = $userId;
				$_SESSION['role'] = 'user';
				die(header("Location: setup.php"));
			} else {
				$errorMessage['request'] = "The username you entered is already taken!";
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chitchat</title>
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/index.css">
</head>

<body>
	<header class="main-header">
		<h1>ChitChat</h1>
	</header>

	<main class="form-container">
		<h2 id="formHeading"></h2>
		<form class="login-signup-form" method="post" action="index.php">
			<p class="error"><?php echo $errorMessage['request'] ?></p>

			<label for="username">Username</label>
			<input type="text" name="username" id="username" class="username-field" value="<?php echo $username ?>" required autofocus>
			<p class="error"><?php echo $errorMessage['username'] ?></p>

			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="password-field" value="<?php echo $password ?>" required>
			<p class="error"><?php echo $errorMessage['password'] ?></p>

			<input type="hidden" name="form_type" value="<?php echo $formType ?>" required>

			<button type="submit" name="submit" class="submit-btn"></button>
			<button type="button" id="toggleFormBtn" class="toggle-form-btn"></button>
		</form>
	</main>
	<script src="assets/js/login_signup_form.js"></script>
</body>

</html>