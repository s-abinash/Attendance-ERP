<?php
    include_once("../db.php");
    session_start();
    $sid=$_SESSION["id"];
    include_once("./header.php");
     if(isset($_POST["tab"]))
     {
          $tab=strtolower($_POST["tab"]);
          $code=$_POST["code"];
          $timetables=timetablesfn($con,$tab,$code,$project_array,$sid);
          $re=($con->query("SELECT * FROM `course_list` WHERE `code` LIKE '$code'"))->fetch_assoc();
          $dept=$re["dept"];
          $bat=$re["batch"];
          if($dept=="ME")
          {
               $dept='CSE';
          }
         $x=date("Y-m-d");
         $tdy=date_create($x);
         if($bat!=2017)
               $date=date("2021-01-18");
         else
               $date=date("2021-01-02");  
         $diff=intval(date_diff($tdy,date_create($date))->format("%a"))+1;
         $dates=array();
         for($i=1;$i<=$diff;$i++)
         { 
              if($con->query("select * from `holiday` where `date` LIKE '$date' AND `dept` LIKE '$dept' AND `year` like '$bat'")->num_rows!=0)
              {
                   $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                   continue;
              }
               $s=date("l", strtotime($date));
               if($date==="2020-01-02")
               {
                    $s="Wednesday";
               }
               foreach ($timetables as $key => $value) {
                    if((date($date)>=date($value["from"]))&&(date($date)<=date($value["to"])))
                    {
                         $day_per=$value["tt"];
                         break;
                    }
               }   
               foreach($day_per as $d=>$pd)
               {
                    if($d==$s)
                    {
                      
                         foreach($pd as $periods)
                         {
                              
                              if(in_array($code,$ele))
                              {                
                                   $sql="SELECT * FROM `$code` where date LIKE '$date' AND code LIKE '$sid' AND `period` LIKE '$periods'"; 
                              }
                              else
                              {
                                   $sql="SELECT * FROM `$tab` where date LIKE '$date' AND code LIKE '$code' AND `period` LIKE '$periods'"; 
                              }
                              $r=$con->query($sql);
                              if($r->num_rows==0)
                              {    
                                   array_push($dates,$date);
                              }
                         }
                    }
               }
               $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
          }

          
          $altsql="SELECT date,period FROM `alteration` WHERE `s1` LIKE '%$sid%' AND `c1` LIKE '$code' AND date<=CURRENT_DATE";
          $res=$con->query($altsql);
          $alt=array();
          while($row=$res->fetch_assoc())
          { 
               $alt+=array($row["date"]=>explode(",",$row["period"]));   
          }  
          if(empty($alt))
          {
               $alt="Empty";
          }  
          $alted="SELECT date,period FROM `alteration` WHERE `s2` LIKE '%$sid%' AND `c2` LIKE '$code' AND date<=CURRENT_DATE ";
          $res=$con->query($alted);
          $alted=array();
         
          while($row=$res->fetch_assoc())
          { 
               $per=array();
               $dated= $row["date"];
               $bv=explode(",",$row["period"]);
               foreach($bv as $periods)
               {
                    if(in_array($code,$ele))
                    { 
                         $sql="SELECT * FROM `$code` where date LIKE '$dated' AND code LIKE '$sid' AND `period` LIKE '$periods'"; 
                    }
                    else
                    {
                         $sql="SELECT * FROM `$tab` where date LIKE '$dated' AND code LIKE '$code' AND `period` LIKE '$periods'"; 
                    }
                    
                                           
                    $r=$con->query($sql);
                    if($r->num_rows==0)
                    {    
                         array_push($per,$periods);
                    } 
               } 
               if(!empty($per))
              {
                    if(array_key_exists($row["date"],$alted))
                    {
                         $alted[$row["date"]]=array_unique(array_merge($alted[$row["date"]],$per));
                    }
                    else{
                         $alted+=array($row["date"]=>$per);
                    }
               
              }   

          }  
          if(empty($alted))
          {
               $alted="Empty";
          }  
          echo json_encode(array($dates,$timetables,$alt,$alted));
          exit();
    }
    

    else if(isset($_POST["consolidate"]))
    {
         
         $tab=$_POST["tname"];
          $code=$_POST["ccode"];
          $_SESSION["tname"]=$tab;
          $_SESSION["ccode"]=$code;
          $_SESSION["cname"]=$name=($con->query("SELECT name FROM `course_list` WHERE code LIKE '$code'"))->fetch_assoc()["name"]; 
         $tab=strtolower($tab);
         if(in_array($_POST["ccode"],$ele))
         {
          $num=($con->query("SELECT date from `$code` where code LIKE '$sid'"))->num_rows;
          if($num>=1)
          {
               echo "export_ready_for_Elec";
          }
         }
         else
         {
          $num=($con->query("SELECT date from `$tab` where code LIKE '$code'"))->num_rows;
          if($num>=1)
          {
               echo "export_ready";
          }
         }
         
          
         if($num==0)
          {
               echo "empty";
          }
         
         exit();
    }
    else if(isset($_POST["cls"]))
    {
         
         $tab=strtolower($_POST["cls"]);
         $code=$_POST["code"];
         $sql="SELECT * FROM `course_list` WHERE code LIKE '$code'";
         $res=($con->query($sql))->fetch_assoc();
         $name=$res["name"]; 
         $sdept=$res["dept"]; 
         $sem=(($res["batch"]=='2017')?'VIII':($res["batch"]=='2018'?'VI':($res["batch"]=='2019'?'IV':'I')));
         $sec="";
         if($res["staffA"]==$sid)
         {
             $sec="A ";
         }
         else if($res["staffB"]==$sid)
         {
             $sec.="B";
         }
         else if($res["staffC"]==$sid)
         {
             $sec.="C";
         }
         else 
         {
             $sec.="D";
         }
      
         if(in_array($code,$ele))
         {
          $sql="SELECT * FROM `$code` WHERE code LIKE '$sid' ORDER BY `date` DESC,`period` ASC"; 
          $tab=$code;
          $code=$code;
         }
         else{
              $sql="SELECT * FROM `$tab` WHERE code LIKE '$code' ORDER BY `date` DESC,`period` ASC"; 
         }
         $res=$con->query($sql);
    
         while($row=$res->fetch_assoc())
         {
               $cnt=mysqli_num_fields($res)-3;
               $d1=$row["date"];
              $d=date("d-m-Y",strtotime($d1));
              $h=$row["period"];
              $abs='<b><em>Course &nbsp: &nbsp'.$name.'<br><br>Date &nbsp: &nbsp '.$d.'<br><br>Absentees:<br> <ol class="ui  list">';
              $ABS_ROLL=array();
              foreach($row as $ind=>$val)
              {
                   if($val=="A")
                   {
                        array_push($ABS_ROLL,$ind);
                        $abs.='<li>'.$ind.'&nbsp; - &nbsp;'.($con->query("SELECT name from registration where regno like '$ind'"))->fetch_assoc()["name"].'</li>';
                   }
              }
              $abs.='</ol></b></em>';
              if(array_key_exists("P",array_count_values($row)))
              {
                    $P=array_count_values($row)["P"];
              }
              else
              {
                    $P=0;
              }
              if(array_key_exists("A",array_count_values($row)))
              {
                    $A=array_count_values($row)["A"];
              }
              else
              {
                    $A=0;
              }
             
              if(array_key_exists("N/A",array_count_values($row)))
              {
                    $na=array_count_values($row)["N/A"];
              }
              else
              {
                    $na=0;
              }
              $cnt-=$na;

              $stf=($con->query("SELECT * FROM `staff` WHERE `staffid` like '$sid'"))->fetch_assoc();

              
              echo '<div class="ui raised  segment" style="width:80%;margin:auto;margin-top:3%;">
                     
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
                                   </div>';
 
                                  
                                   
                         echo '</div></div>
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
    else if(isset($_POST["editor"]))
    {
          $_SESSION["code"]=$_POST["e_code"];
          $_SESSION["period"]=$_POST["e_period"];
          $_SESSION["date"]=$_POST["e_date"];
          $_SESSION["EditAttnd"]="go&edit";
         if(!in_array($_POST["e_code"],$ele))
         {
          $tab=strtoupper($_POST["edittab"]);
          $arr=explode('-',$tab,3);
          $_SESSION["sec"]=$arr[2];
          $_SESSION["batch"]=$arr[0];
          $_SESSION["dep"]=$arr[1];
          echo "go&edit";
          exit();
         }
         echo "go&editElec";
          exit();
    }
?>
