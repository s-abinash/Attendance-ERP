<?php

$con= new mysqli("localhost","root","","attendance");
    if ($con->connect_error)
    {
        die("Connection failed: " . $con->connect_error);
    }

?>