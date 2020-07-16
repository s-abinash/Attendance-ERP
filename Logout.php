<?php
    session_start();
    include_once('./assets/notiflix.php');
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
    <?php require_once('./assets/notiflix.php');?>
    <script>
    $(document).ready(function() {
        $('.ui.card').transition('drop');
        $('.ui.card').transition('drop');
    });
    </script>
</head>

<body>
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
                            You have logged out out successfuly.<br> Have a Nice Day!.<br>
                        </div>
                    </div>
                    <div class="extra content">
                        <div class="ui bottom attached black button" onclick="window.open('./login.php', '_self');">
                            <i class="sign language icon"></i>
                            Thank You!
                        </div>
                    </div>
                </div>
            </div>
    </center>
    <style>
    .ui.container {
        /* margin-top: 60px; */
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