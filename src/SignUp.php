<?php
	session_start();
	
	if(isset($_SESSION["username"])){
		session_destroy();
	}


	//From https://stackoverflow.com/questions/35716873/how-to-check-if-the-button-tag-is-clicked-in-php, how to check if a button is clicked
	if(isset($_POST['signin'])){
		//From https://www.tutorialrepublic.com/faq/how-to-make-a-redirect-in-php.php, how to redirect
		header('Location: index.php');
	}
	
	if(isset($_POST['signup'])){
		$servername = 'db';
		$port = '3306';
		$username = 'user';
		$password = 'password';

		try {
			$is_admin = 0;
			
			//From https://www.w3schools.com/php/php_mysql_connect.asp, how to use PDO
			$pdo = new PDO("mysql:host=$servername;port=$port;dbname=my_db", $username, $password);
			
			//From https://stackoverflow.com/questions/5903702/md5-and-salt-in-mysql, how to use MD5 and salt
			$sql = $pdo->prepare("INSERT INTO users (username, password, is_admin) VALUES (:user, SHA2(CONCAT(:salt,:web_password), 512), :admin)");
			
			//From https://www.w3schools.com/php/php_mysql_prepared_statements.asp, how to use prepared statements with PDO
			$sql->bindParam(':user', $_POST['Username']);
			$sql->bindParam(':salt', $_POST['Username']);
			$sql->bindParam(':web_password', $_POST['Password']);
			$sql->bindValue(':admin', $is_admin);
			$sql->execute();
			
			//From https://stackoverflow.com/questions/54494590/how-to-correctly-use-php-session-variables-to-perform-a-user-login and https://www.usna.edu/Users/cs/adina/teaching/it350/fall2020/lectures/set11-sessions.html, how to use Session variables
			$_SESSION["username"] = $_POST['Username'];
			$_SESSION["password"] = $_POST['Password'];
			$_SESSION["is_admin"] = 0;
			
			header('Location: NormalSignedInPage.php');
			
		} catch (PDOException $e) {
			
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="php_css.css">
    <title>Sign Up Page</title>
</head>
<body>
    <h1 class="page_header">Sign Up!</h1>
    <form id="Information_Form" method="post">
		<div id="Information_Page">
			<!-- From https://www.w3schools.com/howto/howto_html_autocomplete_off.asp, how to turn off autocomplete -->
			<div class="username_section">
				<label for="Username">Username</label>
				<input type="text" id="Username" name="Username" autocomplete="off">
			</div>
			
			<!-- From https://www.w3schools.com/tags/att_input_type_password.asp, how use password input -->
			<div class="password_section">
				<label for="Password">Password</label>
				<input type="password" id="Password" name="Password" autocomplete="off">
			</div>
		</div>
		<div class="button_group">
			<input class="button" type="submit" name="signup" value="Sign Up">
			<input class="button" type="submit" name="signin" value="Sign In">
		</div>
	</form>
</body>
</html>


