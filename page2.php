<?php
session_start();
?>
<html>
<head><title>Page1</title></head>
<body>
<?php

error_reporting(E_ALL);
ini_set('display_errors','On');

if(isset($_SESSION['uname'])){ 
	try {
		$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$stmt = $dbh->prepare("select * from posts");
		$stmt->execute();
		echo "<table border=2>";
		echo "<th>id</th><th>postedby</th><th>follows</th><th>datetime</th><th>message</th><th>Reply</th>";
		while ($row = $stmt->fetch()) {
			echo " <tr><td>".$row['id']."</td><td>".$row['postedby']."</td><td>".$row['follows']."</td><td>".$row['datetime']."</td><td>".$row['message']."</td><td><form action='page3.php'><button type='submit' name='reply' value = '".$row['id']."'>Reply</button></form></td></tr>";
		}
		echo "</table>";
	}
	catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
}
else{
		header('Location: page1.php');
	}
?>	
<form action="page1.php" method="GET">
       <input type="submit" name = "logout" value="Logout"/>
</form>
<form action="page3.php" method="GET">
       <input type="submit" name = "newmsg" value="New Message"/>
</form>
</body>
</html>
	