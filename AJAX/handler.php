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
            $_SESSION["dept"]=$row['dept'];
            echo "Success";
       }
       else
       {
            echo "Error";
       }
      exit();
       
    }
    else if(isset($_POST["tab"]))
    {
         $tab=strtolower($_POST["tab"]);
         $code=$_POST["code"];
         $sql="SELECT * FROM `tt` WHERE `class` LIKE '$tab'";
         $res=$con->query($sql);
         $day=array();
         while($row=$res->fetch_assoc())
         { 
              $per = array($row["1"],$row["2"], $row["3"],$row["4"],$row["5"]);
              if(in_array($code, $per))
              {
               array_push($day,$row["day"]);
              }
         }
         $x=date("Y-m-d");
         $tdy=date_create($x);
         $date=date("2020-07-08");
         $diff=intval(date_diff($tdy,date_create($date))->format("%a"))+1;
         $dates=array();
     
         for($i=1;$i<=$diff;$i++)
         {    
              $s=date("l", strtotime($date));
               if(in_array($s,$day))
               {
                    $sql="SELECT * FROM `$tab` where date LIKE '$date' AND code LIKE '$code'"; 
                    $r=$con->query($sql);
                    if($r->num_rows==0)
                    {    
                         array_push($dates,$date);
                    }
               }
               $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
         }
          echo json_encode($dates);

    }
?>