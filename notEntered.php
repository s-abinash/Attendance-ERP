
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

$ele=array("14CSE06","14CSE11","14CSO07","14ITO01","18ITO02","18MEO01","18CSO01");

$temp='';
?>
<script type="text/javascript">
$(function(){

  $('.overlay.fullscreen.modal').modal({
    transition: 'horizontal flip'
  }).modal('show');
  
  });
  
</script>
<div class="ui overlay fullscreen modal">

  <div class="header">Missing Attendace List
  <a href="exportAdv.php"><i class="close icon" style="float:right"></i></a>
  </div>
    
    <div class="scrolling content" style="overflow: auto;">
    <div class="ui raised segment">
    <table class="ui celled table">
        <thead>
            <tr><th>Subject</th>
            <th>Staff</th>
            <th>Dates</th>
            <th>Inform</th>
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
                $x=date("Y-m-d");
                $tdy=date_create($x);
                $date=date("2020-08-03");
                $diff=intval(date_diff($tdy,date_create($date))->format("%a"))+1;
                $dates=array();
                for($i=1;$i<=$diff;$i++)
                {    
                    $s=date("l", strtotime($date));
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
                                        array_push($dates,$date);
                                }
                            }
                    }
                    $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                }
                echo '<div class="bulleted list">';
                $mailcontent="Dear ".$sname." Attendace entry is pending for '".$ssub. "' on the following dates:".'%0A%0A';
                $datecell='';
                foreach($dates as $i)
                {    
                    $mailcontent.=date_format(date_create($i),"d-m-Y").'%0A';
                    $datecell.=date_format(date_create($i),"d-m-Y").'<br>';
                }
              
                $mailcontent.="%0AKindly mark the attendance ASAP %0A %20 -"."Advisor";
                $mailcontent="mailto:".$smail."?subject=Attendace%20Pending%20report&body=".$mailcontent;
                if(count($dates)!=0)
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
                    echo '<td><a href="#" target="_blank">
                          <button class="ui violet button" disabled>
                          <i class="mail icon"></i> Send Mail
                          </button></a></td>';
                }
                echo '</tr>';
                    
            }
            echo '</tbody></table>';
        ?>
 </div>
  </div>
    <div class="actions">
        <a href="exportAdv.php"><div class="ui bottom attached black button">Close</div></a>
    </div>
</div>

