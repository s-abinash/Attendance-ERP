<?php
session_start();
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <script>
    $(document).ready(function() {
        $(".card-2").hide();
    });
    </script>
    <?php include_once('./assets/notiflix.php'); 

    if(isset($_SESSION['upload']))
    {
        if($_SESSION['upload']==true)
        {   
            echo '<script>
            $(document).ready(function(){
                $(".card-1").hide();
            });
            $(document).ready(function(){
                $(".card-2").show();
            });
            </script>';
        }
    }
    
    
    
    ?>

</head>

<?php
include_once('./navbar.php');
$course="18CSE51-Theory of Computation";
$date="06/07/2020";
$class="18CSE-A";
$batch=2018;
$sec='A';
$dep='CSE';
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
                $arr = array();
                if ($xlsx = SimpleXLSX::parse($targetfolder)) {
                    foreach ($xlsx->rows(6) as $r) {
                        $s = implode($r);
                        $str = substr(trim($s), -8);
                        if((intval(substr($str,0,2))!=0)&&(intval(substr($str,-2))!=0))
                        {
                            echo '<script>console.log("'.$str.'"</script>';
                            array_push($arr,$str);
                        }
                        //echo $str . '<br/>';
                    }
                    $_SESSION['upload']=true;
                    $_SESSION['array']=$arr;
                } else {
                    echo SimpleXLSX::parseError();
                }
                echo "<script>Notiflix.Report.Success('Proof Submitted Successfuly','The staff will verify and update the status. Wait Patiently','Okay',function(){});</script>";
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
                    <input type="text" value="<?php echo $course; ?>" readonly />
                </div>
                <div class="two fields">
                    <div class="field">
                        <label>Class</label>
                        <input type="text" value="<?php echo $class; ?>" readonly />
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
                            <p>Download Sample Excel here, <i class="blue download icon"></i></p>
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
    <div class="card-2">
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
                        $arr=$_SESSION['array'];
                        $attend=array();
                        $sql="SELECT regno from registration where batch like '$batch' and sec like '$sec' and dept like '$dep'";
                        $data=$con->query($sql);
                        while($r=mysqli_fetch_array($data))
                        {  
                            $r=$r['regno'];
                            $mark='';
                            $class='';
                            if(in_array($r,$arr))
                            {
                                $attend[$r]='P';
                                $mark='<i class="large green checkmark icon"></i>';
                                $class='positive';
                            }    
                            else
                            {    
                                $attend[$r]='A';
                                $mark='<i class="large red times icon"></i>';
                                $class='negative';
                            }
                            echo '<tr>
                            <td class="'.$class.'">
                                '.$r.'
                            </td>
                            <td class="'.$class.'">'.$mark.'</td>
                        </tr>';
                        }
                    ?>
                    </tbody>
                </table>
                <form action="<?php echo $_SERVER['PHP_SELF'];?>" name="finalize" method="post">
                    <button type="submit" name="finalize" style="float: right;"
                        class="ui big black button">Finalize</button>
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