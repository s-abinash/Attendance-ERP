<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
// else 
// {
//     if($_SESSION['design']!='Advisor')
//         header('Location: index.html');
// }
include_once('db.php');
$batch=$_SESSION['batch'];
$sec=$_SESSION['sec'];
$dep=$_SESSION['dept'];

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>

    <?php include_once('./assets/notiflix.php'); ?>
    <?php
include_once('./navbar.php');
?>
    <script>
    var tdy = new Date();
    $(document).ready(function() {
        $('#cal').calendar({
            type: 'date',
            maxDate: tdy,
            formatter: {
                date: function(date, settings) {

                    if (!date) return '';
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    return day + '/' + month + '/' + year;
                }
            }
        });

        $('#code').dropdown();
        $('#hr').dropdown();
    });
    </script>
</head>

<body>
    <style>
    body {
        background: url('./images/bgpic.jpg');
    }


    #card {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    </style>
    <?php

if(isset($_POST['fetch']))
{
    $date=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date'])));
    $code=$_POST['code'];
    $period=$_POST['hrs'];
    $class=strval(intval($batch)-2000).'-cse-'.strtolower($sec);
    $sql="SELECT * from `".$class."` WHERE `date` like '$date' and `code` like '$code' and `period` like '$period'";
    $data=$con->query($sql);
    if($data->num_rows==0)
    {
        echo "<script> Notiflix.Report.Failure( 'Record Not Found', 'Nothing Available for the given data', 'Okay' );</script>";
    }
    else
    {
        $_SESSION['date']=$date;
        $_SESSION['code']=$code;
        $_SESSION['period']=$period;
    }

    
    
}
?>
    <?php 
if(isset($_POST['fetch']))
{
    echo '<script>
            $(document).ready(function(){
                $(".card-1").css("display", "none");
            });
            $(document).ready(function(){
                $(".card-2").css("display", "");
            });
            </script>';
}
?>

    <div class="card-1">
        <div class="ui raised padded container segment" id="card" style="margin:auto;width:60%;">
            <center>
                <h1 class="header">
                    Edit Attendance
                </h1>
            </center>
            <form class="ui form" name="upload" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="two fields">
                    <div class="field">
                        <label>Date:</label>
                        <div class="ui calendar" id="cal">
                            <div class="ui  focus input left icon">
                                <i class="calendar icon"></i>
                                <input type="text" name="date" placeholder="Date" required>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label>Course:</label>
                        <select name="code" class="ui fluid search dropdown" id="code" required>
                            <option value="">Select the Course</option>
                            <?php 
                                $sql="SELECT code,name from course_list WHERE batch like '$batch'";
                                $data=$con->query($sql);
                                while($row=mysqli_fetch_array($data))
                                {
                                    $cd=$row['code'];
                                    $cn=$row['name'];
                                    echo '<option value="'.$cd.'">'.$cn.'</option>';
                                }
                            ?>

                        </select>
                    </div>
                    <div class="field">
                        <label>Period: </label>
                        <select name="hrs" class="ui search dropdown" id="hr" required>
                            <option value="">Select Period</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
                <div class="field">
                    <center><button class="ui positive button" type="submit" name="fetch">Fetch</button></center>
                </div>
            </form>
        </div>
    </div>

    <?php
                            
                            if(isset($_POST['finalize']))
                            {
                                    if($_POST['finalize']=='done')
                                    {
                                        //var_dump($_POST);
                                        $date=$_SESSION['date'];
                                        $code=$_SESSION['code'];
                                        $period=$_SESSION['period'];
                                        $class=strval(intval($batch)-2000).'-cse-'.strtolower($sec);
                                        
                                        $arr=array();
                                        $sql="SELECT regno from registration where batch like '$batch' and sec like '$sec' and dept like '$dep'";
                                        $data=$con->query($sql);
                                        $sql='UPDATE `'.$class.'` SET ';
                                        while($r=mysqli_fetch_array($data))
                                        {
                                            $r=$r['regno'];
                                            if(isset($_POST[$r]))
                                                $arr[$r]='P';
                                            else
                                                $arr[$r]='A';
                                        }
                                        foreach($arr as $a=>$b)
                                        {
                                            $sql.='`'.$a.'`="'.$b.'",';
                                        }
                                        $sql=substr($sql,0,-1);
                                        $sql.=" WHERE `date` like '$date' and `code` like '$code' and `period` like '$period';";
                                        //echo $sql;
                                        if($con->query($sql))
                                            echo "<script> Notiflix.Report.Success( 'Attendance Updated Successfully', 'You can review later.', 'Okay',function(){window.location.replace('home.php')} );</script>";
                                        else
                                            echo "<script> Notiflix.Report.Failure( 'Updation Failure', 'Contact Admin', 'Okay',function(){window.location.replace('home.php')} );</script>";
                                        exit();
                                    }
                                    else
                                    {
                                        unset($_SESSION['date']);
                                        unset($_SESSION['code']);
                                        unset($_SESSION['period']);
                                        echo '<script>window.location.replace("home.php");</script>';
                                    }
                            }
                            
                            
                            
                            ?>

    <div class="card-2" style="display: none">
        <div class="ui raised padded container segment" id="card" style="height:80%;overflow:auto;width:60%;">
            <center>
                <h1 class="header">
                    Edit Attendance
                </h1>
                <div class="description">
                    Color Diff refers changes that are currently made
                </div>
            </center>
            <form class="ui form" name="edit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="content">
                    <table class="ui compact table">
                        <thead>
                            <tr>
                                <th colspan="3">
                                    Attendance Report
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
            $date=$_SESSION['date'];
            $code=$_SESSION['code'];
            $period=$_SESSION['period'];
            $sql="SELECT regno from registration where batch like '$batch' and sec like '$sec' and dept like '$dep'";
            $data=$con->query($sql);
            $class=strval(intval($batch)-2000).'-cse-'.$sec;
            $sql1="SELECT * from `".$class."` WHERE `date` like '$date' and `code` like '$code' and `period` like '$period'";
            $data1=$con->query($sql1);
            $row=$data1->fetch_assoc();
            while($r=mysqli_fetch_array($data))
            {  
                $r=$r['regno'];
                $mark='';
                $cls='';
                $check='';
                if($row[$r]=='P')
                {
                    $mark='<i class="large green checkmark icon"></i>';
                    $cls='positive';
                    $check='checked';
                }    
                else
                {    
                    $mark='<i class="large red times icon"></i>';
                    $cls='negative';
                }
                echo '<tr>
                <td><div class="ui toggle checkbox">
                <input type="checkbox" name="'.$r.'" '.$check.'>
                <label></label>
                </div></td>
                <td id="'.$r.'" class="'.$cls.'">
                    '.$r.'
                </td>
                <td id="'.$r.'1'.'" class="'.$cls.'">'.$mark.'</td>
                
            </tr>';
            }
            ?>
                        </tbody>
                    </table>

                </div>
                <button class="ui positive button" name="finalize" value="done" style="float:right;">Finalize</button>
                <button class="ui negative button" name="finalize" value="goback" style="float:left;">Go Back</button>
            </form>
        </div>
        <script>
        $(document).ready(function() {
            $('input[type="checkbox"]').on('change', function() {
                var temp = $(this).attr("name");
                var ele = document.getElementById(temp);
                $(ele).toggleClass('positive', $(this).is(':checked'));

                $(ele).toggleClass('negative', $(this).not(':checked'));

                if ($(this).is(':checked')) {
                    var temp = $(this).attr("name") + 1;
                    var ele = document.getElementById(temp);
                    $(ele).children().attr("class", 'large green checkmark icon');
                } else {
                    var temp = $(this).attr("name") + 1;
                    var ele = document.getElementById(temp);
                    $(ele).children().attr("class", 'large red times icon');
                }
            });
        });
        </script>
</body>

</html>