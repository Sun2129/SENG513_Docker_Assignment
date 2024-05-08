<?php
	//From https://stackoverflow.com/questions/54494590/how-to-correctly-use-php-session-variables-to-perform-a-user-login and https://www.usna.edu/Users/cs/adina/teaching/it350/fall2020/lectures/set11-sessions.html, how to use Session variables
	session_start();
	if(!isset($_SESSION["username"]) || isset($_POST['logout'])){
		session_destroy();
		header('Location: index.php');
	}
	
	else if($_SESSION["is_admin"] == 0){
		header('Location: NormalSignedInPage.php');
	}
	
	//From https://stackoverflow.com/questions/35716873/how-to-check-if-the-button-tag-is-clicked-in-php, how to check if a button is clicked
	if(isset($_POST["delete"])){
		$servername = 'db';
		$port = '3306';
		$username = 'user';
		$password = 'password';
		
		try {
			//From https://www.w3schools.com/php/php_mysql_connect.asp, how to use PDO
			$pdo = new PDO("mysql:host=$servername;port=$port;dbname=my_db", $username, $password);
			
			//From https://stackoverflow.com/questions/5903702/md5-and-salt-in-mysql, how to use MD5 and salt
			$sql = $pdo->prepare("DELETE FROM users WHERE id = :id");
			
			//From https://www.w3schools.com/php/php_mysql_prepared_statements.asp, how to use prepared statements with PDO
			$sql->bindParam(':id', $_POST['delete']);
			
			$sql->execute();
		}catch (PDOException $e) {
			echo "Connection failed: " . $e->getMessage();
		}
	}
?>

<!DOCTYPE html>

<html>
<head>
	<link rel="stylesheet" type="text/css" href="php_css.css">
    <title>Admin Signed In Page</title>
</head>
<body>
    <h1 class="page_header">Signed In!</h1>
	<table id='admin_table'>
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Is Admin?</th>
			<th></th>
		</tr>
		<form method="POST">
			<?php
				$servername = 'db';
				$port = '3306';
				$username = 'user';
				$password = 'password';
				
				try{
					//From https://www.w3schools.com/php/php_mysql_connect.asp, how to use PDO
					$pdo = new PDO("mysql:host=$servername;port=$port;dbname=my_db", $username, $password);
					
					//From https://stackoverflow.com/questions/5903702/md5-and-salt-in-mysql, how to use MD5 and salt
					$sql = $pdo->prepare("SELECT * FROM users");
					$sql->execute();
					
					//From https://stackoverflow.com/questions/1519872/pdo-looping-through-and-printing-fetchall, how to iterate through fetchAll with a loop (down below)
					$results = $sql->fetchAll(PDO::FETCH_ASSOC);
					
					//From https://stackoverflow.com/questions/22787432/for-loop-table-in-php, how to construct a table with a for loop
					foreach($results as $row){
						echo "<tr>";
						echo "<td>",$row['id'],"</td>";
						echo "<td>",$row['username'],"</td>";
						if($row['is_admin'] == 0){
							echo "<td>False</td>";
							echo "<td><button class='button' name='delete' type='submit' value='", $row['id'], "'>Delete</button></td>";
						}
						else if($row['is_admin'] == 1){
							echo "<td>True</td>";
						}
						echo "</tr>";
					}
				}catch (PDOException $e){
					echo "Connection failed: " . $e->getMessage();
				}
			?>
			<div class="logout_button">
				<input class="button" type="submit" name="logout" value="Logout">
			</div>
		</form>
	</table>
</body>
</html>


