<html>
<head>
<title>dblab8</title>
</head>
<body>
	<h3>User Login</h3>
	<form action="" method="post">
		Email: <input type="text" name="email" placeholder="Enter your Email"><br>
		Password: <input type="password" name="pass" placeholder="Enter your Password"><br>
		<input type="submit" value="Login"><br>
	</form>
	<a href="register.php">Go to Register Page</a>
<?php
session_start();
//CONNECTING TO MYSQL DATABASE
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
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$email = mysqli_real_escape_string($conn,$_POST["email"]);
		$pass = mysqli_real_escape_string($conn,$_POST["pass"]);
		$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$result = $stmt->get_result();
		$user = $result->fetch_assoc();
	    if( $user == null){
			echo "<p>User is not registered</p>";
		}
	    else {
			
			if (password_verify($pass, $user["password"])) {
			$_SESSION['user'] = $user;
			header('Location: home.php');
			exit();
			}
			else{
				echo "<p>Invalid Credentials</p>";
			}
		} 
	}
?>
</body>
</html>
