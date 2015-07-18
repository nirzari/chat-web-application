<?php
session_start();
?>
<html>
<head><title>Page3</title></head>
<body>
<?php

error_reporting(E_ALL);
ini_set('display_errors','On');
if(isset($_SESSION['uname'])){
		$follow = null;
			if(isset($_GET['reply'])){
				$_SESSION['follow'] = $_GET['reply'];
			}
			if(isset($_GET['newmsg'])){
				unset($_SESSION['follow']);
			}
			try {
				if(isset($_GET['message'])){
					if(isset($_SESSION['follow'])){
						$follow = $_SESSION['follow'];
					}
					$msg = $_GET['message'];
					$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					$dbh->beginTransaction();
					//echo "insert into posts values('" .uniqid(). "','abc', 'xyz' ,now(),'".$msg."')";
					$dbh->exec("insert into posts values('" .uniqid(). "','".$_SESSION['uname']."', '".$follow."' ,now(),'".$msg."')")
					or die(print_r($dbh->errorInfo(), true));
					$dbh->commit();
					header('Location: page2.php');
				}
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

<br>
<form action="page3.php" method="GET">
		<textarea rows="25" name = "message"  cols="50">
		</textarea>
		<br>
		<input type="submit" value="Post"/>
</form>
</body>
</html>