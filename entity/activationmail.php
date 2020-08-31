<?php
session_start();
include_once('../assets/notiflix.php');

?>
<html>  <?php include_once('../assets/notiflix.php');?></html>
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
include_once('./entity/mailheader.php');
$rollno=$_SESSION['rollno'];
$mailto=$_SESSION['mail'];
$Name=$_SESSION['name'];
$key='AbinashArulAjayMNC';
$hash=sha1($rollno.$key);
$link='http://student.kongu.edu/entity/auth.php?regno='.$rollno.'&hash='.$hash;
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
$mail->addAddress($mailto);   // Add a recipient
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
                      <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;"> Regards from KEC Student+, Thank You for the Registration </div>
                    <table align="center" width="600" class="email-container">
                    <tr>
                        <td style="padding: 20px 0; text-align: center"><h1 style="color:black">KEC Student+</h1></td>
                      </tr>
                  </table> 
                    <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" class="email-container">
                    <tr> </tr>
                    <tr>
                        <td style="padding: 40px; color:black;text-align: center; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;"> 
                            <p style="color:black"><strong>Dear '.$Name.',</strong></p><br>Your have successfuly registered for KEC Student+. Thank You! <br>Your registration details are as follows: <br>
                            <b> <br> Registration Number: '.$rollno.'</b><br><br>
                            <br><p style="color:black"><strong>Please activate your account in order to start using it, through this link: 
                        <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin: auto">
                            <tr>
                            <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td"><a href="'.$link.'" style="background: #222222; border: 15px solid #222222; padding: 0 10px;color: #ffffff; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a"> 
                              <!--[if mso]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]-->Activate Now<!--[if mso]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]--> 
                              </a></td>
                          </tr>
                          </table>  </strong>
                  <br><p>If you are not redirected automatically, please copy and paste this link in the browser for activation.</p>              
                  <p><a href="'.$link.'" target="_blank">'.$link.'</a></p>
                  </td></tr><tr>
                        <td background="images/Image_600x230.png" bgcolor="#222222" valign="middle" style="text-align: center; background-position: center center !important; background-size: cover !important;"></td>
                      </tr><tr> </tr><tr> </tr> <tr> </tr><tr> </tr>       
                  </table> 
                    <table align="center" width="600" class="email-container">
                    <tr>
                        <td style="padding: 40px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                            <b><h3>Team A3</b></h3><br>
                        <span class="mobile-link--footer">All rights reserved @Team A3. </span> <br>
                        <br>
                      </td>
                      </tr>
                  </table></center></td>
              </tr>
            </table>
        </body>
        </html>';

        $mail->Subject = 'Welcome to KEC Student+';
        $mail->Body=$bodyContent;
        if(!$mail->send())
           echo "<script>Notiflix.Report.Failure( 'Read Below!', 'Error sending the Activation Link Sent to your mail. Please select Resend Activation Link in the Login Page.', 'Okay',function(){location.replace('./../index.php
            ');} );</script> ";
                
        else

            echo "<script>Notiflix.Report.Success( 'Read Below!', 'Activation Link Sent to your mail Successfully. Please Activate to continue.', 'Okay',function(){location.replace('./../index.php');}  );</script> ";
        
        ?>                   
        </body>
 </html>