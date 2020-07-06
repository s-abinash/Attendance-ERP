<?php

$con= new mysqli("localhost:3306","admin_abinash","5&3c9qfdchRvmlTX","student");
    if ($con->connect_error)
    {
        die("Connection failed: " . $con->connect_error);
    }

?>

