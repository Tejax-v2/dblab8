<html>
<head>
<title>dblab8</title>
</head>
<body>
	<h3>User Information</h3>
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
		echo "<form action='' method='POST'>";
		echo "First Name: <input type='text' name='fname' value='$user['first_name']'><br>";
		echo "Last Name: <input type='text' name='lname' value='$user['last_name']'><br>";
		echo "Email: <input type='text' name='email' value='$user['email']'><br>";
		echo "Password: <input type='password' name='pass' placeholder='Enter New Password'><br>";
		echo "<input type='submit' value='Update'><br>";
		echo "</form>";
	}
	if($_SERVER["REQUEST_METHOD"]=="POST"){
	
	//READING THE INPUTS
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	$pass = $_POST["pass"];

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
	if(!empty($pass)){
	if(strlen($pass1)<8){
		$errors[] = "Password should be atleast 8 characters long";
	}
	else{
		$user['password']=password_hash
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
