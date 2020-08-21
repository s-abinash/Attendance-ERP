
<?php 
session_start();
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
  <div class="header">Missing Attendace List</div>
    <i class="close icon"></i>
    <div class="scrolling content" style="overflow: auto;">
    <div class="ui raised segment">
    <div class="ui list">
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
                $temp='staff'.$sec;
                $sid=$row[$temp];
                $sql="SELECT * from `staff` WHERE `staffid` like '$sid'";
                $temp=($con->query($sql))->fetch_assoc();
                $sname=$temp['name'];
                $smail=$temp['mail'];
                $ssub=$row['name'];
                echo '<h2 class="item"><span style="color:red">'.$row['name'].'</span> - <span style="color:blue;">'.$sname.'</span></h2>';
               
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
                foreach($dates as $i)
                {    
                    $mailcontent.=date_format(date_create($i),"d-m-Y").'%0A';
                    echo '<div class="item">'.date_format(date_create($i),"d-m-Y").'</div>';
                }
                $mailcontent.="%0AKindly mark the attendance ASAP %0A %20 -"."Advisor";
                $mailcontent="mailto:".$smail."?subject=Attendace%20Pending%20report&body=".$mailcontent;
                if(count($dates)!=0)
                    echo '</div><a href="'.$mailcontent.'" target="_blank">
                          <button class="ui red button">
                          <i class="mail icon"></i> Send Mail
                          </button></a>';
            }
        ?>
    </div>
  </div>
  </div>
    <div class="actions">
        <div class="ui cancel button">Close</div>
    </div>
</div>

