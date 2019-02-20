<html>
<head>
        <title>Login</title>
</head>
<body>

<?php
		require 'auth.php';
		
		//try connect to Database
        try {
        $pdo = new PDO('mysql:host=localhost;dbname=login_db', 'root', '');
        }
        catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
        }
		
		// if inputs are posted prepare and execute Database entries
        if(isset($_GET['login'])) {
                $email = $_POST['email'];
                $password = $_POST['password'];

                $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $result = $statement->execute(array('email' => $email));
                $user = $statement->fetch();

                //check password
                if ($user !== false && password_verify($password, $user['password'])) {
                        createJWT($user);
                        die('Login erfolgreich. Weiter zu <a href="content.php">internen Bereich</a>');
                } else {
                        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
                }

        }
		
		//echo error message
        if(isset($errorMessage)) {
                echo $errorMessage;
        }
?>

        <form action="?login=1" method="post">
        E-Mail:<br>
        <input type="email" size="40" maxlength="250" name="email"><br><br>

        Dein Passwort:<br>
        <input type="password" size="40"  maxlength="250" name="password"><br>

        <input type="submit" value="Abschicken">
        </form>

        <br><br>

        Du hast noch keinen Account? <a href="register.php">Zur Registrierung.</a>
</body>