<?php

echo "Dashboard Menu";
session_start();

// Database connection
$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching and sanitizing user input
$user = mysqli_real_escape_string($conn, $_POST['username']);
$pass = mysqli_real_escape_string($conn, $_POST['password']);

// Query to fetch user details
$sql = "SELECT * FROM users WHERE username='$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Verifying password
    if (password_verify($pass, $row['password'])) {
        // Storing session variables
        $_SESSION['username'] = $row['username'];
        $_SESSION['user_id'] = $row['id'];
        echo "Login successful. Welcome, " . $_SESSION['username'] . "!";
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found with that username.";
}

$conn->close();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>

    <h2>Login</h2>
    <form action="login.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Login">
    </form>





    </body>
</html>