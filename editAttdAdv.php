<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>

    <?php include_once('./assets/notiflix.php'); ?>
    <?php
include_once('./navbar.php');
?>
</head>

<body>
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
                        <select name="hrs" class="ui large fluid search dropdown" id="hr" required>
                            <option value="">Select the Hr</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>