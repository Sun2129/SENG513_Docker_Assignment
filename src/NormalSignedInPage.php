<?php
	//From https://stackoverflow.com/questions/54494590/how-to-correctly-use-php-session-variables-to-perform-a-user-login and https://www.usna.edu/Users/cs/adina/teaching/it350/fall2020/lectures/set11-sessions.html, how to use Session variables
	session_start();
	if(!isset($_SESSION["username"]) || isset($_POST['logout'])){
		session_destroy();
		header('Location: index.php');
	}
	
	else if($_SESSION["is_admin"] == 1){
		header('Location: AdminSignedInPage.php');
	}
?>

<!DOCTYPE html>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="php_css.css">
    <title>Signed In Page</title>
</head>
<body>
    <h1 class="page_header">Signed In!</h1>
	<form id="Information_Form" method="POST">
		<div class="logout_button">
			<input class="button" type="submit" name="logout" value="Logout">
		</div>
	</form> 
</body>
</html>


