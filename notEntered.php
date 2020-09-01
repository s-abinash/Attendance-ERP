
<?php 
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
include_once("./db.php");
$staffid=$_SESSION["id"];
$res=$con->query("SELECT * FROM staff where `staffid` LIKE '$staffid'")->fetch_assoc();
if($res["designation"]!="Advisor")
{
    header('Location: exportAdv.php');
}
include_once('navbar.php'); 
$staffid=$_SESSION['id'];

$sql="SELECT `code` FROM `course_list` where `dept` LIKE '$dept' AND `status` LIKE 'active' AND `category` LIKE 'ELECTIVE'";
$res=$con->query($sql);
$ele=array();
while($row=mysqli_fetch_array($res))
{
    array_push($ele,$row['code']);
}
$temp='';
?>
<head>
<title>Pending Report</title>
</head>
<style>
    body {
        background: url("./images/bgpic.jpg");
    }
    th{
        font-size: 20px;
    }

    </style>

  <div><center><h1 class="ui white header" style="color:white;margin-top:2%">Missing Attendace List</h1></center>
  
  </div>
 
    <table class="ui selectable celled table" style="width:80%;margin-right:10%;margin-left:10%;margin-bottom:3%">
        <thead>
            <tr><th>Subject</th>
            <th>Staff</th>
            <th>Dates &emsp;&emsp;&emsp;&ensp;&nbsp;- &ensp;Periods</th>
            <th><span class="ui brown button" onclick="window.print()"><i class="print icon"></i>Print</span></th>
        </tr>
        </thead>
        <tbody>
        <?php 
           
            $sql="SELECT `dept`,`batch`,`sec` from `staff` where `staffid` like '$staffid'";
            $temp=($con->query($sql))->fetch_assoc();
            $class=substr($temp['batch'],-2).'-'.strtolower($temp['dept']).'-'.$temp['sec'];
            $sql="SELECT * from `course_list` where `dept` = (SELECT `dept` from `staff` where `staffid` like '$staffid') and `batch` = (SELECT `batch` from `staff` where `staffid` like '$staffid') 
            and `status` like 'active';";
            $data=$con->query($sql);
            $sec=$temp['sec'];
            $tab=strtolower($class);
      
           
            while($row=mysqli_fetch_array($data))
            {
                echo '<tr>';
                $temp='staff'.$sec;
                $sid=$row[$temp];
                $sql="SELECT * from `staff` WHERE `staffid` like '$sid'";
                $temp=($con->query($sql))->fetch_assoc();
                $sname=$temp['name'];
                $smail=$temp['mail'];
                $ssub=$row['name'];
                echo '<td><span style="color:red">'.$row['name'].'</span></td>';
                echo '<td><span style="color:blue;">'.$sname.'</span></td>';
               
                $code=$row["code"];
                $sql="SELECT * FROM `ott` WHERE `class` LIKE '$tab'";
                $res=$con->query($sql);
                $day=array();
                $day_per=array();
                while($row=$res->fetch_assoc())
                { 
                    $per=array();
                    foreach($row as $in=>$v)
                    {
                        if(strpos($v,$code)!==false)
                        {
                                array_push($per,$in);
                        } 
                    }
                    if(!empty($per))
                    {
                            $day_per+=array($row["day"]=>$per);
                    }   
                }
                $ott=$day_per;
                $sql="SELECT * FROM `tt` WHERE `class` LIKE '$tab'";
                $res=$con->query($sql);
                $day=array();
                $day_per=array();
                while($row=$res->fetch_assoc())
                { 
                    $per=array();
                    foreach($row as $in=>$v)
                    {
                        if(strpos($v,$code)!==false)
                        {
                                array_push($per,$in);
                        } 
                    }
                    if(!empty($per))
                    {
                            $day_per+=array($row["day"]=>$per);
                    }   
                }
                $tt=$day_per;
                $x=date("Y-m-d");
                $tdy=date_create($x);
                $date=date("2020-07-08");
                $diff=intval(date_diff($tdy,date_create($date))->format("%a"))+1;
                $dates=array();
                
                for($i=1;$i<=$diff;$i++)
                {    $fin=array();
                    if($con->query("select * from holiday where date LIKE '$date'")->num_rows!=0)
                    {
                        $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                        continue;
                    }
                    $s=date("l", strtotime($date));   
                   if(date($date)<date("2020-08-03"))
                   {
                        $day_per=$ott;
                   }
                   else
                   {
                        $day_per=$tt;
                   }
                    $alt=array();
                   
                    $result=$con->query("SELECT * FROM `alteration` where `date` LIKE '$date' AND `s2` LIKE '$sid' AND `c2` LIKE '$code'");
                    if($result->num_rows!=0)
                    {
                        while($row=$result->fetch_assoc())
                        {
                            $prds=$row["period"];
                            if(in_array($code,$ele))
                                $sql="SELECT * FROM `$code` where date LIKE '$date' AND code LIKE '$sid' AND `period` LIKE '$prds'"; 
                            else
                                $sql="SELECT * FROM `$tab` where date LIKE '$date' AND code LIKE '$code' AND `period` LIKE '$prds'"; 
                            $r=$con->query($sql);
                            if($r->num_rows==0)
                                array_push($alt,$prds);
                        }
                    }
            
                    $day_pd=array();
                    foreach($day_per as $d=>$pd)
                    {
                            if($d==$s)
                            {    
                                foreach($pd as $periods)
                                {
                                    if(in_array($code,$ele))
                                        $sql="SELECT * FROM `$code` where date LIKE '$date' AND code LIKE '$sid' AND `period` LIKE '$periods'"; 
                                    else
                                        $sql="SELECT * FROM `$tab` where date LIKE '$date' AND code LIKE '$code' AND `period` LIKE '$periods'"; 
                                    $r=$con->query($sql);
                                    if($r->num_rows==0)
                                    {
                                        if(($con->query("SELECT * FROM `alteration` WHERE `s1` LIKE '$sid' AND `c1` LIKE '$code' AND`period` LIKE '$periods' AND `date` like '$date' "))->num_rows==0)
                                        {
                                            array_push($day_pd,$periods);
                                        }
                                    }     
                                }
                            }
                    }
                    if(!empty(array_merge($alt,$day_pd)))
                    {
                       
                        $dates+=array($date=>array_merge($alt,$day_pd));
                    }  
                    
                    $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                }
                echo '<div class="bulleted list">';
                $mailcontent="Dear ".$sname." Attendace entry is pending for '".$ssub. "' on the following dates:".'%0A%0A';
                $datecell='';
                foreach($dates as $i=>$pds)
                {  
                    
                    $mailcontent.=date_format(date_create($i),"d-m-Y").'%20'.'-'.'%20'.implode(",",$pds).'%0A';
                    $datecell.=date_format(date_create($i),"d-m-Y").' &emsp;- &ensp;'.implode(",",$pds).'<br>';
                }
              
                $mailcontent.="%0AKindly mark the attendance ASAP %0A %20 -"."Advisor";
                $mailcontent="mailto:".$smail."?subject=Attendace%20Pending%20report&body=".$mailcontent;
                if(!empty($dates))
                {
                    echo '<td>'.$datecell.'</td>';    
                    echo '<td><a href="'.$mailcontent.'" target="_blank">
                          <button class="ui violet button">
                          <i class="mail icon"></i> Send Mail
                          </button></a></td>';
                }
                else
                {
                    
                    echo '<td>NIL</td>';    
                    echo '<td>
                          <button class="ui violet button" disabled>
                          <i class="mail icon"></i> Send Mail
                          </button></td>';
                }
                echo '</tr>';
                    
            }
            echo '</tbody></table>';
        ?>

</body>
</html>

