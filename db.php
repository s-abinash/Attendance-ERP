<?php

$con= new mysqli("localhost","attendance","attendance2021","attendance");
if ($con->connect_error)
{
    die("Connection failed: " . $con->connect_error);
}

?>