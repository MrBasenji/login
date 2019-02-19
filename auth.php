<?php
	require_once 'vendor/autoload.php';
	use ReallySimpleJWT\Token;
	
	
	function createJWT($user)
	{
		$secret = getenv('PHP_SECRET');
		$userid = $user['id'];
		$expiration = time() + 3600;
		$issuer = 'localhost';		
		$token = Token::create($userid, $secret, $expiration, $issuer);
		
		setcookie("jwt", $token, time() + 3600);
	}
	
	function validateJWT(string $token): bool
	{
		$secret = getenv('PHP_SECRET');
		return Token::validate($token, $secret);
	}
?>