<?php
include('../db.php');

// Change Password For Staffs   => Modal  => @s-abinash  
if (isset($_POST['oldpass'])) 
    {
        $old = sha1($_POST["oldpass"], false);
        $new = sha1($_POST["newpass"], false);
        $staffid = $_POST["staffid"];
        $sql = "SELECT * from staff where staffid like '$staffid'";
        $data = $con->query($sql);
        $row = $data->fetch_assoc();
        if ($row['pass'] != $old) {
            echo 'error';
        } else {
            $sql = "UPDATE `staff` set `pass`='$new', `status`='Changed' WHERE `staffid` like '$staffid'";
            $con->query($sql);
            echo 'success';
        }
    }


    if(isset($_POST['dept']))
    {
        
        $batch=$_POST['batch'];
        $from=date('Y-m-d', strtotime(str_replace('/', '-',$_POST['st'])));
        $to=date('Y-m-d', strtotime(str_replace('/', '-',$_POST['en'])));

        if($batch==2017)
            $table=["17-cse-a","17-cse-b","17-cse-c","17-cse-d"];
        else if($batch==2018)
            $table=["18-cse-a","18-cse-b","18-cse-c","18-cse-d"];
        else if($batch==2019)
            $table=["19-cse-a","19-cse-b","19-cse-c","19-cse-d"];
        else if($batch==2020)
            $table=["20-me--"];
        $table=array_merge($table,elect($con,$batch)); 
        echo json_encode(Compute($con,$table,$from,$to));
        exit();
    }
// ===========================================   Functions   ====================================================
function elect($con,$batch)
{
    $ele=array();
    $res=$con->query("SELECT `code` FROM `course_list` WHERE `batch` like '$batch' and `category` like 'elective'");
    while($row=$res->fetch_assoc())
    {
        array_push($ele,$row['code']);
    }
    return $ele;
}

function Compute($con,$tables,$from,$to)
{
    $theory=$lab=$tut=$test=$proj=0;
    foreach ($tables as $table) {
        $sql="SELECT `type` , COUNT(`type`) as cnt FROM `$table` WHERE `date`>= '$from' and `date`<='$to' GROUP BY `type`";
        $res=$con->query($sql);
        while($row=$res->fetch_assoc())
        {
            if($row["type"]==="Theory")
                $theory+=$row["cnt"];
            else if($row["type"]==="Tutorial")
                $tut+=$row["cnt"];
            else if($row["type"]==="Test")
                $test+=$row["cnt"];
            else if($row["type"]==="Laboratory")
                $lab+=$row["cnt"];
            else if($row["type"]==="Project")
                $proj+=$row["cnt"];
        }
        return array('theory' =>$theory , 'tut'=>$tut,'test'=>$test,'lab'=>$lab,'proj'=>$proj);
    }
}

// ===========================================   Functions   ====================================================




?>