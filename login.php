<?php
session_start();
if(isset($_SESSION['id']))
{
    header('Location: ./home.php');
}
include_once("./db.php");
include_once('./assets/notiflix.php');

?>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
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
   
    <script type="module">

            import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwaupdate@0.2.0/dist/pwa-update.min.js';

            const el = document.createElement('pwa-update');
            document.body.appendChild(el);
    </script>
    <script src="manup.js"></script>

    <!--  -->
    <title>KEC Student+</title>
    <link rel="icon" type="image/png" href="./images/KEC.png">
    <link rel="stylesheet" href="./assets/Fomantic/dist/semantic.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
    
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
    }

    .box {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
        padding: 40px;
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
    <?php include_once('./assets/notiflix.php'); ?>
    <div class="box">
        <h2 class="animate__animated animate__bounce "> Staff Login</h2>
        <form id="login" autocomplete="off"  action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="inputBox">
                <input type="text" name="userid" id="userid" required>
                <label>User Id</label>
            </div>
            <div class="inputBox">
                <input type="password" name="pass" minlength="4" maxlength="4" id="pass" required>
                <label>Password</label>
            </div>
            <div style="float:left;color:pink;">
                <a href="mailto:studentplus@kongu.edu?subject=Attendance Reg.," target="_blank">Admin Mail <i
                        class="envelope outline icon"></i></a>
            </div>
            <div style="float:right;color:pink;">
                <a href="http://t.me/kecattd" target="_blank">Telegram Help <i class="hands helping icon"></i>
                <br>(Recommended)</a>
            </div>
            <br /><br /><br/>
            <center>
                <button type="submit" id="sub" name="usr" val="verified" class="ui large positive disabled button">Sign
                    in</button>
            </center>
        </form>
        <center><span style="color:#ffffb3; margin-top:10%;padding: 20px;font-size:12px">v3.0</span></center>
        <center><span style="color:bisque;font-size:11px">&copy; Kongu Engineering
                College</span></center>
    </div>
    <div class="footer">
        <p style="vertical-align: middle;  font-family: sans-serif; padding: 15px;"> Website developed by
            <span style="color:violet;" id="abinash">Abinash S</span> and <span style="color:violet;" id="ajay">Ajay R
            </span>of III CSE - A

        </p>
    </div>

    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#abinash").on("click", function() {
            window.open("mailto:s.abinash@outlook.com?subject=Attendance Reg.,", "_blank");
        });
        $("#ajay").on("click", function() {
            window.open("mailto:ajayofficial@zohomail.in?subject=Attendance Reg.,", "_blank");
        });
        $("#pass,#userid").on("keyup",function(){
            if(($("#userid").val()!='')&&(($("#pass").val().length)===4))
            {
                $("#sub").removeClass("disabled");
            }
            if(($("#userid").val()=='')||(($("#pass").val().length)!==4))
            {
                $("#sub").addClass("disabled");
            }
        });
        
    });

    </script>

</body>
<?php
if (isset($_POST["usr"]))
{   
    $id=$_POST["userid"];
    $pass=SHA1($_POST["pass"]);
    $sql="select * from staff where userid LIKE '$id' AND pass LIKE '$pass'";
    $res=$con->query($sql);
    $count=$res->num_rows;
   if($count==1)
   {     
      $row=$res->fetch_assoc();
      $_SESSION["id"]=$row['staffid'];
      $_SESSION["name"]=$row['name'];
      $_SESSION["dept"]=$row['dept'];
      $_SESSION['batch']=$row['batch'];
      $_SESSION['design']=$row['designation'];
      $_SESSION['sec']=$row['sec'];
      echo '<body><script>Notiflix.Notify.Success("Logged in Successfully");</script></body>';
      echo '<script>location.href="./home.php";</script>';
   }
   else
   {
    echo '<body><script>Notiflix.Notify.Failure("Credential Mismatch");</script></body>';
   }
}
?>

</html>