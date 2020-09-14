
<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$dir = dirname(__FILE__);
include_once($dir.'/db.php');
require $dir.'/PHPMailer/src/Exception.php';
require $dir.'/PHPMailer/src/PHPMailer.php';
require $dir.'/PHPMailer/src/SMTP.php';
include_once($dir.'/mailheader.php');

$dept='CSE';
$sql="SELECT `code` FROM `course_list` where `dept` LIKE '$dept' AND `status` LIKE 'active' AND `category` LIKE 'ELECTIVE'";
$res=$con->query($sql);
$ele=array();
while($row=mysqli_fetch_array($res))
{
    array_push($ele,$row['code']);
}
                    
$sql="SELECT * FROM `staff` WHERE `dept` LIKE '$dept' ORDER BY `staffid` ASC";
$data=$con->query($sql);
$p=0;
$scnt=0;
$ijk=0;
// $m=array('abinashs.18cse@kongu.edu','ajayr.18cse@kongu.edu','deeptir.18cse@kongu.edu','arulprasathv.18cse@kongu.edu');
while($row=mysqli_fetch_array($data))
{    
        $sid=$row['staffid'];
        $sname=$row['name'];
        $smail=$row['mail'];
        $sname=$row['name'];
        $mailto=$smail;
        
        $sql="SELECT * FROM `course_list` WHERE (`staffA`  LIKE '$sid' OR `staffB`  LIKE '$sid' OR `staffC`  LIKE '$sid' OR `staffD` LIKE '$sid' ) AND `status` LIKE 'active'";
        $data1=$con->query($sql);
        
        $n=mysqli_num_rows($data1);
        $bool=1;
        $bol=0;
        $cnt=0;
        while($row1=mysqli_fetch_array($data1))
        {
              
                $ssub=$row1['name'];
                $code=$row1["code"];
                if($row1["staffA"]==$sid)
                {
                    $sec="A";
                }
                else if($row1["staffB"]==$sid)
                {
                    $sec="B";
                }
                else if($row1["staffC"]==$sid)
                {
                    $sec="C";
                }
                else 
                {
                    $sec="D";
                }
                $batch=$row1["batch"]%2000;
                $cls=($batch==17?'IV':(($batch==18)?'III':'II')).' - '.$sec;
                $dep=$dept;
                if($row1['dept']=='MCSE')
                {
                    $dep='mcse';
                    $cls='ME';

                }
                 
                $tab=strtolower($batch.'-'.$dep.'-'.$sec);
            
                $sql="SELECT * FROM `ott` WHERE `class` LIKE '$tab'";
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
                $ott=$day_per;
            
            
            
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
                $tt=$day_per;
            
                $x=date("Y-m-d");
                $tdy=date_create($x);
                $date=date("2020-07-08");
                $diff=intval(date_diff($tdy,date_create($date))->format("%a"))+1;
                $dates=array();
                for($i=1;$i<$diff;$i++)
                {    
                    if($con->query("select * from holiday where date LIKE '$date'")->num_rows!=0)
                    {
                        $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                        continue;
                    }
                    if(date($date)<date("2020-08-03"))
                   {
                        $day_per=$ott;
                   }
                   else
                   {
                        $day_per=$tt;
                   }
                    
                    $alt=array();
                    $result=$con->query("SELECT * FROM `alteration` where `date` LIKE '$date' AND `s2` LIKE '$sid' AND `c2` LIKE '$code'");
                    if($result->num_rows!=0)
                    {
                        
                        while($row=$result->fetch_assoc())
                        {
                            $prds=$row["period"];
                            if(in_array($code,$ele))
                                $sql="SELECT * FROM `$code` where date LIKE '$date' AND code LIKE '$sid' AND `period` LIKE '$prds'"; 
                            else
                                $sql="SELECT * FROM `$tab` where date LIKE '$date' AND code LIKE '$code' AND `period` LIKE '$prds'"; 
                            $r=$con->query($sql);
                            if($r->num_rows==0)
                            {
                                array_push($alt,$prds);
                                $bol=1;
                                $p+=1;
                            }   
                        }
                    }
                    $s=date("l",strtotime($date));
                    $day_pd=array();
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
                                    {
                                        if(($con->query("SELECT * FROM `alteration` WHERE `s1` LIKE '$sid' AND `c1` LIKE '$code' AND`period` LIKE '$periods' AND `date` like '$date' "))->num_rows==0)
                                        {
                                            $p+=1;
                                            $bol=1;
                                            array_push($day_pd,$periods);
                                        }
                                    }                               
                                }
                                
                            }
                    }
                    if(!empty(array_merge($alt,$day_pd)))
                    {
                    
                        $dates+=array($date=>array_merge($alt,$day_pd));
                    }  
                    $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
                }

            $datecell='';
            foreach($dates as $i=>$pds)
            { 
                $datecell.=date_format(date_create($i),"d-m-Y").' &emsp;- &ensp;'.implode(",",$pds).'<br>';
            }
            if(!empty($dates))
            {
                $cnt=1;    
                $content= '<span style="color:blue">'.$datecell.'</span>';
                $mail = new PHPMailer(true);
            $mail->isSMTP();                            // Set mailer to use SMTP
            $mail->SMTPDebug = 0;
            $mail->Host = $Host;             // Specify main and backup SMTP servers
            $mail->SMTPAuth = $SMTPAuth;                     // Enable SMTP authentication
            $mail->Username = $Username;          // SMTP username
            $mail->Password = $Password; // SMTP password
            $mail->SMTPSecure = $SMTPSecure;                  // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $Port;                          // TCP port to connect to
            $mail->setFrom('studentplus@kongu.edu', 'KEC Student+');
            // Add a recipient
            $mail->isHTML(true);
            $bodyContent = '<!doctype html>
            <html>
                <head>
                <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <title>EmailTemplate-Responsive</title>
                        <style type="text/css">
                    html,  body {
                        margin: 0 !important;
                        padding: 0 !important;
                        height: 100% !important;
                        width: 100% !important;
                    }
                    * {
                        -ms-text-size-adjust: 100%;
                        -webkit-text-size-adjust: 100%;
                    }
                    .ExternalClass {
                        width: 100%;
                    }
                    /* What is does: Centers email on Android 4.4 */
                    div[style*="margin: 16px 0"] {
                        margin: 0 !important;
                    }
                    /* What it does: Stops Outlook from adding extra spacing to tables. */
                    table,  td {
                        mso-table-lspace: 0pt !important;
                        mso-table-rspace: 0pt !important;
                    }
                    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
                    table {
                        border-spacing: 0 !important;
                        border-collapse: collapse !important;
                        table-layout: fixed !important;
                        margin: 0 auto !important;
                    }
                    table table table {
                        table-layout: auto;
                    }
                    /* What it does: Uses a better rendering method when resizing images in IE. */
                    img {
                        -ms-interpolation-mode: bicubic;
                    }
                    /* What it does: Overrides styles added when Yahoo"s auto-senses a link. */
                    .yshortcuts a {
                        border-bottom: none !important;
                    }
                    /* What it does: Another work-around for iOS meddling in triggered links. */
                    a[x-apple-data-detectors] {
                        color: inherit !important;
                    }
                    </style>
                        <!-- Progressive Enhancements -->
                        <style type="text/css">
                            
                            /* What it does: Hover styles for buttons */
                            .button-td,
                            .button-a {
                                transition: all 100ms ease-in;
                            }
                            .button-td:hover,
                            .button-a:hover {
                                background: #555555 !important;
                                border-color: #555555 !important;
                            }
                            /* Media Queries */
                            @media screen and (max-width: 600px) {
                                .email-container {
                                    width: 100% !important;
                                }
                                /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
                                .fluid,
                                .fluid-centered {
                                    max-width: 100% !important;
                                    height: auto !important;
                                    margin-left: auto !important;
                                    margin-right: auto !important;
                                }
                                /* And center justify these ones. */
                                .fluid-centered {
                                    margin-left: auto !important;
                                    margin-right: auto !important;
                                }
                                /* What it does: Forces table cells into full-width rows. */
                                .stack-column,
                                .stack-column-center {
                                    display: block !important;
                                    width: 100% !important;
                                    max-width: 100% !important;
                                    direction: ltr !important;
                                }
                                /* And center justify these ones. */
                                .stack-column-center {
                                    text-align: center !important;
                                }       
                                /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
                                .center-on-narrow {
                                    text-align: center !important;
                                    display: block !important;
                                    margin-left: auto !important;
                                    margin-right: auto !important;
                                    float: none !important;
                                }
                                table.center-on-narrow {
                                    display: inline-block !important;
                                }               
                            }
                        </style>
                        </head>
                        <body>
                        <table bgcolor="#e0e0e0" cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" style="border-collapse:collapse;">
                        <tr>
                            <td><center style="width: 100%;">
                                <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;"> Attendance Pending Report from KEC Student+ </div>
                                <table align="center" width="600" class="email-container">
                                <tr>
                                    <td style="padding: 20px 0; text-align: center"><h1 style="color:black">KEC Student+</h1></td>
                                </tr>
                            </table> 
                                <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" class="email-container">
                                <tr> </tr>
                                <tr>
                                    <td style="padding: 40px; color:black;text-align: center; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;"> 
                                        <p style="color:black"><strong>Dear '.$sname.',</strong></p><br>Your Attendance pending report for this week is follows: <br>
                                        <br>
                                        <br><p style="color:red"><strong>Course: '.$ssub.'</p></strong><br>
                                        <p style="color:black"><strong>Dates: <br>'.$content.'</p></strong><br>
                                    <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto">
                                        <tr>
                                        <td style="border-radius: 3px; background: #00ff00; text-align: center;" class="button-td"><a href="https://attendance.kecstudent.tech
                                        " style="background: #00ff00; border: 15px solid #00ff00; padding: 0 10px;color: #ffffff; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a"> 
                                        <!--[if mso]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]-->Go to Website Now<!--[if mso]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]--> 
                                        </a></td>
                                    </tr>
                                    
                                    </table>  </strong><br>
                                    Any queries, write to <a href="mailto:student@kongu.ac.in" style="text-decoration:none;color:violet">student@kongu.ac.in</a>
                            <br><p>Please do not reply to this mail</p><br>
                            </td>
                                    <tr>
                                    </tr>       
                            </table> 
                                <table align="center" width="600" class="email-container">
                                <tr>
                                    <td style="padding: 40px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                                        <b><h3>Kongu Engineering College</b></h3><br>
                                    <span class="mobile-link--footer">All rights reserved @KEC. </span> <br>
                                    <br>
                                </td>
                                </tr>
                            </table></center></td>
                        </tr>
                        </table>
                    </body>
                    </html>';
//                         $mailto=$m[$ijk++];
//                         $mail->addAddress($mailto); 
//                         $mail->addReplyTo('studentplus@kongu.ac.in', 'KEC Student+');
//                         $mail->Subject = 'Attendance Pending';
//                         $mail->Body=$bodyContent;
//                         if(!$mail->send())
//                             echo $mailto.'Error';         
//                         else
//                             echo $mailto."Succesfull";
                            
                         echo $bodyContent;
            }
            
        }
    
}      


        ?>                   
        </body>
 </html>
