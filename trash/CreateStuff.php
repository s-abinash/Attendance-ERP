<?php

//                                  ==============================
//                                  Insert Values into Class Table
//                                  ==============================

//    include_once("./db.php");
//    session_start();
//        $cnt=0;
//         $d=date('Y-m-d');
//         $str="INSERT INTO `18-CSE-A` VALUES(".$d.",'18CST38',";      
//         for($i=1;$i<=60;$i++)
//         {
//             $str.="'P',";   
//         }
//         $str=substr($str,0,strlen($str)-1);
//         $str.=")";
//         if($con->query($str))
//         {
//             echo "Successfull";
//         }
//         else
//         {
//             echo $str;
//             echo "error";
//         }




//                                  ==============================
//                                           Create  Table
//                                  ==============================




include_once("../db.php");
session_start();


$tableName="20MSE01";


$str="CREATE TABLE `$tableName` (date varchar(10) NOT NULL,code varchar(10) NOT NULL,period int NOT NULL,";
$sql="SELECT regno FROM `elective` WHERE `E1` LIKE '$tableName'";

$res=$con->query($sql);
while($row=$res->fetch_assoc())
{
  $roll=$row["regno"];
    $str.=$roll." VARCHAR(3) DEFAULT 'N/A',";   
}
$str.="PRIMARY KEY(DATE,CODE,PERIOD))";
if($con->query($str))
{
    echo "Successfull";
}
else
{
    echo $str;
    echo "error";
}

exit();



//                                  =====================================
//                                  Check Table Columns with Registration
//                                  =====================================


// include_once("../db.php");
// $batch="2017";
// $tab="17-cse-c";
// $sec="C";
// $res=$con->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'$tab' AND `COLUMN_NAME`");
// $col=array();
// while($row=$res->fetch_assoc())
// {
//     array_push($col,$row["COLUMN_NAME"]);
// }
// $res=$con->query("SELECT regno FROM registration WHERE batch LIKE '$batch' AND sec LIKE '$sec'");
// $reg=array();
// while($row=$res->fetch_assoc())
// {
//     array_push($reg,$row["regno"]);
// }
// print_r(array_diff($reg,$col));
// print_r(array_diff($col,$reg));



//                                  =====================================
//                                                Table View
//                                  =====================================





//     session_start();
//     include_once("navbar.php");
//     if(!isset($_SESSION["id"]))
//     {
//         header('Location: ./index.php');
//     }
// ?>


<!-- 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body >
    <style>
    body
    {
        background-image: url("./images/bgpic.jpg");
    }
    </style>
    <div class="ui header" style="text-align:center;font-size:30px;margin-top:2%;color:#ADEFD1FF">Your Class Associations</div>
    <table class="ui selectable striped  table" style="margin:auto;width:70%;margin-top:5%">
  <thead>
    <tr  style="color:black;font-size:20px" class="center aligned">
      <th>Year</th>
      <th>Section</th>
      <th>Course Code</th>
      <th>Course Name</th>
      <th >Actions</th>
    </tr>
  </thead>
  <tbody class="center aligned">
    <tr><td colspan="5" style="font-size:17px" class="left aligned"><em>General Course</em></td></tr>
    <tr>
      <td>II</td>
      <td>A</td>
      <td>18ITT051</td>
      <td>Computer Networks</td>
      <td class="right aligned"><button class="ui primary right icon button "> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button></td>
    </tr>
    <tr >
      <td >II</td>
      <td>A</td>
      <td>18ITT051</td>
      <td>Computer Networks</td>

      <td class="right aligned"><button class="ui primary right icon button "> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button></td>
    </tr>
    <tr ><td colspan="5" style="font-size:17px" class="left aligned"><em>Laboratory Course</em></td></tr>
    <tr >
      <td>II</td>
      <td>A</td>
      <td>18ITT051</td>
      <td>Computer Networks</td>

      <td class="right aligned"><button class="ui primary right icon button "> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button></td>
    </tr>
    
  </tbody>
</table>
</body>
</html> -->



