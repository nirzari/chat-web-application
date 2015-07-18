<?php
session_start();
?>
<html>
<head><title>Page3</title></head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors','On');

try {
	if(isset($_GET['fname']) && isset($_GET['fname']) && isset($_GET['uname']) && isset($_GET['pass'])){
		$fname = $_GET['fname'];
		$email = $_GET['email'];
		$uname = $_GET['uname'];
		$pass = md5($_GET['pass']);
		$dbh = new PDO("mysql:host=127.0.0.1:3306;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		$stmt = $dbh->prepare("select username from users where username='".$uname."'");
		$stmt->execute();
		$row = $stmt->fetch();
		echo $row;		
		if($row == null ){
			$dbh->beginTransaction();
			$dbh->exec("insert into users values('".$uname."','" .$pass."','".$fname."','".$email."')")
			//echo "insert into users values('".$uname."','" .$pass."','".$fname."','".$email."')";
			or die(print_r($dbh->errorInfo(), true));
			$dbh->commit();
			header('Location: page1.php');
		}
		else{
			echo "username already exists";
		}
	}
}
catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
}
?>

<form action="page4.php" method="GET">
	<label>Full name: <input type="text" placeholder="Enter Name Surname" name="fname" value = ""/></label><br><br><br>
	<label>Email ID: <input type="text" placeholder="Enter Email ID" name="email" value = ""/></label><br><br><br>
	<label>Username: <input type="text" placeholder="Enter Username" name="uname" value = ""/></label><br><br><br>
	<label>Password: <input type="password" placeholder="Enter Password" name="pass" value = ""/></label><br>
    <input type="submit" value="Register"/>
</form>
</body>
</html>