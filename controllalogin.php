<?php
$email = $_POST['email'];
$password = $_POST['password'];
if ($email == "PUT_USERNAME_HERE" and $password == "PUT_PASSWORD_HERE") {
	session_start();
	$_SESSION['email'] = $email;
	$_SESSION['password'] = $passmd5;
	header("Location: loginok.php");
}
else {
	echo "<h2>Login errato. </h2>";
	echo "Torna al login <a href=\"login.php\">login</a>";
}
?>
