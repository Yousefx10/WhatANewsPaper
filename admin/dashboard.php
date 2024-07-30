<?php

echo "Dashboard Menu<br/>";
session_start();

require "sql.php";



//THIS CODE COMES FIRST TO HANDLE THE OPERATIONS LIKE [DELETE] AND [EDIT].
//BECAUSE IT'S A ONE PAGE DASHBOARD.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    
    // Check if the 'id' parameter is set in the POST data
    if (isset($_POST['iddd']) && !empty($_POST['iddd'])) {

        $iddd = isset($_POST['iddd']) ? intval($_POST['iddd']) : 0;

        // SQL query to delete the row
        $sql = "DELETE FROM articles WHERE id = $iddd";
        
        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Row deleted successfully.";
        } else {
            echo "Error deleting row: " . $conn->error;
        }
        exit();
    }
}














if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true ) {

    echo "User is logged in<br/>";

    $_SESSION['loggedin'] = true;
    echo "current user ID".$_SESSION['useridnow'];


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


$stmt = $conn->prepare("INSERT INTO articles (title, content, author_id,category,is_breaking) VALUES (?, ?, ?,?,?)");
$stmt->bind_param("sssss", $title, $content, $author,$category,$breaking);


$title = $_POST['title'];
$content = $_POST['content'];
$author = $_POST['author'];
$category = $_POST['category'];
$breaking = isset($_POST['breaking']) ? 1 : 0;
$stmt->execute();

// $sql = "INSERT INTO articles (title, content, author_id) VALUES ('$title', '$content', '$author')";
// if ($conn->query($sql) === TRUE) {echo "New record created successfully";} 
//     else {echo "Error: " . $sql . "<br>" . $conn->error;}

echo "New record created successfully";

$stmt->close();
// $conn->close();

     
    }

} else {


    $_SESSION['loggedin'] = false;
echo "try to login <br/>";
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Fetching and sanitizing user input
        $user = mysqli_real_escape_string($conn, $_POST['username']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);
        echo $user;
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




                // Prepare the SQL statement
                $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
                $stmt->bind_param("s", $user); // "s" specifies the type of $username (string)
                
                // Execute the statement
                $stmt->execute();
                
                // Get the result
                $result = $stmt->get_result();
                
                // Fetch the user ID
                if ($row = $result->fetch_assoc()) {
                    $user_id = $row['id'];
                    // echo "User ID: " . $user_id;
                } 
                // else {echo "No user found with that username.";}
                
                // Close the statement and connection
                $stmt->close();

                

                $_SESSION['useridnow'] = $user_id;








                // $conn->close();
               

                header('Location: ' . $_SERVER['PHP_SELF']);

                


                exit();

            } 
            else {echo "Invalid password.";$_SESSION['loggedin'] = false;}
        } 
        
        else { echo "No user found with that username.";}
        
        }
        
        
        // $conn->close(); //stoping this code because it's cause the code not to continue running after the line.


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



<?php













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


<p>will hide this later</p>
<hr/>
<div id="side_panel">
<button id='pagebtn1' pagenum="page1" onclick="flip_page(this)">Overview</button>

<button id='pagebtn2' pagenum="page2" onclick="flip_page(this)">Articles</button>
<div id='sub_div'>
<button id='pagebtn2a' pagenum="page2a" onclick="flip_page(this)" style="display: none;" class='sub_button'>New Article</button>
<button id='pagebtn2b' pagenum="page2b" onclick="flip_page(this)" style="display: none;" class='sub_button'>All Articles</button>
</div>

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
            <form action="dashboard.php" method="post">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>

                <label for="content">Content:</label><br>
                <textarea id="content" name="content" rows="10" cols="50" required></textarea><br><br>

                <input type="hidden" id="author" name="author" value="<?php echo $_SESSION['useridnow'];?>"><br><br>
                <label for="Category">Choose a Category:</label>
        <select id="Category" name="category">
            <option value="World">World</option>
            <option value="Sports">Sports</option>
            <option value="Business">Business</option>
            <option value="Stories">Stories</option>
        </select>
        <label for="breaking">
            <input type="checkbox" id="breaking" name="breaking" value="yes">
            Is this breaking news?
        </label>


                <input type="submit" value="Submit">
            </form>
        </div>

        <div id="page2b" class="" style="display: none;">
        
        <?php

// $sql = "SELECT * FROM articles ORDER BY created_at DESC";
$sql ="SELECT articles.*, users.author AS author_name FROM articles JOIN users ON articles.author_id = users.id ORDER BY articles.created_at DESC;";
$result = $conn->query($sql);



if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $breaking = $row['is_breaking']==1 ? 'breaking' : '';
        $CURRENTarticleID = $row["id"];

        echo "<div class='".$row["category"]." category $breaking'>";
        echo"<div class='articles_settings'><span onclick='callmetoALERT(\"$CURRENTarticleID\",this)'>[Delete]</span><span>[Edit]</span></div>";
        echo "<h2>" . $row["title"]. "</h2>";

        $categorySPAN="<span class='categorySPAN so$breaking'>". $row["category"]."</span> ";
        echo "<p>" .$categorySPAN. $row["content"]. "</p>";
        $currentauthorID = $row["author_id"];

        echo "<p><em>By " . $row["author_name"]. " on " . $row["created_at"]. "</em></p>";
        echo "<hr>";
        echo "</div>";
    }
} else {
    echo "No news articles found.";
}

// $conn->close();




?>




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
    function callmetoALERT(articleID,OLDnews)
    {
        var result = confirm("Are you sure you want to delete this item?");
            if (result) {
                // User clicked OK
                sendTHEdata(articleID,OLDnews);
            } else {/* User clicked Cancel*/}

            
    }

    </script>


    <script>
            function sendTHEdata(currentID,OLDnews)
            {
                const iddd = currentID;
            
            fetch('dashboard.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `iddd=${encodeURIComponent(iddd)}`
            })
            .then(response => response.text())
            .then(data => {
            //    alert(data); // Show the response from the server
                console.log(data);
                // Optionally, you could remove the row from the DOM or update the UI

               var parentDiv = OLDnews.parentElement.parentElement;
               //parentDiv.remove();// Remove the parent element from the DOM 
               parentDiv.style.background="red";

            })
            .catch(error => {
                console.error('Error:', error);
            });

            }

    </script>




    <script>
        function flip_page(pageid)
        {
            document.getElementById("page1").style.display="none";
            document.getElementById("page2").style.display="none";
            document.getElementById("page3").style.display="none";
            document.getElementById("page4").style.display="none";

            document.getElementById("page2a").style.display="none";
            document.getElementById("page2b").style.display="none";
            document.getElementById("pagebtn2a").style.display="none";
            document.getElementById("pagebtn2b").style.display="none";

            //document.getElementById(pageid.id).style.display="block";

            // pageid.style.display="none";

            var pageId = pageid.getAttribute("pagenum");
            document.getElementById(pageId).style.display = "block";

            if(pageId=='page2' || pageId=='page2a' || pageId=='page2b')
                {
                    document.getElementById("pagebtn2a").style.display="block";
                    document.getElementById("pagebtn2b").style.display="block";
                }


        }


    </script>
        <script>
        console.log('This script is executed.');
        // Add more JavaScript code here
    </script>
    </body>
</html>