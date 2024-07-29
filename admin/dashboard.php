<?php

echo "Dashboard Menu<br/>";
session_start();

require "sql.php";


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

    echo "User is logged in<br/>";
    $_SESSION['loggedin'] = true;

} else {


    $_SESSION['loggedin'] = false;
echo "try to login <br/>";
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
        
                $_SESSION['loggedin'] = true;
                header('Location: ' . $_SERVER['PHP_SELF']);
                $conn->close();
                exit();

            } 
            else {echo "Invalid password.";$_SESSION['loggedin'] = false;}
        } 
        
        else { echo "No user found with that username.";}
        
        }
        
        
        $conn->close();


}






//$2y$10$frdlWIo7DeGfCIxwy2xO9uu7Dxqnz4qCy.4tHfnKOuLo8vIsKWehG
//password@123
//echo password_hash("password@123", PASSWORD_DEFAULT);


/*
echo"<br/>";

if( password_verify("testing", password_hash("testing", PASSWORD_DEFAULT) ));
echo "<br/>wow";
*/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="admin_style.css"/>
    </head>
    <body>

<div class="container">
<?php  
     $cssresult = ($_SESSION['loggedin']);

    if(!$cssresult)
     echo '<div style="display:block;">
    <h2>Login</h2>
    <form action="dashboard.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>


        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>


        <input type="submit" value="Login">
    </form>
</div>';
else
echo '<div>
<h3>Start Control Your Page</h3>
<input type="text"/>
</div>';
    
    ?>




<div id="side_panel">
<button>Overview</button>
<button>Articles</button>
<button>Accounts</button>
<button>Settings</button> 
</div>


<div id="content_panel">
    <p>Panel Content</p>
</div>
<span class="float_clear"></span>



</div>



    </body>
</html>