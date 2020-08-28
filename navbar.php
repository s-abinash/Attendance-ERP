<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
    .ui.huge.header {
        font-size: 36px;
    }

    .ui.inverted.menu {
        border-radius: 0;
        flex-wrap: wrap;
        border: none;
        padding-left: 0;
        padding-right: 0;
    }

    .ui.mobile.only.grid .ui.menu .ui.vertical.menu {
        display: none;
    }

    .ui.inverted.menu .item {
        color: rgb(157, 157, 157);
        font-size: 16px;
    }

    .ui.inverted.menu .active.item {
        background-color: #080808;
    }

    .dimmed.dimmable>.ui.animating.dimmer,
    .dimmed.dimmable>.ui.visible.dimmer,
    .ui.active.dimmer {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .ui.modal,
    .ui.active.modal {
        position: fixed;
        margin: auto auto !important;
        top: 23%;
        left: 18%;
        right: 18%;
        transform-origin: center !important;
        transition: all ease .5s;
    }

    .modal {
        height: auto;
        top: auto;
        left: auto;
        bottom: auto;
        right: auto;

    }
    .notify {
    animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
    50% {
        opacity: 0;
    }
    }
    </style>
    <link rel="icon" type="image/png" href="./images/KEC.png">
    <link rel="stylesheet" href="./assets/Fomantic/dist/semantic.min.css" type="text/css" />


    <!-- No Script Part -->
    <noscript>
        <meta http-equiv="refresh" content="0; URL='./errorfile/noscript.html'" /></noscript>
    <!--  -->
  
    <?php include_once('./assets/notiflix.php'); ?>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
</head>

<body>
    <?php include_once('./db.php'); ?>
  
    <div class="preloader">
        <div class="ui active dimmer" style="position: fixed;">
            <div class="ui massive active green elastic loader"></div>
        </div>
    </div>
    <div class="ui tablet computer only padded grid">
        <div class="ui borderless fluid huge inverted menu">
            <a class="active green item" href="#root">KEC Student+</a>
            <a class="item" id="home" href="home.php">Home</a>
            <a class="item" id="alter" href="alter.php">Alter Period</a>
            <a class="item" id="alter" href="exportAdv.php">Advisor Export 
            <div class="ui yellow inverted label">New</div></a>
            <!-- <span style="font-size: 10px; color: grey; margin-top: 5px">&nbsp;New!</span></a> -->
            <a class="item" id="ann">Announcement
            <!-- <em data-emoji=":bell:" class="notify"></em> -->
            </a>
            <a class="item" id="togglepass" data-title="Change Password" data-content="Change your password using old password">Change Password
            <div class="ui yellow inverted label">New</div></a>
            <a class="right item"
                style="margin-right:1%;font-weight:bold;color:cyan"><em><?php echo $_SESSION["name"]?><em></a>
            <a class="right item" id="logout" href="./Logout.php"><i class="share square outline icon"></i>Logout</a>
        </div>
    </div>
    <div class="ui mobile only padded grid">
        <div class="ui borderless fluid huge inverted menu">
            <a class="header item" href="#root">KEC Student+</a>
            <div class="right menu">
                <div class="item">
                    <button class="ui icon toggle basic inverted button">
                        <i class="content icon"></i>
                    </button>
                </div>
            </div>
            <div class="ui vertical borderless fluid inverted menu">
                <a class="item" id="index" href="home.php">Home</a>
                <a class="item" id="alter" href="alter.php">Alter Period</a>
                <a class="item" id="alter" href="exportAdv.php">Advisor Export </a>
                <a class="item" id="ann">Announcement </a>
                <a class="item" style="font-size:16px;text-indent:20%;"><span id="togglepass" class="ui inverted grey text">Change Password</span></a>
                <a class="right item"
                    style="margin-right:1%;font-weight:bold;color:cyan"><em><?php echo $_SESSION["name"]?><em></a>
                <a class="right item" id="logout" href="./Logout.php"><i
                        class="share square outline icon"></i>Logout</a>
            </div>
        </div>
    </div>

    <!-- Password Change -->

    <div class="ui small modal" id="changepass">
    <i class="close icon"></i>
    <div class="header">Change Password</div>
    <div class="content">
      <form class="ui form segment error" id="passform">
        <div class="field">
          <label>Old Password:</label>
          <div class="ui action input">
          <input type="password" name="oldpass" id="oldpass" placeholder="Old Password" autocomplete="current-password">
          <span class="ui button" onclick="toggleeye('oldpass')"><i class="eye icon" id="oldpasseyeicon" "></i></span>
          </div>
        </div>
        <div class="field">
          <label>New Password:</label>
          <div class="ui action input">
          <input type="password" name="newpass" id="newpass" placeholder="New Password" autocomplete="new-password">
          <span class="ui button" onclick="toggleeye('newpass')"><i class="eye icon" id="newpasseyeicon" "></i></span>
          </div>
        </div>
        <div class="field">
          <label>Confirm New Password:</label>
          <div class="ui action input">
          <input type="password" id="cfmnewpass" placeholder="Confirm Password" autocomplete="new-password">
          <span class="ui button" onclick="toggleeye('cfmnewpass')"><i class="eye icon" id="cfmnewpasseyeicon" "></i></span>
          </div>
        </div>
        <div class="actions" style="text-align: right;">
          <button class="ui positive button" type="submit" name="changepass">Proceed</button>
          <div class="ui negative button" onClick="return true">Ignore</div><br />
          <div class="ui error message"></div>
        </div>
      </form>

    </div>

  </div>


    <?php include_once('announcement.php');?>

    <script>
    $(function() {
        $(".ui.toggle.button").click(function() {
            $(".mobile.only.grid .ui.vertical.menu").toggle(100);
        });
       

    });

    $(window).on("load", function() {
        $('.preloader').hide();
    });
    function toggleeye(lk) {
      var x = document.getElementById(lk);
      var y = lk+'eyeicon';
          if (x.type === "password") {
            x.type = "text";
            //$("y").attr("class", "ui blue double loading form segment error");
            document.getElementById(y).className = "eye slash icon";
          } else {
            x.type = "password";
            document.getElementById(y).className = "eye icon";
          }
      
    }
    </script>
    <style>
    /* Refers the whole setup */
    ::-webkit-scrollbar {
        width: 11px;
        border-radius: 13px;
    }

    /* Refers tracking path */
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 13px;
        opacity: 1.0;
        /* background-color: #F5F5F5; */
    }

    /* Refers Draggable Bar */
    ::-webkit-scrollbar-thumb {
        border-radius: 13px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);

        background-color: #555;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #ef8376;
    }
    </style>
    <script>
    function opentogglepass()
      {
        $('#changepass').modal({
          onApprove: function() {
            return false;
          }
        }).modal('show');
      }
    $(function(){
      
        $('#togglepass').on("click", function() {
          opentogglepass();
        });
        
      $('#passform').form({
        fields: {
          oldpass: {
            identifier: 'oldpass',
            rules: [{
                type: 'empty',
                prompt: 'Please Enter the Old Password'
              },
              {
                type: 'maxLength[16]',
                prompt: 'Please Enter Password upto 16 Characters'
              },
              {
                type: 'minLength[4]',
                prompt: 'Please Enter Password above 4 characters'
              }
            ]
          },
          newpass: {
            identifier: 'newpass',
            rules: [{
                type: 'empty',
                prompt: 'Please Enter the Old Password'
              },
              {
                type: 'maxLength[16]',
                prompt: 'Please Enter Password upto 16 Characters'
              },
              {
                type: 'minLength[4]',
                prompt: 'Please Enter Password above 4 characters'
              }
            ]
          },
          cnfmnewpass: {
            identifier: 'cnfmnewpass',
            rules: [{
                type: 'empty',
                prompt: 'Please Enter the Old Password'
              },
              {
                type: 'maxLength[16]',
                prompt: 'Please Enter Password upto 16 Characters'
              },
              {
                type: 'minLength[4]',
                prompt: 'Please Enter Password above 4 characters'
              },
              {
                type: 'match[newpass]',
                prompt: 'Password and Confirm Password should be same'
              },

            ]
          }

        },
        onSuccess: function(event, fields) {
          event.preventDefault();
          SubmitDetails();
        }

      });
    });

    function SubmitDetails() {
      data = $("#passform").serializeArray();
      $("#passform").attr("class", "ui blue double loading form segment error");
      data[3] = {
        name: "staffid",
        value: "<?php echo $_SESSION['id']; ?>",
      };
      //console.log(data);
      $.ajax({
        url: "AJAX/util_handler.php",
        type: "POST",
        data: data,
        success: function(d) {
          $("#passform").attr("class", "ui form segment error");
          $('#changepass').modal('hide');
          document.getElementById('passform').reset();
          $('body')
            .toast({
                position: 'bottom right',
                title: (d=='success')?'Successful':'Failed',
                class: d,
                displayTime: 3000,
                closeIcon: true,
                showIcon: true,
                message: (d=='success')?'Your Password Changed Successfully':'You entered incorrect password',
                showProgress: 'top'
            });
        }
      });

    }
  </script>
