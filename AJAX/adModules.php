<?php
    include_once("../db.php");
    session_start();
    $sid=$_SESSION["id"];
    include_once("./header.php");
    if(isset($_POST["s1drop"]))
    {
        $sql="SELECT `code`,`name` FROM `course_list` WHERE `staffA` LIKE '%$sid%' OR `staffB` LIKE '%$sid%' OR `staffC` LIKE '%$sid%' OR `staffD` LIKE '%$sid%' ORDER BY batch desc";
        $res=$con->query($sql);
        $drop=array();
        while($row=$res->fetch_assoc())
        {
          array_push($drop,$row);
        }
        echo json_encode($drop);
    }

    else if(isset($_POST["s1c1"]))
    {
          $code=$_POST["s1c1"];
          $row=$con->query("SELECT * from course_list where code LIKE '$code'")->fetch_assoc();
          $b=intval($row['batch'])%2000;
          $c=strtolower($row['dept']);
          $c1=$row['dept'];
          $b1=$row['batch'];
          if(substr_count($row["staffA"],$sid))
          {
               $sec="a";
               $d1="staffA";
          }
          else if(substr_count($row["staffB"],$sid))
          {
               $sec="b";
               $d1="staffB";
          }
          else if(substr_count($row["staffC"],$sid))
          {
               $sec="c";
               $d1="staffC";
          }
          else if(substr_count($row["staffD"],$sid))
          {
               $sec="d";
               $d1="staffD";
          }
          if($b1==2020)
          {
               $sec='-';
          }
        $ss2="SELECT `code`,`name`,`$d1` from course_list where dept LIKE '$c1' AND batch LIKE '$b1' AND `$d1` IS NOT NULL AND `$d1` NOT LIKE '$sid'";
        $ref=$con->query($ss2);
        $s2=array();
        $s3=array();
        while($rs=$ref->fetch_assoc())
        {
          $stfid=$rs[$d1];
          if(strlen($stfid)>10)
          {
               $stfids=$stfid;
               foreach (explode(" ",$stfids) as $stfid ) 
               {
                    if($stfid===$sid)
                         continue;
                    $stfname=$con->query("SELECT `name` from `staff` where `staffid` LIKE '%$stfid%'")->fetch_assoc()['name'];
                    $stfname=trim($stfname);
                    if(!array_key_exists($stfid,$s2))
                         $s2+=array($stfid=>array(array($stfname,$rs["code"],$rs["name"])));
                    else
                         $s2[$stfid][1]=array($stfname,$rs["code"],$rs["name"]);
               }
              
          }
          else
          {
               $stfname=$con->query("SELECT `name` from `staff` where `staffid` LIKE '%$stfid%'")->fetch_assoc()['name'];
               if(!array_key_exists($stfid,$s2))
                    $s2+=array($stfid=>array(array($stfname,$rs["code"],$rs["name"])));
               else
                    $s2[$stfid][1]=array($stfname,$rs["code"],$rs["name"]);
          }
        }
        
        $tab=$b."-".$c."-".$sec;
        
         $timetables=timetablesfn($con,$tab,$code,$project_array,$sid);

         $x=date("Y-m-d");
         $tdy=date_create($x);

          //  Start Date for specific batch
          if($b1==2017)
               $date=date("2021-01-02");
          else if(($b1==2018))
               $date=date("2021-01-18");
          else if(($b1==2019))
               $date=date("2021-02-03");
          else if ($b1==2020) 
               $date=date("2021-01-04");
         
         $diff=intval(date_diff($tdy,date_create($date))->format("%a"))+1;
         $diff+=30;
         $dates=array();

        
         for($i=1;$i<=$diff;$i++)
         {    
              
              if($con->query("select * from `holiday` where `date` LIKE '$date' AND `dept` LIKE '$c1' AND `year` like '$b1' and `type` like 'Holiday'")->num_rows!=0)
              {
                   $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                   continue;
              }
               $s=date("l", strtotime($date));
               $chan=$con->query("select * from `alter_tt_day` where `batch` like '%$b1%' and `date` like '$date'");
               if($chan->num_rows!=0)
               {
                    $s=$chan->fetch_assoc()["to_day"];
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
                         $prd=array();
                         foreach($pd as $periods)
                         {
                              if($con->query("select * from `holiday` where `date` LIKE '$date' AND `periods` like '%$periods%' AND  `dept` LIKE '$c1' AND `year` like '$b1' and `type` like 'Suspension'")->num_rows!=0)
                              {
                                   $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                                   continue;
                              } 
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
                                   $altsql="SELECT * FROM `alteration` WHERE `s1` LIKE '$sid' AND `c1` LIKE '$code' AND `date` like '$date' and `period` like '$periods'";
                                   $res=$con->query($altsql);
                                   if($res->num_rows==0)
                                   {
                                        array_push($prd,$periods);
                                   }
                              }
                         }
                         if(!empty($prd))
                         {
                              $dates+=array($date=>$prd);
                         }
                         
                    }
               }
               $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
          }
          $alted="SELECT date,period FROM `alteration` WHERE `s2` LIKE '$sid' AND `c2` LIKE '$code' AND date<=CURRENT_DATE";
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
                   if(!array_key_exists($row["date"],$dates))
                   {
                         $dates+=array($row["date"]=>$per);
                   }
                   else
                   {
                         $dates[$row["date"]]=array_unique(array_merge($dates[$row["date"]],$per));
                   }
                    
              }   

          }  
          echo json_encode(array($dates,$s2));
          exit();
    }


    else if(isset($_POST["holidays"]))
    {
         $dept=$con->query("SELECT * from `staff` where `staffid` like '$sid'")->fetch_assoc()["dept"];
         $com=$_POST["comment"];
         $type=$_POST["type"];
         foreach($_POST["year"] as $y)
          {
          foreach($_POST["holidays"] as $hol)
          {
               
               $hol =date('Y-m-d', strtotime(str_replace('/', '-',$hol)));
               
              $sql="INSERT INTO `holiday`(`date`, `dept`, `year`, `type`, `comments`) VALUES ('$hol','$dept','$y','$type','$com')";
               if(!($con->query($sql)))
               {
                  
                    echo 'failed';
                    return;
               }
          }
          }
          echo 'success';
          exit();
    }
?>
