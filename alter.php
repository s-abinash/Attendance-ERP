<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}

include_once("./db.php");
// $table=strtolower($_SESSION["tname"]);
// $code=$_SESSION["ccode"];
// $course=$_SESSION["cname"];
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alter</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <link rel="icon" type="image/png" href="./images/KEC.png">

    <?php include_once('./assets/notiflix.php'); ?>
  

</head>

<body id="root">
    <?php
include_once('./navbar.php');
?>
    <style>
    body {
        background: url("./images/bgpic.jpg");
    }
    #card {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
   
    </style>
<div class="card-1">
        <div class="ui raised padded container segment" id="card" style="margin:auto;width:50%;">
            <center>
                <h1 class="header">
                    Alter Period
                </h1>
            </center>
           
            <form class="ui form" name="mainform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="field">
                    <label>Course to Alter:</label>
                    <select class="ui search dropdown" id="alterfrom">
                    <option value="">Select Course</option>
                    <option value="18CST51">Computer Networks</option>
                    <option value="18CST52">Theory of Computation</option>
                    </select>
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Date</label>
                        <div class="ui calendar" id="standard_calendar">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" placeholder="Date/Time">
                        </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Period</label>
                        <select class="ui dropdown" id="period">
                        <option value="">Select Period</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        </select>
                    </div>
                </div><br/>
                <div class="ui horizontal divider">
                    To
                </div><br/>
               
                <div class="field">
                    <label>Staff to Alter:</label>
                    <select class="ui search dropdown" id="alterfrom">
                    <option value="">Select Course</option>
                    <option value="CSE001SF">Dr. N. Shanthi</option>
                    <option value="CSE002SF">Dr. R.R.Rajalakshmi</option>
                    </select>
                </div>
                
                <button style="float: right;" class="ui positive button" type="submit">Confirm Alter</button>
                <br/><br/>
            </form>
            <div class="ui warning message">
            <i class="close icon"></i>
            <div class="header">
                Once altered cannot be changed again
            </div>
        </div>
        </div>
        </div>
        <script>
            $(document).ready(function(){
                $(".ui.dropdown").dropdown({
                    clearable: true
                });
                $('#period').dropdown();
                $('#standard_calendar').calendar({
                    type: 'date',
                });
                $('.message .close').on('click', function() {
                    $(this)
                    .closest('.message')
                    .transition('fade');
                });

            });
        </script>
        </body>
        </html>
            
    