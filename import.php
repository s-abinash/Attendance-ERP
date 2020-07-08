<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>

    <?php include_once('./assets/notiflix.php'); ?>
    <?php

    if(isset($_SESSION['upload']))
    {
        if($_SESSION['upload']==true)
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
    }
    ?>

</head>

<?php
include_once('./navbar.php');
?>
<?php
$date='';
$course="";
$code="";
$date="";
$class="";
$batch=0;
$sec='';
$dep='';
$hrs='';
if(isset($_POST['homy']))
{
    $date=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['dates'])));
    $code=$_POST['code'];
    $class=strtolower($_POST['tab']);
    $table=$_POST['tab'];

   
    $hrs=$_POST['hrs'];
    $arr=explode('-',$table,3);
    $batch=intval('20'.$arr[0]);
    $dep=$arr[1];
    $sec=strtoupper($arr[2]);
    $sql="SELECT `name` from `course_list` WHERE `code` like '$code'";
    //echo '<script>alert("'.$sql.'");</script>';
    $row=($con->query($sql))->fetch_assoc();
    $course=$row['name'];
    $_SESSION['course']=$course;
    $_SESSION['code']=$code;
    $_SESSION['date']=$date;
    $_SESSION['class']=$class;
    $_SESSION['batch']=$batch;
    $_SESSION['sec']=$sec;
    $_SESSION['dep']=$dep;
    $_SESSION['hrs']=$hrs;
}
else
{
    $course=$_SESSION['course'];
    $code=$_SESSION['code'];
    $date=$_SESSION['date'];
    $class=$_SESSION['class'];
    $batch=$_SESSION['batch'];
    $sec=$_SESSION['sec'];
    $dep=$_SESSION['dep'];
    $hrs=$_SESSION['hrs'];
}

?>

<body>

    <?php
if(isset($_POST["upload"]))
{
    if(isset($_FILES['excel']))
    {
        $file_type=$_FILES['excel']['type'];
        echo '<script>console.log("'.$file_type.'");</script>';
        $file_size= $_FILES['excel']['size'];
        if ($file_type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $file_size < 1010000 )     //2010000bytes = 2mb
        {
            $filename='att'.strval(mt_rand(100000,1000000)).'.xlsx';
            $targetfolder ='./files/'.$filename;
            if(move_uploaded_file($_FILES['excel']['tmp_name'], $targetfolder))
            {
                
                include_once('./assets/simplexlsx-master/src/SimpleXLSX.php');
                $arr1 = array();
                $arr2 = array();
                $arr3 = array();
                if ($xlsx = SimpleXLSX::parse($targetfolder)) {

                    // echo '<h1>Sheet1</h1>';
                    foreach ($xlsx->rows(0) as $r) {
                        $s = implode($r);
                        $str = substr(trim($s), -8);
                        if((intval(substr($str,0,2))!=0)&&(intval(substr($str,-2))!=0))
                        {
                            array_push($arr1,$str);
                           // echo $str.'</>';
                        }
                    }
                    // echo '<h1>Sheet2</h1>';
                    foreach ($xlsx->rows(1) as $r) {
                        $s = implode($r);
                        $str = substr(trim($s), -8);
                        if((intval(substr($str,0,2))!=0)&&(intval(substr($str,-2))!=0))
                        {          
                            array_push($arr2,$str);
                           // echo $str.'</br>';
                        }
                    }
                    // echo '<h1>Sheet3</h1>';
                    foreach ($xlsx->rows(2) as $r) {
                        $s = implode($r);
                        $str = substr(trim($s), -8);
                        if((intval(substr($str,0,2))!=0)&&(intval(substr($str,-2))!=0))
                        {
                            array_push($arr3,$str);
                           // echo $str.'</br>';
                        }
                    }

                    $_SESSION['upload']=true;
                    $_SESSION['array1']=$arr1;
                    $_SESSION['array2']=$arr2;
                    $_SESSION['array3']=$arr3;
                   // echo $_SESSION['array2'];
                } else {
                    echo SimpleXLSX::parseError();
                }
                unlink($targetfolder);
                echo "<script>Notiflix.Report.Success('File Submitted Successfuly','Proceed to check the Attendance','Okay',function(){window.location.replace('import.php');});</script>";
            }
            else
            {
                echo "<script> Notiflix.Report.Failure( 'Submisson Error', 'Some error occured. <br> Please try again.', 'Okay' );</script>";
            }
        }
        else
        {
            if ($file_type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
            {
                echo "<script> Notiflix.Report.Failure( 'Submisson Error', 'Only Excel sheets can be uploaded. <br> Please Convert and Submit.', 'Okay' );</script>";
                
            }
            if($file_size > 1010000)
            {
                echo "<script> Notiflix.Report.Failue( 'Submisson Error', 'File size should be 1 MB max. <br> Please Compress and Submit.', 'Okay' );</script>";
            }
        }

    }
}

?>
    <?php 
if(isset($_POST['finalize']))
{
    if($_POST['finalize']=="done")
    {
        
        foreach($hrs as $h)
        {
            $asst=$_SESSION['assoc'];
            $into='(`date`,`code`,`period`,';
            $vals='("'.$date.'","'.$code.'","'.$h.'",';
            foreach($asst as $roll=>$at)
            {
                $into.='`'.$roll.'`,';
                $vals.='"'.$at.'",';
            }
            $into=substr($into,0,-1).')';
            $vals=substr($vals,0,-1).');';
            $sql="INSERT INTO `".$class."` ".$into." VALUES ".$vals;
            
            $con->query($sql);
        }
        
        unset($_SESSION['array1']);
        unset($_SESSION['array2']);
        unset($_SESSION['array3']);
        unset($_SESSION['assoc']);
        unset($_SESSION['upload']);
        echo "<script>Notiflix.Report.Success('Success','Attendance Marked Successfully','Okay',function(){window.location.replace('home.php');});</script>";
        exit();
    }
    else
    {
            unset($_SESSION['array1']);
            unset($_SESSION['array2']);
            unset($_SESSION['array3']);
            unset($_SESSION['assoc']);
            unset($_SESSION['upload']);
            echo "<script>window.location.replace('./home.php');</script>";
          
    }
        
}
?>


    <style>
    body {
        background: url("./images/bgpic.jpg");
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

    <!-- File Upload Card  -->

    <div class="card-1">
        <div class="ui raised padded container segment" id="card" style="margin:auto;width:60%;">
            <center>
                <h1 class="header">
                    Attendance Entry
                </h1>
            </center>
            <form class="ui form" name="upload" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post"
                enctype="multipart/form-data">
                <div class="field">
                    <label>Course</label>
                    <input type="text" value="<?php echo $code.' - '.$course; ?>" readonly />
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Class</label>
                        <input type="text" value="<?php echo strtoupper($class); ?>" readonly />
                    </div>
                    <div class="field">
                        <label>Date</label>
                        <input type="text" value="<?php echo $date; ?>" readonly />
                    </div>
                </div>
                <div class="two field">
                    <div class="field">
                        <label>Sample</label>
                        <div class="ui message">
                            <p>Download Sample Excel here, <a href="./files/CSEA.xlsx" download><i
                                        class="blue download icon"></i></a></p>
                        </div>
                    </div>
                    <div class="field">
                        <label>Upload</label>
                        <div class="ui action input">
                            <input type="text" placeholder="Upload xlsx" readonly>
                            <input type="file" name="excel">
                            <div class="ui icon button">
                                <i class="attach icon"></i>
                                Upload
                            </div>
                        </div>
                    </div>

                </div>
                <div class="field">
                    <center> <button type="submit" name="upload" class="ui positive button">Submit</button></center>
                </div>

            </form>
        </div>
    </div>


    <!-- Attendance Confirm Card -->
    <div class="card-2" style="display:none;">
        <div class="ui raised padded container segment" id="card" style="height:80%;overflow:auto;width:60%;">
            <center>
                <h1 class="header">
                    Attendance Entry
                </h1>
            </center>
            <div class="content">
                <table class="ui compact table">
                    <thead>
                        <tr>
                            <th colspan="2">
                                Attendance Report
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $arr1=$_SESSION['array1'];
                        $arr2=$_SESSION['array2'];
                        $arr3=$_SESSION['array3'];
                        $attend=array();
                        $sql="SELECT regno from registration where batch like '$batch' and sec like '$sec' and dept like '$dep'"; 
                      
                        $data=$con->query($sql);
                        // echo "<script>alert('".$sql."')</script>";
                        while($r=mysqli_fetch_array($data))
                        {  
                            $r=$r['regno'];
                            $mark='';
                            $cls='';
                            if((in_array($r,$arr1)&&in_array($r,$arr2))||(in_array($r,$arr2)&&in_array($r,$arr3))||(in_array($r,$arr1)&&in_array($r,$arr3)))
                            {
                                $attend[$r]='P';
                                $mark='<i class="large green checkmark icon"></i>';
                                $cls='positive';
                            }    
                            else
                            {    
                                $attend[$r]='A';
                                $mark='<i class="large red times icon"></i>';
                                $cls='negative';
                            }
                            echo '<tr>
                            <td class="'.$cls.'">
                                '.$r.'
                            </td>
                            <td class="'.$cls.'">'.$mark.'</td>
                        </tr>';
                        }
                        $_SESSION['assoc']=$attend;
                    ?>
                    </tbody>
                </table>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" name="finalize" method="post">
                    <button type="submit" name="finalize" value="goback" style="float: left;"
                        class="ui large black button">Go
                        Back</button>
                    <button type="submit" name="finalize" value="done" style="float: right;"
                        class="ui large green button">Finalize</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    $("input:text").click(function() {
        $(this).parent().find("input:file").click();
    });

    $('input:file', '.ui.action.input')
        .on('change', function(e) {
            var name = e.target.files[0].name;
            $('input:text', $(e.target).parent()).val(name);
        });
    </script>
    <style>
    .ui.action.input input[type="file"] {
        display: none;
    }
    </style>
</body>

</html>