<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>READING IS FUN</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <div class="header">

            <table border="1px">
                <tr>
                    <td>Maybe Logo</td>
                    <td></td>
                    <td id="date">Full Date</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td id="time">Full Time</td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td id="day">Full Day</td>
                </tr>   
            </table>
        </div>


        <div class="nav">
            <hr/>
            <h1>What A News Papers</h1>

            <div class="nav btn">
                <span>World</span>
                <span>Sport</span>
                <span>Breaking News</span>
                <span>Business</span>
                <span>Stories</span>
            </div>
        </div>



        <div class="title">
        Enjoy Reading
        </div>

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