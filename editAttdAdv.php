<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
include_once('db.php');

if(isset($_SESSION["EditAttnd"]))
{
    $batch=$_SESSION['batch'];
    $sec=$_SESSION['sec'];
    $dep=$_SESSION['dept'];   
}

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
    body 
    {
        background: url('./images/bgpic.jpg');
    }


    #card 
    {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    </style>
 
    <?php
                            
    if(isset($_POST['finalize']))
    {
            if($_POST['finalize']=='done')
            {
     
                $date=date("Y-m-d",strtotime($_SESSION['date']));
                $code=$_SESSION['code'];
                $period=$_SESSION['period'];
                $class=strval($batch).'-cse-'.strtolower($sec);
                
                $arr=array();
                $bat="20".$_SESSION["batch"];
                $sql="SELECT regno from registration where batch like '$bat' and sec like '$sec' and dept like '$dep'";
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
                // echo "<script>console.log('".$sql."')</script>";
                
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

    <div class="card-2" >
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
                                $date=date("Y-m-d",strtotime($_SESSION['date']));
                                $code=$_SESSION['code'];
                                $period=$_SESSION['period'];
                                $bat="20".$batch;
                                $sql="SELECT regno from registration where batch like '$bat' and sec like '$sec' and dept like '$dep'";
                                $data=$con->query($sql);
                                
                                $class=strval($batch).'-cse-'.$sec;
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
                <br>
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