<?php
    include_once("../db.php");
    
    if (isset($_POST["usr"]))
    {   
        $id=$_POST["userid"];
        $pass=SHA1($_POST["pass"]);
        $sql="select * from staff where userid LIKE '$id' AND pass LIKE '$pass'";
        $res=$con->query($sql);
        $count=$res->num_rows;
        $row=$res->fetch_assoc();
       if($count==1)
       {
            session_start();
            $_SESSION["id"]=$row['staffid'];
            $_SESSION["name"]=$row['name'];
            echo "Success";
       }
       else
       {
            echo "Error";
       }
      exit();
       
    }
?>