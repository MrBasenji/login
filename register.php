<?php
	session_start();
	$pdo = new PDO('mysql:host=localhost;dbname=login_db', 'root', '')
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registrierung</title>
</head>
<body>
	<?php
		$showFormular = true; //show registry formular

		if(isset($_GET['register'])) {
			$error = false;
			$email = $_POST['email'];
			$password = $_POST['password'];
			$password2 = $_POST['password2'];

			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
				$error = true;
			}     
			if(strlen($password) == 0) {
				echo 'Bitte ein Passwort angeben<br>';
				$error = true;
			}
			if($password != $password2) {
				echo 'Die Passwörter stimmen nicht überein<br>';
				$error = true;
			}

			//check if email is already assigned
			if(!$error) { 
				$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
				$result = $statement->execute(array('email' => $email));
				$user = $statement->fetch();
	
				if($user !== false) {
					echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
					$error = true;
				}    
			}

			//INSERT when no errors found
			if(!$error) {    
				$passwordhash = password_hash($password, PASSWORD_DEFAULT);
	
				$statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
				$result = $statement->execute(array('email' => $email, 'password' => $passwordhash));
	
				if($result) {        
					echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Log-in</a>';
					$showFormular = false;
				} else {
					echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
				}
			} 
		}

		if($showFormular) {
	?>

			<form action="?register=1" method="post">
				E-Mail:<br>
				<input type="email" size="40" maxlength="250" name="email"><br><br>
	
				Dein Passwort:<br>
				<input type="password" size="40"  maxlength="250" name="password"><br>

				Passwort wiederholen:<br>
				<input type="password" size="40" maxlength="250" name="password2"><br><br>

				<input type="submit" value="Abschicken">
			</form>
			
			<br><br>
			
			Du hast bereits einen Account? <a href="login.php">Zum Log-in</a>

	<?php
		}
	?>
</body>
</html>