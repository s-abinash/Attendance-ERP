<?php
include('../db.php');

// Change Password For Staffs   => Modal  => @s-abinash  
if (isset($_POST['oldpass'])) 
    {
        $old = sha1($_POST["current-password"], false);
        $new = sha1($_POST["new-password"], false);
        $staffid = $_POST["cfm-new-password"];
        $sql = "SELECT * from staff where staffid like '$staffid'";
        $data = $con->query($sql);
        $row = $data->fetch_assoc();
        if ($row['pass'] != $old) {
            echo 'error';
        } else {
            $sql = "UPDATE `staff` set `pass`='$new', `status`='Changed' WHERE `staffid` like '$staffid'";
            $con->query($sql);
            echo 'success';
        }
    }
?>