<?php
session_start();
if(isset($_SESSION['id']))
{
    header('Location: ./home.php');
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" type="image/png" href="./images/KEC.png">
    <link rel="stylesheet" href="./assets/Fomantic/dist/semantic.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />
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
        <form id="login">
            <div class="inputBox">
                <input type="text" name="userid" id="userid" required>
                <label>User Id</label>
            </div>
            <div class="inputBox">
                <input type="password" name="pass" required>
                <label>Password</label>
            </div>
            <div style="float:left;color:pink;">
                <a href="mailto:studentplus@kongu.edu?subject=Attendance Reg.," target="_blank">Contact Admin</a>
            </div><br /><br />
            <center>
                <button type="submit" id="sub" class="ui positive button">Sign in</button>
            </center>
        </form>
    </div>
    <div class="footer">
        <p style="vertical-align: middle;padding: 10px;"> Website developed by
            <span style="color:violet;" id="abinash">Abinash S</span> and <span style="color:violet;" id="ajay">Ajay R
            </span></p>
    </div>

    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <script>
    $(document).ready(function() {
        $("#abinash").on("click", function() {
            window.location.href = "mailto:s.abinash@outlook.com/subject=Attendance Reg.,";
        });
        $("#ajay").on("click", function() {
            window.location.href = "mailto:ajayofficial@zohomail.in/subject=Attendance Reg.,";
        });
        $("#login").on("submit", function() {
            $("#sub").addClass("loading");
            var frm = $("#login").serialize();
            frm += "&usr=verified";

            $.ajax({
                url: "./AJAX/handler.php",
                data: frm,
                type: "POST",
                success: function(res) {

                    $("#sub").removeClass("loading");
                    if (res == "Success") {
                        Notiflix.Notify.Success("Logged in Successfully");
                        window.location.replace("home.php");
                    } else {
                        Notiflix.Notify.Failure("Credential Mismatch");
                        $("#login")[0].reset();
                    }
                }
            });

            return false;

        });
    });
    </script>

</body>

</html>