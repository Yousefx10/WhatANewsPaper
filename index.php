<?php

require 'admin/sql.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>READING IS FUN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="style.css"/>
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
            <h1>What A News Papers</h1>

            <div class="nav btn">
                <span onclick="showbycategory('World');">World</span>
                <span onclick="showbycategory('Sports');">Sports</span>
                <span onclick="showbycategory('breaking');">Breaking News</span>
                <span onclick="showbycategory('Business');">Business</span>
                <span onclick="showbycategory('Stories');">Stories</span>
            </div>
        </div>



        <div class="title">
        Enjoy Reading
        </div>


<?php

// $sql = "SELECT * FROM articles ORDER BY created_at DESC";
$sql ="SELECT articles.*, users.author AS author_name FROM articles JOIN users ON articles.author_id = users.id ORDER BY articles.created_at DESC;";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $breaking = $row['is_breaking']==1 ? 'breaking' : '';
        echo "<div class='".$row["category"]." category $breaking'>";
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
                element.style.display = 'block';
            });

    function showbycategory(current_category){
        hide_all_categories();
        document.querySelectorAll('.'+current_category).forEach(function(current_category) {
            current_category.style.display = 'block';
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