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
              $per = array($row["1"],$row["2"], $row["3"],$row["4"],$row["5"],$row["6"]);
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
              if(array_key_exists("A",array_count_values($row)))
              {
                    $A=array_count_values($row)["A"];
              }
              else
              {
                    $A=0;
              }
              echo '<div class="ui raised  segment" style="width:70%;margin:auto;margin-top:3%;">
                     
               <div class="ui black info right circular icon message">
             
               <div class="ui header">
                       
                              Date &nbsp;:&nbsp; '.$d.'  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;   Period &nbsp;: &nbsp '.$h.'</span>
                         </div>
                         <div class="content">
                              <div class="ui inverted small statistics" style="margin-left:25%">
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
                                   <div class="statistic">
                                        <div class="value">
                                              <button class="ui right floated tertiary icon button" data-tooltip="Click to Edit Uploaded Attendance" id="'.$code."/".$d."/".$h."/".$tab.'" onclick="editor(this.id);" data-position="top left"><i class="edit large icon" style="color:cyan"></i></button>
                                        </div>
                                        <div class="label">
                                             Edit
                                        </div>
                                   </div>
                         </div></div>
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
        exit();
    }
    else if(isset($_POST["consolidate"]))
    {
         session_start();
         $tab=$_POST["tname"];
          $code=$_POST["ccode"];
          $_SESSION["tname"]=$tab;
          $_SESSION["ccode"]=$code;
          $_SESSION["cname"]=$name=($con->query("SELECT name FROM `course_list` WHERE code LIKE '$code'"))->fetch_assoc()["name"]; 
         $tab=strtolower($tab);
         $num=($con->query("SELECT date from '$tab' where code LIKE '$code'"))->num_rows;
          if($num!=0)
          {
               echo "export_ready";
          }
          else if(num==0)
          {
               echo "empty";
          }
         
         exit();
    }
    else if(isset($_POST["editor"]))
    {
         session_start();
          $tab=strtoupper($_POST["edittab"]);

          $arr=explode('-',$tab,3);
          $_SESSION["sec"]=$arr[2];
          $_SESSION["batch"]=$arr[0];
          $_SESSION["dep"]=$arr[1];
          $_SESSION["code"]=$_POST["e_code"];
          $_SESSION["period"]=$_POST["e_period"];
          $_SESSION["date"]=$_POST["e_date"];
          $_SESSION["EditAttnd"]="go&edit";
          
          echo "go&edit";
          exit();
    }
?>
