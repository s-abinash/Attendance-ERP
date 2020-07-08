<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
// else 
// {
//     if($_SESSION['design']!='Advisor')
//         header('Location: index.html');
// }
include_once('db.php');
$batch=$_SESSION['batch'];

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>

    <?php include_once('./assets/notiflix.php'); ?>
    <?php
include_once('./navbar.php');
?>
    <script>
    var tdy = new Date();
    $(document).ready(function() {
        $('#cal').calendar({
            type: 'date',
            maxDate: tdy,
            formatter: {
                date: function(date, settings) {

                    if (!date) return '';
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    return day + '/' + month + '/' + year;
                }
            }
        });

        $('#code').dropdown();
    });
    </script>
</head>

<body>
    <style>
    body {
        background: url('./images/bgpic.jpg');
    }
    </style>
    <div class="card-1">
        <div class="ui raised padded container segment" id="card" style="margin:auto;width:60%;">
            <center>
                <h1 class="header">
                    Edit Attendance
                </h1>
            </center>
            <form class="ui form" name="upload" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="two fields">
                    <div class="field">
                        <label>Date:</label>
                        <div class="ui calendar" id="cal">
                            <div class="ui  focus input left icon">
                                <i class="calendar icon"></i>
                                <input type="text" name="date" placeholder="Date" required>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Course:</label>
                        <select name="code" class="ui fluid search dropdown" id="code" required>
                            <option value="">Select the Course</option>
                            <?php 
                                $sql="SELECT code,name from course_list WHERE batch like '$batch'";
                                $data=$con->query($sql);
                                while($row=mysqli_fetch_array($data))
                                {
                                    $cd=$row['code'];
                                    $cn=$row['name'];
                                    echo '<option value="'.$cd.'">'.$cn.'</option>';
                                }
                            ?>

                        </select>
                    </div>

                </div>
                <div class="field">
                    <center><button class="ui positive button" type="submit" name="fetch">Fetch</button></center>
                </div>
            </form>
        </div>
    </div>


    <div class="card-2" style="display: none">
        <div class="ui raised padded container segment" id="card" style="margin:auto;width:60%;">
            <center>
                <h1 class="header">
                    Edit Attendance
                </h1>
            </center>
            

        </div>
</body>

</html>