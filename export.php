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
    <title>Export</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <link rel="icon" type="image/png" href="./images/KEC.png">
    <?php include_once('./assets/notiflix.php'); ?>
</head>

<body>
    <?php
include_once('./navbar.php');
?>
    <style>
    body {
        background: url("./images/bgpic.jpg");
    }
    </style>
    <div class="ui header" style="text-align:center;font-size:30px;margin-top:2%;color:#ADEFD1FF">Export Attendance
    </div>
    <div class="ui message" style="text-align:center;width:80%;margin: 0 auto;">
        <div class="header">
            18CST51 - Software Engineering
        </div>
    </div><br />
    <table class="ui violet table" style="width:80%;margin: 0 auto;">
        <thead>
            <tr>
                <th>Roll No.</th>
                <th>18CSR002</th>
                <th>18CSR003</th>
                <th>18CSR004</th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <td>08/07</td>
                <td>P</td>
                <td>P</td>
                <td>A</td>
            </tr>
            <tr>
                <td>09/07</td>
                <td>P</td>
                <td>A</td>
                <td>A</td>
            </tr>
            <tr>
                <td>Consolidated</td>
                <td>2/2</td>
                <td>1/2</td>
                <td>0/2</td>
            </tr>
        </tbody>
    </table>

</body>

</html>