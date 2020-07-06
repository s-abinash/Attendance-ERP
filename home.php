<?php
    session_start();
    include_once("navbar.php");
    if(!isset($_SESSION["id"]))
    {
        header('Location: ./login.php');
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
 
</head>
<body background="images/bgpic.jpg">

</body>
</html>