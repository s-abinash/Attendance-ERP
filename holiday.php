<?php
session_start();

if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
include_once("./db.php");
$sid=$_SESSION["id"];
$res=$con->query("SELECT * FROM staff where `staffid` LIKE '$sid'")->fetch_assoc();
if($res["designation"]!=="HOD")
{
    header('Location: home.php');
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holiday</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <link rel="icon" type="image/png" href="./images/KEC.png">

    <?php include_once('./assets/notiflix.php'); ?>
    <style>
 
    </style>

</head>

<body id="root">
    <?php
include_once('./navbar.php');
?>
    <style>
    body {
        background: url("./images/bgpic.jpg");
    }
    </style>
    
</body>

</html>
