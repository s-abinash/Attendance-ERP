<?php

$con= new mysqli("localhost","root","","attendace");
    if ($con->connect_error)
    {
        die("Connection failed: " . $con->connect_error);
    }

?>