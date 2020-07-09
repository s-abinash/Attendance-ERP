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
    <div class="ui tablet computer only padded grid">
        <div class="ui borderless fluid huge inverted menu">
            <a class="active green item" href="#root">KEC Student+</a>
            <a class="item" id="home" href="home.php">Home</a>
            <a class="right item" style="margin-right:1%;font-weight:bold;color:cyan"><em><?php echo $_SESSION["name"]?><em></a>
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
                <a class="right item" style="margin-right:1%;font-weight:bold;color:cyan"><em><?php echo $_SESSION["name"]?><em></a>
                <a class="right item" id="logout" href="./Logout.php"><i class="share square outline icon"></i>Logout</a>
            </div>
        </div>
    </div>




    <script>
    $(document).ready(function() {
        $(".ui.toggle.button").click(function() {
            $(".mobile.only.grid .ui.vertical.menu").toggle(100);
        });
    });
    </script>