<html>
<head>
<title>dblab8</title>
</head>
<body>
	<?php
	session_start();
	$server = "localhost";
	$username = "admin";
	$password = "admin";
	$database = "dblab8";
	
	try{
	$conn = new mysqli($server,$username,$password,$database);
	}
	catch(Exception $e){
		error_log($e->getMessage());
	}
	if($conn->connect_error){
		die("Connection Failed: ". $conn->connect_error);
	}	
	$user = $_SESSION['user'];
	if(isset($user)){
	echo "<h3>Welcome, ".$user['first_name']." ".$user['last_name']."</h3>";
	}
	?>
	<a href="information.php">Edit Profile</a><br>
	<a href="deleteAccount.php">Delete Account</a>
</body>
</html>
