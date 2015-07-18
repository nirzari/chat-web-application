<?php
session_start();
?>
<html>
<head><title>Page1</title></head>
<body>
<?php

error_reporting(E_ALL);
ini_set('display_errors','On');
if(isset($_GET['logout'])){
	session_destroy();
}	
try {
	$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	if(isset($_GET['uname']) && isset($_GET['pass'])){
		$uname = $_GET['uname'];
		$pass = md5($_GET['pass']);
		$stmt = $dbh->prepare("select password from users where username='".$uname."'");
		$stmt->execute();
		$row = $stmt->fetch(); 
		if($pass == $row['password']){
			echo "Login Successful";
			$_SESSION['uname'] = $uname;
			header('Location: page2.php');
		}	
		else if($row == null){
			echo "<p>Username not valid</p>";
		}
		else{
			echo "<p>Login again</p>";
		}
	} 
}
catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
?>
<form action="page1.php" method="GET">
       <label>Username: <input type="text" align="left" placeholder="Username" name="uname" value = ""/></label>
	   <label>Password: <input type="text" align="left" placeholder="Password" name="pass" value = ""/></label>
       <input type="submit" value="Login"/>
</form>
<form action="page4.php" method ="GET">
		<input type="submit" value="New users must register here"/>
</form>
</body>
</html>
	