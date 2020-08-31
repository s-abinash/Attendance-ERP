<?php
session_start();
include_once('db.php');
if (isset($_POST["email"]))
{   
    $mail=$_POST["email"];
   
    $sql="select * from staff where `mail` LIKE '$mail'";
    $res=$con->query($sql);
    $count=$res->num_rows;
   if($count==1)
   {     
      $row=$res->fetch_assoc();
      $_SESSION["id"]=$row['staffid'];
      $_SESSION["id_token"]=$_POST['id_token'];
      $_SESSION["name"]=$row['name'];
      $_SESSION["dept"]=$row['dept'];
      $_SESSION['batch']=$row['batch'];
      $_SESSION['design']=$row['designation'];
      $_SESSION['sec']=$row['sec'];
      $_SESSION['image']=$_POST['image'];

      echo 'success';
   }
   else
   {
    echo "failed";
   }
}
?>