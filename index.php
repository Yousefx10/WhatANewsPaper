<?php

require 'admin/sql.php';


$setting0_is_activated="";
$setting1_wlc_message="";
$setting2_project_name="";
$setting3_background_color="";


$sql_SETTINGS ="SELECT wlc_msg, project_name,bg_color,is_activated FROM settings LIMIT 1";

$result = $conn->query($sql_SETTINGS);

if ($result->num_rows > 0) {
    // Step 3: Fetch the result and display it
    $row = $result->fetch_assoc();
    $setting1_wlc_message = $row['wlc_msg'];
    $setting2_project_name = $row['project_name'];
    $setting3_background_color = $row['bg_color'];
    $setting0_is_activated = $row['is_activated'];
}


if($setting0_is_activated=="0")
{
    echo "<p><em>Website Is Under Maintenance</em></p>";
    //soon will adding more details like some pictures to reffer Maintenance status
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>READING IS FUN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="style.css"/>
        <style>
            body{background-color: <?php echo $setting3_background_color; ?> ;}

        </style>

    </head>
    <body>
        <div class="container">
        <div class="header">




    <div class="tabletext">
        <div class="left" >;</div>
        <div class="right" id="date">--</div>
    </div>

    <div class="tabletext">
    <div class="left" >Ads ?&check;</div>
        <div class="right" id="time">--</div>
    </div>

    <div class="tabletext">
    <div class="left" >Dark Theme?&times;</div>
        <div class="right" id="day">--</div>
    </div>




        </div>




        <div class="nav">
            <hr/>
            <h1>
            <?php echo $setting2_project_name; ?>
            </h1>

            <div class="nav btn">
                <span onclick="showbycategory('World');">World</span>
                <span onclick="showbycategory('Sports');">Sports</span>
                <span onclick="showbycategory('breaking');">Breaking News</span>
                <span onclick="showbycategory('Business');">Business</span>
                <span onclick="showbycategory('Stories');">Stories</span>
            </div>
        </div>



        <div class="title">
        <?php echo $setting1_wlc_message; ?>
        </div>
<div id='searchBOX'>
    <input type="text" placeholder="You Can Type To Search"/>
    <span>&#x1F50D;</span>
</div>

<?php

// $sql = "SELECT * FROM articles ORDER BY created_at DESC";
$sql ="SELECT articles.*, users.author AS author_name FROM articles JOIN users ON articles.author_id = users.id ORDER BY articles.created_at DESC;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $breaking = $row['is_breaking']==1 ? 'breaking' : '';
        echo "<div class='category ".$row["category"]."  $breaking' div_article>";
        echo "<h2>" . $row["title"]. "</h2>";
        echo "<p>" . $row["content"]. "</p>";
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


<script>

        var elements = document.querySelectorAll('.category');
        function hide_all_categories()
        {
            // Loop through each element and set display to none
            elements.forEach(function(element) {
                element.style.display = 'none';
            });
        }
        hide_all_categories();



        //THE DEFAULT TO BE DISPLAYED IS (World)
        document.querySelectorAll('.World').forEach(function(element) {
                element.style.display = 'inline-block';
            });



    function showbycategory(current_category){
        hide_all_categories();
        document.querySelectorAll('.'+current_category).forEach(function(current_category) {
            current_category.style.display = 'inline-block';
            // console.log(current_category);
            });
    }
</script>


        



<script>
        function updateTime() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            const formattedTime = `${hours}:${minutes}:${seconds} ${ampm}`;
            document.getElementById('time').textContent = formattedTime;

    // Call getFullDate() and getDayName() if it's midnight
    if (hours === 12 && minutes === '00' && seconds === '00' && ampm === 'AM') {
        getFullDate();
        getDayName();
    }
        }

        

        function getDayName() {
            const now = new Date();
            const dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const dayName = dayNames[now.getDay()];
            document.getElementById('day').textContent = dayName;
        }

        function getFullDate() {
            const now = new Date();
            const day = now.getDate().toString().padStart(2, '0');
            const month = (now.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
            const year = now.getFullYear();
            const fullDate = `${day}-${month}-${year}`;
            document.getElementById('date').textContent = fullDate;
        }







        getFullDate();
        getDayName();
        updateTime();
        setInterval(updateTime, 1000);


</script>
    </body>
</html>