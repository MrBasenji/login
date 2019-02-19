<?php
	require_once 'vendor/autoload.php';
	use ReallySimpleJWT\Token;
	
	$secret = getenv('PHP_SECRET');
	
	function createJWT($user)
	{
		$userid = $user['id'];
		$expiration = time() + 3600;
		$issuer = 'localhost';		
		$token = Token::create($userid, $secret, $expiration, $issuer);
		
		setcookie("jwt", $token, time() + 3600);
	}
	
	function validateJWT(string $token): bool
	{
		return Token::validate($token, $secret);
	}
?>