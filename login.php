<?php
session_start();
if(isset($_SESSION['id']))
{
    header('Location: ./home.php');
}
include_once("./db.php");

?>
<html lang="en">

<head>
    

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- No Script Part -->
    <noscript>
        <meta http-equiv="refresh" content="0; URL='./errorfile/noscript.html'" />
    </noscript>

    <!-- SEO -->
    <meta name="description" content="KEC Attendance ERP, is an initiative by the developers of KEC Student+ of Kongu Engineering College">
    <meta name="copyright" content="KEC Student+ is a trademark of students of KEC, Abinash S, Ajay R, Arul Prasath V">
    <meta name="keywords" content="KEC Attendance,Attendance KEC,kec, KOngu Attendance, Kongu Engineering College,Perundurai,KEC Student+,KEC CSE,Abinash,Ajay,Arulprasath,Kongu,KEC Attendance,Computer Science,Kongu Erode,KEC Erode,KEC Perndurai,
    KEC Thopupalayam,KVITT,KEC Student,studentplus,Computer Science KEC,kongu.edu,kongu.ac.in,kongu,keccse,KEC CSE A,studentplus@kongu.edu,kecstudent.xyz">
    <meta name="author" content="Abinash S, Ajay R">
    <meta name="robots" content="index,follow">
    <meta name="distribution" content="Global" />
    <meta name="publisher" content="Abinash, Kongu Engineering College" />
   
    <!--  -->

    <!-- PWA Part -->
    <link rel="manifest" href="./manifest.json">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="KEC">
    <meta name="apple-mobile-web-app-title" content="KEC">
    <meta name="theme-color" content="#21f330">
    <meta name="msapplication-navbutton-color" content="#21f330">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/login.php">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" sizes="144x144" href="./images/images/KEC.png">
    <link rel="apple-touch-icon" type="image/png" sizes="144x144" href="./images/images/KEC.png">
   
   

    <!--  -->
    <title>KEC Student+</title>
    <link rel="icon" type="image/png" href="./images/KEC.png">
    <link rel="stylesheet" href="./assets/Fomantic/dist/semantic.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
   
 
    <!--  -->
    <script> 
        if (navigator.onLine==false)  
            window.location.href="./errorfile/nointernet.html";
    </script> 
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;
        background: url("./images/bgpic.jpg");
        background-size: cover;
        content-visibility: auto;
    }

    .box {
        
        position: relative;
        top: 45%;
        
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        padding: 40px;
        padding-bottom: 20px;
        padding-top: 20px;
        background: rgba(0, 0, 0, .8);
        box-sizing: border-box;
        box-shadow: 0 15px 25px rgba(0, 0, 0, .5);
        border-radius: 10px;
    }

    .box h2 {
        margin: 0 0 30px;
        padding: 0;
        color: #fff;
        text-align: center;
    }

    .box .inputBox {
        position: relative;
    }

    .box .inputBox input {
        width: 100%;
        padding: 10px 0;
        font-size: 16px;
        color: #fff;
        letter-spacing: 1px;
        margin-bottom: 30px;
        border: none;
        border-bottom: 1px solid;
        outline: none;
        background: transparent;
    }

    .box .inputBox label {
        position: absolute;
        top: 0;
        left: 0;
        padding: 10px 0;
        font-size: 16px;
        color: #fff;
        pointer-events: none;
        transition: .5s;
    }

    .box .inputBox input:focus~label,
    .box .inputBox input:valid~label {
        top: -18px;
        left: 0;
        color: #03a9f4;
        font-size: 12px;
    }

    .box input[type="submit"] {
        background: transparent;
        border: none;
        outline: none;
        color: #fff;
        background: #03a9f4;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
    }

    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 8%;
        background-color: black;
        color: white;
        text-align: center;
    }

    </style>
</head>

<body>
    <div class="preloader">
        <div class="ui active dimmer" style="position: fixed;">
            <div class="ui massive active green elastic loader"></div>
        </div>
    </div>
    <div class="box">
        <h2 class="animate__animated animate__pulse ">
        <!-- <img src="./images/KEC.png" height="30px" width="30px" style="border-radius: 5px;position:relative;top:8px;"/>  -->
        Login</h2>
        <form id="login" autocomplete="off"  action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="inputBox">
                <input type="text" name="userid" id="userid" required>
                <label>User Id</label>
            </div>
            <div class="inputBox">
                <input type="password" name="pass" minlength="4" maxlength="20" id="pass" required>
                <label>Password</label>
            </div>
            <div style="float:left;color:pink;">
                <a href="mailto:studentplus@kongu.ac.in?subject=Attendance%20Project%20Reg.," target="_blank"><i
                        class="envelope outline icon"></i>studentplus@kongu.ac.in</a>
            </div>
            <div style="float:right;color:pink;">
                <a href="https://xn--r1a.website/s/kecattd" style="cursor:pointer;" target="_blank">
                <i class="telegram plane icon"></i></i>Telegram Help 
                </a>
            </div>
            <br /><br /><br/>
            <center class="animate__animated animate__pulse ">
                <button type="submit" id="sub" name="usr" val="verified" class="ui large positive button">Sign
                    in</button><br>
                    <!-- <div style="width: 100%; height: 20px; border-bottom: 1px solid black; text-align: center;color: #929292">
                    <span style="font-size: 10px; color: #929292; padding: 0 10px;">
                    OR 
                    </span>
                    </div> -->
                    <div class="ui horizontal divider" style="color: #929292;">OR</div>
                    <div data-tooltip="Select your kongu.edu mail" class="g-signin2" data-width="100" data-onsuccess="onSignIn"></div>
            </center>
        </form>
        <center><span style="color:#ffffb3; margin-top:10%;padding: 20px;font-size:12px">v4.1</span></center>
        <center><span style="color:bisque;font-size:11px">&copy; Kongu Engineering
                College</span></center>
    </div>
    <div class="footer">
        <p style="vertical-align: middle;  font-family: sans-serif; padding: 15px;"> Site development and support by
            <span style="color:violet;cursor: pointer;" class="animate__animated animate__pulse" id="abinash">Abinash S</span> and <span style="color:violet;cursor: pointer;" class="animate__animated animate__pulse" id="ajay">Ajay R
            </span>of <span style="color:brown;">III CSE - A</span>

        </p>
    </div>

    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    
    <script>
    $(document).ready(function() {
       
        $("#tele").on("click",function(){
            $('.ui.basic.modal').modal('show');
        });
        $("#abinash").on("click", function() {
            window.open("mailto:s.abinash@kongu.ac.in?subject=Attendance Reg.,", "_blank");
        });
        $("#ajay").on("click", function() {
            window.open("mailto:r.ajay@kongu.ac.in?subject=Attendance Reg.,", "_blank");
        });

        
    });
    $(window).on("load", function() {
        $('.preloader').hide();
    });
    function onSignIn(googleUser) {
        $('.preloader').show();
        var profile = googleUser.getBasicProfile();
        var image= profile.getImageUrl();
        var email = profile.getEmail(); 
        var id_token = googleUser.getAuthResponse().id_token;
        var d={'profile':profile,'image':image,'email':email,'id_token':id_token};
        $.ajax({
                url: "./entity/auth.php",
                data: d,
                type: "POST",
                success: function(res) {
                    console.log(res);
                    if(res=="success")
                    {
                        $('.preloader').hide();
                        location.replace('home.php');
                    }
                    else
                    {
                       
                        var auth2 = gapi.auth2.getAuthInstance();
                        auth2.signOut().then(function () {
                        console.log('User signed out.');
                        });
 
                        $('.preloader').hide();
                        $(document).ready(function(){
                        $('body')
                                .toast({
                                    position: 'bottom right',
                                    title: 'Account Not Found',
                                    displayTime: 5000,
                                    class: 'error',
                                    closeIcon: true,
                                    showIcon: true,
                                    message: 'Please select your kongu.edu Mail',
                                    showProgress: 'top'
                                });
                            });
                    }

                }


                
        });
    }
 

   // Global site tag (gtag.js) - Google Analytics -->
    </script>


</body>
<?php
if (isset($_POST["usr"]))
{   
    $id=$_POST["userid"];
    $pass=SHA1($_POST["pass"]);
    $count=0;
    if(strcmp(substr($id,0,4),"dev-")==0)
    {
        $id=substr($id,4);
        $sql="select * from `developer` where `password` LIKE '$pass'";
        $res=$con->query($sql);
        $count=$res->num_rows;
        if($count==1)
        {
            $sql="select * from `staff` where userid LIKE '$id'";
            $res=$con->query($sql);
            $count=$res->num_rows;
        }
    }
    else
    {
        $sql="select * from staff where userid LIKE '$id' AND pass LIKE '$pass'";
        $res=$con->query($sql);
        $count=$res->num_rows;
    }
   if($count==1)
   { 
      
      $row=$res->fetch_assoc();
      $_SESSION["id"]=$row['staffid'];
      $_SESSION['mail']=$row['mail'];
      $_SESSION["name"]=$row['name'];
      $_SESSION["dept"]=$row['dept'];
      $_SESSION['batch']=$row['batch'];
      $_SESSION['design']=$row['designation'];
      $_SESSION['sec']=$row['sec'];
      echo "<script>
      $(document).ready(function(){
      $('body')
            .toast({
                position: 'bottom right',
                title: 'Login Successful',
                class: 'success',
                displayTime: 3000,
                closeIcon: true,
                showIcon: true,
                message: 'You will be redirected',
                showProgress: 'top'
            });
        });
      </script>";
      echo '<script>location.href="./home.php";</script>';
   }
   else
   {
    echo "<script>
      $(document).ready(function(){
      $('body')
            .toast({
                position: 'bottom right',
                title: 'Account Not Found',
                displayTime: 5000,
                class: 'error',
                closeIcon: true,
                showIcon: true,
                message: 'Please select your edu mail',
                showProgress: 'top'
            });
        });
      </script>";
   }
}
?>


<!-- PWA -->

    <script type="module">

    import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate@0.2.0/dist/pwa-update.min.js';

    const el = document.createElement('pwa-update');
    document.body.appendChild(el);
    </script>
    <script src="manup.js"></script>

       <!-- Google Login -->
       <meta name="google-signin-client_id" content="652923881233-ra0pbk90pmmbsg10455ljb1ljpuccu0b.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151639011-3"></script>


   
</html>