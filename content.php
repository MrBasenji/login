<!DOCTYPE html>
<html>
<head>
	<title>content</title>
</head>
<body>
<?php
	require 'auth.php';
	
	if(isset($_COOKIE["jwt"])){
		$token = $_COOKIE["jwt"];
		
		if(!validateJWT($token))
		{
			header("Location:login.php");
		}
	}
	else
	{
		header("Location:login.php");
	}
?>

	<a href="register.php">zurück zur Registrierung</a>
	<br>
	<a href="login.php">Zum Log-in</a>
	<br>
	<a href="https://github.com/MrBasenji/login" target="_blank">Github Repository</a>
	<br>
	<p>[potential content]</p>

</body>
</html>
