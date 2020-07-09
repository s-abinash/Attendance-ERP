<?php
    include_once("../db.php");
    
    if (isset($_POST["usr"]))
    {   
        $id=$_POST["userid"];
        $pass=SHA1($_POST["pass"]);
        $sql="select * from staff where userid LIKE '$id' AND pass LIKE '$pass'";
        $res=$con->query($sql);
        $count=$res->num_rows;
       if($count==1)
       {
          session_start();
          $row=$res->fetch_assoc();
          $_SESSION["id"]=$row['staffid'];
          $_SESSION["name"]=$row['name'];
          $_SESSION["dept"]=$row['dept'];
          $_SESSION['batch']=$row['batch'];
          $_SESSION['design']=$row['designation'];
          $_SESSION['sec']=$row['sec'];
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
          exit();

    }
    else if(isset($_POST["cls"]))
    {
         $tab=strtolower($_POST["cls"]);
         $code=$_POST["code"];
         $sql="SELECT name FROM `course_list` WHERE code LIKE '$code'";
         $name=($con->query($sql))->fetch_assoc()["name"]; 
         $sql="SELECT * FROM `$tab` WHERE code LIKE '$code' ORDER BY `date` DESC,`period` ASC"; 
         $res=$con->query($sql);
         $cnt=mysqli_num_fields($res)-3;
         while($row=$res->fetch_assoc())
         {
              $d=date("d-m-Y",strtotime($row["date"]));
              $h=$row["period"];
          //     $abs=array();
              $abs='<b><em>Course &nbsp: &nbsp'.$name.'<br><br>Date &nbsp: &nbsp '.$d.'<br><br>Absentees:<br> <ol class="ui  list">';
              foreach($row as $ind=>$val)
              {
                   if($val=="A")
                   {
                        $abs.='<li>'.$ind.'&nbsp; - &nbsp;'.($con->query("SELECT name from registration where regno like '$ind'"))->fetch_assoc()["name"].'</li>';
                   }
              }
              $abs.='</ol></b></em>';
              
              $P=array_count_values($row)["P"];
              $A=array_count_values($row)["A"];//<a class="ui red ribbon label">'.$d.'</a>
               echo '<div class="ui raised  segment" style="width:50%;margin:auto;margin-top:3%;"><div class="ui black info right circular icon message">
                         <div class="ui header">
                       
                              Date &nbsp;:&nbsp; '.$d.'  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;   Period &nbsp;: &nbsp '.$h.'</span>
                         </div>
                         <div class="content">
                              <div class="ui inverted small statistics" style="margin-left:10%">
                                   <div class="statistic">
                                        <div class="value">
                                             '.$P.'
                                        </div>
                                        <div class="label">
                                             Present
                                        </div>
                                   </div>
                                   <div class="red statistic" id="'.$d.$h.'" >
                                        <div class="value">
                                             '.$A.'
                                        </div>
                                        <div class="label">
                                             Absent
                                        </div>
                                   </div>
                                   <div class="blue statistic">
                                        <div class="value">
                                             '.$cnt.'
                                        </div>
                                        <div class="label">
                                             Total
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div></div><div class="ui popup" id="pop'.$d.$h.'" style="width:100%">'.$abs.'</div>
                    <script>
                    $(document).ready(function(){
                         $("#'.$d.$h.'")
                         .popup({
                         popup: "#pop'.$d.$h.'",
                         inline     : true,
                         hoverable  : true,
                         });
                    });
                    </script>';
              
         }
    }
?>