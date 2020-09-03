<?php
    session_start();
?>
<html>

<head>
    <meta charset="UTF-8">
    <title>Logout</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/Fomantic/dist/semantic.min.css" type="text/css" />
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <link rel="icon" type="image/png" href="./images/KEC.png">
    <link rel="stylesheet" type="text/css" href="./assets/animate.min.css" />
    <!-- No Script Part -->
    <noscript>
        <meta http-equiv="refresh" content="0; URL='./errorfile/noscript.html'" /></noscript>
    <!-- -------- -->
  
    <meta name="google-signin-client_id" content="652923881233-ra0pbk90pmmbsg10455ljb1ljpuccu0b.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151639011-3"></script>
    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

    <script>
    $(document).ready(function() {
        $('.ui.card').transition('drop');
        $('.ui.card').transition('drop');
    });
   
    // function signOut() {
    //     gapi.auth2.getAuthInstance().signOut().then(function() {
    //         console.log('user signed out')
    //     })
    //     window.location.replace('login.php');
    //     }
    // function onLoad() {
    //   gapi.load('auth2', function() {
    //     gapi.auth2.init();
    //   });
      
    // }
    // window.onLoadCallback = function(){
    //     gapi.load('auth2', initSigninV2);
    //     function initSigninV2() {
    //         gapi.auth2.init({
    //             client_id: '652923881233-ra0pbk90pmmbsg10455ljb1ljpuccu0b.apps.googleusercontent.com'
    //         }).then(function (authInstance) {
    //             gapi.auth2.getAuthInstance().signOut().then(function() {
    //             console.log('user signed out')
    //              })
    //         });
    //     }
    //     initSigninV2();
    // gapi.auth2.init({
    //     client_id: '652923881233-ra0pbk90pmmbsg10455ljb1ljpuccu0b.apps.googleusercontent.com'
    //     });
    // function signOut() {
    //     gapi.auth2.getAuthInstance().signOut().then(function() {
    //         console.log('user signed out')
    //     })
    //     }
    //     signOut();
    

    </script>
</head>

<body onclick="signOut()">
    <style>
    body {
        background-image: url('./images/bgpic.jpg');
    }
    </style>


    <?php
$status='';
if(isset($_SESSION['id']))
{

    session_destroy();
	session_unset();
    $status="Logout Successful";
}
else{

    session_destroy();
    session_unset();
    
    $status="No User Session Detected";
   
}
?>
    <center>
        <div class="animated zoomIn">
            <div class="ui container">
                <div class="ui card">
                    <div class="image" style="height:40%">
                        <img src="./images/tick-box.svg">
                    </div>
                    <div class="content">
                        <a class="header"><?php echo $status; ?></a>
                        <div class="description">
                            You have logged out successfuly.<br />
                            You will be redirected to the homepage. <br />
                            Have a Nice Day!<br />
                        </div>
                    </div>
                    <div class="extra content">
                        <div class="ui bottom attached green button"><!--onclick="signOut();">-->
                        <!-- onclick="window.open('login.php','_self')"> -->
                            <i class="sign language icon"></i>
                            Click here to continue
                        </div>
                    </div>
                </div>
            </div>
    </center>
    <style>
    .ui.container {
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }

    .ui.card {
        width: 400px;

    }

    .image {
        height: 100px;
    }

    img {
        width: auto;
        height: auto;
    }
    </style>

</body>

</html>