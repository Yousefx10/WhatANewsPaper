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
<button id='pagebtn1' pagenum="page1" onclick="flip_page(this)">Overview</button>

<button id='pagebtn2' pagenum="page2" onclick="flip_page(this)">Articles</button>
<button id='pagebtn2a' pagenum="page2a" onclick="flip_page(this)" style="display: none;" class='sub_button'>All Articles</button>

<button id='pagebtn3' pagenum="page3" onclick="flip_page(this)">Accounts</button>
<button id='pagebtn4' pagenum="page4" onclick="flip_page(this)">Settings</button> 
</div>


<div id="content_panel">
    <div id='content_header'>
        <p>Panel Content</p>
    </div>

    <div id='content_body'>
        <div id="page1" class="">
        <p>Overview Content</p>
        </div>
        <div id="page2" class="" style="display: none;">
        <p>Articles Content</p>
        </div>

        <div id="page2a" class="" style="display: none;">
        <p>page2a Content</p>
        </div>


        <div id="page3" class="" style="display: none;">
        <p>Accounts Content</p>
        </div>
        <div id="page4" class="" style="display: none;">
        <p>Settings Content</p>
        </div>
    </div>
</div>
<span class="float_clear"></span>



</div>


    <script>
        function flip_page(pageid)
        {
            document.getElementById("page1").style.display="none";
            document.getElementById("page2").style.display="none";
            document.getElementById("page3").style.display="none";
            document.getElementById("page4").style.display="none";
            
            document.getElementById("page2a").style.display="none";
            document.getElementById("pagebtn2a").style.display="none";

            //document.getElementById(pageid.id).style.display="block";

            // pageid.style.display="none";

            var pageId = pageid.getAttribute("pagenum");
            document.getElementById(pageId).style.display = "block";

            if(pageId=='page2' || pageId=='page2a')
                document.getElementById("pagebtn2a").style.display="block";

        }


    </script>
    </body>
</html>