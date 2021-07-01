<?php

$con= new mysqli("localhost","attendance","teama3@kongu","attendance");
if ($con->connect_error)
{
    die("Connection failed: " . $con->connect_error);
}

?>