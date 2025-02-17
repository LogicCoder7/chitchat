<?php
function validate_username($un)
{
	$error = "";
	if (!$un) $error = "Username not entered<br>";
	else {
		if (strlen($un) < 8 || strlen($un) > 16) $error .= "The username length must be 8-16 characters<br>";
		if (preg_match("/\W/", $un)) $error .= "The username can only contain the characters a-z, A-Z, 0-9, _<br>";
	}
	return $error;
}

function validate_password($pd)
{
	$error = "";
	if (!$pd) $error = "Password not entered<br>";
	else {
		if (strlen($pd) < 8 || strlen($pd) > 16) $error = "The password length must be 8-16 characters<br>";
		if (preg_match("/\W/", $pd)) $error .= "The password can only contain the characters a-z, A-Z, 0-9, _<br>";
	}
	return $error;
}

function validate_name($name)
{
	$error = "";
	if (!$name) $error = "Name not entered<br>";
	else {
		if (strlen($name) > 16) $error = "The name length must be 1-16 characters<br>";
		if (preg_match("/[^a-z]/i", $name)) $error .= "The name must contain only alphabets<br>";
	}
	return $error;
}

function validate_birthdate($birthDate)
{
	$dateParts = explode('-', $birthDate);
	$year = $dateParts[0];
	$month = $dateParts[1];
	$day = $dateParts[2];
	if (!checkdate($month, $day, $year)) return "Invalid Date";

	date_default_timezone_set("Africa/Addis_Ababa");
	$todayTime = strtotime('today');
	$birthTime = strtotime($birthDate);
	if ($birthTime > $todayTime) return "Birthdate cannot be in the future.";

	return "";
}

function fix_name($name)
{
	$name = strtolower($name);
	$name[0] = strtoupper($name[0]);
	return $name;
}
