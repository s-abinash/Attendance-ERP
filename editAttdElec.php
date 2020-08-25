<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
include_once('db.php');

if(isset($_SESSION["EditAttnd"]))
{
    $sid=$_SESSION['id'];
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
                            
    if(isset($_POST['finalize']))
    {
            if($_POST['finalize']=='done')
            {
     
                $date=date("Y-m-d",strtotime($_SESSION['date']));
                $code=$sid;
                $period=$_SESSION['period'];
                $class=$_SESSION['code'];
                $arr=array();
              
                $sql="SELECT regno from elective where ( E1 LIKE '$class' AND S1 LIKE '$sid') OR ( E2 LIKE '$class' AND S2 LIKE '$sid') OR ( E3 LIKE '$class' AND S3 LIKE '$sid')" ;
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

    <div class="card-2">
        <div class="ui raised padded container segment" id="card" style="height:80%;overflow:auto;width:60%;">
            <center>
                <h1 class="header">
                    Edit Attendance
                </h1>
                <div class="description">
                    Color Difference refers changes that are done now
                </div>
            </center>
            <form class="ui form" name="edit" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                <div class="content">
                    <table class="ui compact table">
                        <thead>
                            <tr>
                                <th colspan="3">

                                    <div class="ui positive check button">Check</div>
                                    <div class="ui negative uncheck button">Uncheck</div>
                                    <div class="ui toggle button">Invert</div>
                                </th>
                                <th colspan="1">
                                    Attendance Report (P/A)
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $date=date("Y-m-d",strtotime($_SESSION['date']));
                                $code=$sid;
                                $period=$_SESSION['period'];
                                
                                $class=$_SESSION['code'];
                                $sql="SELECT e.regno,r.name  from elective e ,registration r where (( E1 LIKE '$class' AND S1 LIKE '$sid') OR ( E2 LIKE '$class' AND S2 LIKE '$sid') OR ( E3 LIKE '$class' AND S3 LIKE '$sid') ) AND e.regno LIKE r.regno" ;
                                $data=$con->query($sql);
                                $sql1="SELECT * from `".$class."` WHERE `date` like '$date' and `code` like '$sid' and `period` like '$period'";
                                $data1=$con->query($sql1);
                                $row=$data1->fetch_assoc();
                        
                                while($r=mysqli_fetch_array($data))
                                {  
                                    $name=$r['name'];
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
                                    <td id="'.$r.'1'.'" class="'.$cls.'">
                                '.$name.'
                                    </td>
                                    <td id="'.$r.'2'.'" class="'.$cls.'">'.$mark.'</td>
                                    
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
                    var temp = $(this).attr("name") + 2;
                    var ele = document.getElementById(temp);
                    $(ele).children().attr("class", 'large green checkmark icon');
                    var temp = $(this).attr("name") + 1;
                    var ele = document.getElementById(temp);
                    $(ele).children().attr("class", 'positive');
                } else {
                    var temp = $(this).attr("name") + 2;
                    var ele = document.getElementById(temp);
                    $(ele).children().attr("class", 'large red times icon');
                    var temp = $(this).attr("name") + 1;
                    var ele = document.getElementById(temp);
                    $(ele).children().attr("class", 'negative');
                }
            });
            $('.toggle.checkbox').checkbox('attach events', '.toggle.button');
            $('.toggle.checkbox').checkbox('attach events', '.check.button', 'check');
            $('.toggle.checkbox').checkbox('attach events', '.uncheck.button', 'uncheck');
        });
        </script>
</body>

</html>