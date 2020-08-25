<?php

$con= new mysqli("localhost","studentplus","studentplus","studentplus");
    if ($con->connect_error)
    {
        die("Connection failed: " . $con->connect_error);
    }

?>
