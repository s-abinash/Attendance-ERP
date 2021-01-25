<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
$sid=$_SESSION["id"];
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
        $("#filenametext").on("click",function() {
        console.log("clicking");
        $(this).parent().find("input:file").click();
        });

        $("#filebutton").on("click",function() {
            console.log("clicking");
            $(this).parent().find("input:file").click();
        });

        $('.slider.checkbox').checkbox({
            onChecked: function() {
                $('#file').attr('disabled', 'disabled');
            },
            onUnchecked: function() {
                $('#file').removeAttr('disabled');
            }
        });

        $('input:file', '.ui.action.input')
            .on('change', function(e) {
                var name = e.target.files[0].name;
                $('input:text', $(e.target).parent()).val(name);
            });
    });
    </script>
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
$hrs_type='';
if(isset($_POST['homy']))
{
    $date=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['dates'])));
    $code=$_POST['code'];
    $coded=$code;
    $class=$_POST['code'];
    $table=$_POST['tab'];
    $hrs=$_POST['hrs'];
    $arr=explode('-',$table,3);
    $batch=intval('20'.$arr[0]);
    $dep=$arr[1];
    $sec=strtoupper($arr[2]);
    $hrs_type=array();
    foreach ($hrs as $i) {
        $hrs_type[$i]=$_POST[$i];
    }
    $sid=$_SESSION["id"];
    $sql="SELECT `name` from `course_list` WHERE `code` like '$code'";
    //echo '<script>alert("'.$sql.'");</script>';
    $row=($con->query($sql))->fetch_assoc();
    $course=$row['name'];
    $_SESSION['course']=$course;
    $_SESSION['code']=$code;
    $_SESSION['date']=$date;
    $_SESSION['class']=$class;
    $_SESSION['t']=$table;
    $_SESSION['batch']=$batch;
    $_SESSION['sec']=$sec;
    $_SESSION['dep']=$dep;
    $_SESSION['hrs']=$hrs;
    $_SESSION['hrs_type']=$hrs_type;
}
else
{
    $course=$_SESSION['course'];
    $code=$_SESSION['code'];
    $coded=$code;
    $date=$_SESSION['date'];
    $class=$_SESSION['class'];
    $batch=$_SESSION['batch'];
    $table=$_SESSION['t'];
    $sec=$_SESSION['sec'];
    $dep=$_SESSION['dep'];
    $hrs=$_SESSION['hrs'];
    $hrs_type=$_SESSION['hrs_type'];
    $sid=$_SESSION["id"];
}

?>

<body>
    <style>
    body {
        background: url("./images/bgpic.jpg");
    }
    </style>


    <?php
if(isset($_POST["upload"]))
{
    if(isset($_FILES['excel']) || isset($_POST['nofile']))
    {
        $a=false;
        $b=false;
        if(isset($_FILES['excel']))
        {
            $file_type=$_FILES['excel']['type'];
            $file_size= $_FILES['excel']['size'];
            if ($file_type=="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" && $file_size < 1010000 )
            {
                $a=true;
                $b=true;
                $filename='att'.strval(mt_rand(100000,1000000)).'.xlsx';
                $targetfolder ='./files/'.$filename;
                $fl=move_uploaded_file($_FILES['excel']['tmp_name'], $targetfolder);
            }

        }
        else if(isset($_POST["nofile"]))
        {
            $source='./files/Manual Attd.xlsx';
            $filename='att'.strval(mt_rand(100000,1000000)).'.xlsx';
            $targetfolder ='./files/'.$filename;
            $fl=copy($source, $targetfolder);
            $a=$b=true;
        }
        else
        {
            echo "<script> Notiflix.Report.Failure( 'Submisson Failure', 'Both Upload or Manual Not Given', 'Okay' );</script>";
        }
        
        if($a==true && $b==true)
        {
            
            if($fl==true)
            {
                
                include_once('./assets/simplexlsx-master/src/SimpleXLSX.php');
                $arr1 = array();
                // $arr2 = array();
                // $arr3 = array();
                
                if ($xlsx = SimpleXLSX::parse($targetfolder)) {
                    //var_dump($xlsx->rows(3));
                    try{
                        if(empty($xlsx->rows(0)))// || empty($xlsx->rows(1)) || empty($xlsx->rows(2)))
                        {    
                            throw new Exception();
                        }
                    }
                    catch(Exception $e) {
                        unlink($targetfolder);
                        echo "<script> Notiflix.Report.Failure( 'Format Error', 'Some sheets has not been filled', 'Okay',function(){window.location.replace('home.php');} );</script>";
                        //echo "<script>alert('File is not in desired format');</script>";
                        //echo "<script>window.location.replace('import.php');</script>";
                        exit();
                    }
                    try{
                        if(($xlsx->rows(0)==null) )//|| ($xlsx->rows(1)==null) || ($xlsx->rows(2)==null))
                        {    
                            throw new Exception();
                        }
                    }
                    catch(Exception $e) {
                        unlink($targetfolder);
                        echo "<script> Notiflix.Report.Failure('Format Error','Sheets should be present.', 'Okay',function(){window.location.replace('home.php');} );</script>";
                        //echo "<script>alert('File is not in desired format');</script>";
                        //echo "<script>window.location.replace('import.php');</script>";
                        exit();
                    }
                    // echo '<h1>Sheet1</h1>';
                    foreach ($xlsx->rows(0) as $r) {
                        $s = $r[0];
                        $str = strtoupper(substr(trim($s), -8));
                        $score=$r[1];
                        if((intval(substr($str,0,2))!=0)&&(intval(substr($str,-3))!=0))
                        {
                            $arr1[$str]=$score;
                           // echo $str.'</>';
                        }
                    }
                    // echo '<h1>Sheet2</h1>';
                    // foreach ($xlsx->rows(1) as $r) {
                    //     $s = $r[0];
                    //     $str = strtoupper(substr(trim($s), -8));
                    //     if((intval(substr($str,0,2))!=0)&&(intval(substr($str,-3))!=0))
                    //     {          
                    //         array_push($arr2,$str);
                    //        // echo $str.'</br>';
                    //     }
                    // }
                    // // echo '<h1>Sheet3</h1>';
                    // foreach ($xlsx->rows(2) as $r) {
                    //     $s = $r[0];
                    //     $str = strtoupper(substr(trim($s), -8));
                    //     if((intval(substr($str,0,2))!=0)&&(intval(substr($str,-3))!=0))
                    //     {
                    //         array_push($arr3,$str);
                    //        // echo $str.'</br>';
                    //     }
                    // }

                    $_SESSION['upload']=true;
                    $_SESSION['array1']=$arr1;
                    // $_SESSION['array2']=$arr2;
                    // $_SESSION['array3']=$arr3;
                   // echo $_SESSION['array2'];
                } else {
                    echo SimpleXLSX::parseError();
                }
                unlink($targetfolder);
                echo "<script>Notiflix.Report.Success('File Submitted Successfuly','Proceed to check the Attendance','Okay',function(){window.location.replace('importElec.php');});</script>";
            }
            else
            {
                unlink($targetfolder);
                echo "<script> Notiflix.Report.Failure( 'Submisson Error', 'Some error occured. <br> Please try again.', 'Okay' );</script>";
            }
        }
        else
        {
            if ($a==false)
            {
                unlink($targetfolder);
                echo "<script> Notiflix.Report.Failure( 'Submisson Error', 'Only Excel sheets can be uploaded. <br> Please Convert and Submit.', 'Okay' );</script>";
                
            }
            if($b==false)
            {
                unlink($targetfolder);
                echo "<script> Notiflix.Report.Failue( 'Submisson Error', 'File size should be 1 MB max. <br> Please Compress and Submit.', 'Okay' );</script>";
            }
        }

    }
    else
    {
        echo "<script> Notiflix.Report.Failue( 'Submisson Error', 'File as well as Manual Entry is NULL', 'Try Again' );</script>";
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
            $cnt=0;
            $P=0;
            $A=0;
            $ABS_ROLL=array();
            $asst=$_SESSION['assoc'];
            $into='(`date`,`code`,`period`,`type`,';
            $code=$_SESSION["id"];
            $vals='("'.$date.'","'.$code.'","'.$h.'","'.$hrs_type[$h].'",';
            $stat='';
            foreach($asst as $roll=>$at)
            {
              
                $cnt++;
                if(isset($_POST[$roll]))
                {
                    $stat='P';
                    $P++;
                }
                else
                {
                    $stat='A';
                    $A++;
                    array_push($ABS_ROLL,$roll);
                }
                $into.='`'.$roll.'`,';
                $vals.='"'.$stat.'",';
            }
            $into=substr($into,0,-1).')';
            $vals=substr($vals,0,-1).');';
            $sql="INSERT INTO `".$class."` ".$into." VALUES ".$vals;
           
    
    
            $con->query($sql);
        }
        unset($_SESSION['array1']);
        // unset($_SESSION['array2']);
        // unset($_SESSION['array3']);
        unset($_SESSION['assoc']);
        unset($_SESSION['upload']);
        if(1)
        {
        $stf=($con->query("SELECT * FROM `staff` WHERE `staffid` like '$sid'"))->fetch_assoc();
        $sem=(($batch=='2017')?'VIII':($batch=='2018'?'VI':($batch=='2019'?'IV':'I')));
        $sql="SELECT * FROM `course_list` WHERE code LIKE '$coded'";
        $res=($con->query($sql))->fetch_assoc();
        $name=$res["name"]; 
        $sdept=$res["dept"];
        $sec="";
        if($res["staffA"]==$sid)
        {
            $sec.=" A";
        }
        if($res["staffB"]==$sid)
        {
            $sec.=" B";
        }
        if($res["staffC"]==$sid)
        {
            $sec.=" C";
        }
        if($res["staffD"]==$sid)
        {
            $sec.=" D";
        }
        $sec=trim($sec);
        if($coded==="18CSE02"){
            $sec="A ".$sec;
        }

        echo '<div class="ui modal" id="modal">
        <div class="header">Meeting Recording Link Submission</div>
        <i class="close icon"></i>
        <div class="content">      
          
            <form class="ui form"  action="https://docs.google.com/forms/d/e/1FAIpQLSfXc-nE08ukuvLtuax1V4-Ecb8-Y5p1okU3ALZjlCLatePDPQ/viewform?" target="_blank" id="gf">
            <div class="field">
                 <input type="text" name="usp" value="pp_url" hidden>
                 <input type="text" name="entry.1760172262" value="'.$stf['name'].'" hidden>
                 <input type="text" name="entry.1519840088"  value="'.$stf["dept"].'" hidden>
                 <input type="text" name="entry.1907877152" value="'.($sem!='I'?'BE':'ME').'" hidden>
                 <input type="text" name="entry.309081512" value="'.($sem=='I'?'CSE':$dep).'" hidden>
                 <input type="text" name="entry.383571963" value="'.$sem.'" hidden>
                 <input type="text" name="entry.1504310176" value="'.$sec.'" hidden>
                 <input type="text" name="entry.15204943" value="'.$coded.'"  hidden>
                 <input type="text" name="entry.668277301" value="'.$name.'" hidden>
                 <input type="text" name="entry.1170232087" value="'.$date.'" hidden>
                 <input type="text" name="entry.1628375111" value="'.implode(' , ',$hrs).'" hidden>
                 <input type="text" name="entry.1683190265" value="'.$cnt.'" hidden>
                 <input type="text" name="entry.1675431824" value="'.$P.'" hidden>
                 <input type="text" name="entry.1186250163" value="'.$A.'" hidden>
                 <input type="text" name="entry.1654159561" value="'.(empty(implode(' , ',$ABS_ROLL))?'-':implode(' , ',$ABS_ROLL)).'" hidden>
                 <input type="text" name="entry.1877284434" value="'.intval(($P/$cnt)*100).'%" hidden>
                 <input type="text" name="entry.1289128628" value="'.implode(' , ',$hrs_type).'" hidden>  '.  
                 '<label>Meeting URL: </label>
                 <input type="url" id="url" name="entry.588869143" pattern="https?://drive.google.com.+" required />
            </div><br/>
            <button class="ui violet button" type="submit" onClick="googleForm()" style="float:right;">Submit</button>
            <br/>
            <br/>
            </form>
        </div>
        </div>';
        echo "<script>
        Notiflix.Report.Success('Success','Attendance Marked Successfully','Proceed to fill Google Form',function(){
            $('#modal').modal('show');
        });
        function googleForm()
        {
            $('#gf').submit();
            $('#modal').modal('hide');
            $('#url').val('');

            window.location.replace('./home.php');  
        }
        </script>";
        }
        else{
            echo "<script>
            Notiflix.Report.Success('Success','Attendance Marked Successfully','Okay',function(){
                window.location.replace('./home.php');  
            });
            </script>";
        }
        exit();
    }
    else
    {
            unset($_SESSION['array1']);
            // unset($_SESSION['array2']);
            // unset($_SESSION['array3']);
            unset($_SESSION['assoc']);
            unset($_SESSION['upload']);
            echo "<script>window.location.replace('./home.php');</script>";
          
    }
        
}
?>

    <!-- File Upload Card  -->

    <div class="card-1">
        <div class="ui raised padded container segment" id="card" style="margin:auto;width:80%;">
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
                        <input type="text" value="<?php echo strtoupper($table); ?>" readonly />
                    </div>
                    <div class="field">
                        <label>Date</label>
                        <input type="text" value="<?php echo $date; ?>" readonly />
                    </div>
                </div>
                <div class="two field">
                    <div class="field">
                        <label>Info</label>
                        <div class="ui teal message">
                            <p>XLSX format has been updated. <em data-emoji=":bell:" class="notify"></em></p>
                            <p>Excel Sheets from <a href="https://chrome.google.com/webstore/detail/google-meet-attendance-co/hjjeaaibilndjeabckakaknlcbblcmbc?hl=en" target="_blank">Google Meet Attendance Collector <i class="external link square alternate icon"></i></a> will only work. 
                            You can download the extension by clicking on the name</p>
                            <span style="float:left;"><a href="./files/template.xlsx" download>Download Sample<i
                                        class="blue download icon"></i></a></span>
                            <br />
                        </div>
                    </div>

                    <div class="field">
                        <label>Manual Entry</label></bale>
                        <div class="ui slider checkbox">
                            <input type="checkbox" name="nofile" id="nofile">
                            <label>Toggle for Manual Entry without XLSX</label>
                        </div>
                    </div>
                    <div class="ui horizontal divider">
                        Or
                    </div>
                    <div class="field">
                        <label>File Upload</label>
                        <div class="ui action input">
                            <input type="text" style="cursor:pointer;" placeholder="Upload xlsx" id="filenametext" readonly>
                            <input type="file" name="excel" id="file" style="display:none !important;">
                            <div class="ui icon button" id="filebutton">
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
        <div class="ui raised padded container segment" id="card" style="height:90%;overflow:auto;width:80%;">
            <center>
                <h1 class="header">
                    Attendance Entry
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
                        $arr1=$_SESSION['array1'];
                        // $arr2=$_SESSION['array2'];
                        // $arr3=$_SESSION['array3'];
                        $attend=array();
                        $sql="SELECT e.regno,r.name FROM elective e,registration r WHERE e.regno LIKE r.regno AND  E1 LIKE '$code' AND S1 LIKE '$sid'";
                       
                      
                        $data=$con->query($sql);
                        
                        while($r=mysqli_fetch_array($data))
                        {  
                            $name=$r['name'];
                            $r=$r['regno'];
                            $score=array();
                            $mark='';
                            $cls='';
                            $check='';
                            if((array_key_exists($r,$arr1)))//&&in_array($r,$arr2))||(in_array($r,$arr2)&&in_array($r,$arr3))||(in_array($r,$arr1)&&in_array($r,$arr3)))
                            {
                                $score=explode("/",$arr1[$r]);
                                if($score[0]>=floor($score[1]*0.7))
                                {
                                    $attend[$r]='P';
                                    $mark='<i class="large green checkmark icon"></i>';
                                    $cls='positive';
                                    $check='checked';
                                }
                                else{
                                    $attend[$r]='A';
                                    $mark='<i class="large red times icon"></i>';
                                    $cls='negative';
                                }    
                            }     
                            else
                            {    
                                $attend[$r]='A';
                                $mark='<i class="large red times icon"></i>';
                                $cls='negative';
                            }
                            echo '<tr>
                            <td><div class="ui toggle child checkbox">
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
                        $_SESSION['assoc']=$attend;
                    ?>
                        </tbody>
                    </table>

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
    // $("input:text").click(function() {
    //     $(this).parent().find("input:file").click();
    // });
    // $(".ui.icon.button").click(function() {
    //     $(this).parent().find("input:file").click();
    // });
    $(document).ready(function() {
        $('.slider.checkbox').checkbox({
            onChecked: function() {
                $('#file').attr('disabled', 'disabled');
            },
            onUnchecked: function() {
                $('#file').removeAttr('disabled');
            }
        });

        $('input:file', '.ui.action.input')
            .on('change', function(e) {
                var name = e.target.files[0].name;
                $('input:text', $(e.target).parent()).val(name);
            });
    });
    </script>
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
    <style>
    .ui.action.input input[type="file"] {
        display: none;
    }
    input[type="file"]{
        display: none !important;
    }
    </style>
</body>

</html>