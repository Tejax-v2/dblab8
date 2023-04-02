<html>
<head>
<title>dblab8</title>
</head>
<body>
	<h3>User Registration</h3>
	<form action="" method="post">
		First Name: <input type="text" name="fname" placeholder="Enter your First Name"><br>
		Last Name: <input type="text" name="lname" placeholder="Enter your Last Name"><br>
		Email: <input type="text" name="email" placeholder="Enter your Email"><br>
		Password: <input type="password" name="pass1" placeholder="Enter your Password"><br>
		Confirm Password: <input type="password" name="pass2" placeholder="Confirm your Password"><br>
		<input type="submit" value="Register"><br>
	</form>
	<a href="login.php">Go to Login Page</a>
<?php
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
	
	//READING THE INPUTS
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	$pass1 = $_POST["pass1"];
	$pass2 = $_POST["pass2"];

	//ERROR HANDLING
	$errors = array();
	if(empty($fname)){
		$errors[] = "First Name cannot be empty";
	}
	if(empty($lname)){
		$errors[] = "Last Name cannot be empty";
	}
	if(empty($email)){
		$errors[] = "Email cannot be empty";
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Invalid email format";
	}
	if(empty($pass1)){
		$errors[] = "Password cannot be empty";
	}
	if(strlen($pass1)<8){
		$errors[] = "Password should be atleast 8 characters long";
	}
	if(empty($pass2)){
		$errors[] = "Confirm Password cannot be empty";
	}
	if($pass1!=$pass2){
		$errors[] = "Passwords do not match";
	}
	$query = "select * from users where email = '$email'";
	$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result)>0){
		$errors[] = "Email Already exists";
	}
	if (!empty($errors)) {
		echo "<ul>";
    foreach ($errors as $element) {
        echo "<li>".$element . "</li>";
    }
		echo "</ul>";
	}
    else{
		$pass1 = password_hash($pass1,PASSWORD_DEFAULT);
	//REGISTERING USER	
		$sql = "insert into users(first_name,last_name,email,password) values ('$fname','$lname','$email','$pass1');";
		$result = mysqli_query($conn,$sql);
		if(!$result){
			die("Query Failed: ".mysqli_error($conn));
		}
		echo "<p>User Registered Successfully</p>";
	}
}
?>
</body>
</html>
