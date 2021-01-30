<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
    include_once("./db.php");
    include_once("./AJAX/header.php");
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alter</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <link rel="icon" type="image/png" href="./images/KEC.png">
    <?php include_once('./assets/notiflix.php'); ?>
  

</head>

<body id="root">

<?php
include_once('./navbar.php');
include_once('./assets/notiflix.php');
if (isset($_POST['period'])) {
    $s1 = $_SESSION["id"];
    $s2 = $_POST['s2'];
    $c1 = $_POST['c1'];
    $c2 = $_POST['c2'];
    $date = date("Y-m-d", strtotime(str_replace('/', '-', $_POST['date'])));
    $per = $_POST['period'];
    $sql = "INSERT INTO `alteration`(`s1`, `c1`, `date`, `period`, `s2`, `c2`)  values('$s1','$c1','$date','$per','$s2','$c2')";

    if ($con->query($sql)) {
        echo '<body><script>Notiflix.Notify.Success("Period Altered Successfully");</script></body>';
        //echo '<script>location.href="./home.php";</script>';
    } else {
        echo '<body><script>Notiflix.Notify.Failure("Please provide Valid Details");</script></body>';
    }
}
?>

<style>
    body {
        background: url("./images/bgpic.jpg");
    }
</style>
<div class="card-1">
    <div class="ui raised padded container segment" id="card" style="margin:auto;width:50%;">
        <center>
            <h1 class="header">
                Alter Period
            </h1>
        </center>

        <form class="ui form" name="mainform" id="ifrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <div class="field">
                <label>Course to Alter:</label>
                <select class="ui search dropdown" name="c1" id="alterfrom" required>
                    <option value="">Select Course</option>

                </select>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Date</label>
                    <div class="ui calendar" id="cal">
                        <div class="ui input left icon">
                            <i class="calendar icon"></i>
                            <input type="text" name="date" placeholder="Date" readonly required>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <label>Period</label>
                    <select class="ui dropdown" name="period" id="hr" required>
                        <option value="">Select Period</option>
                    </select>
                </div>
            </div>
            <br/>
            <div class="ui horizontal divider">
                To
            </div>
            <br/>
            <div class="two field">
                <div class="field">
                    <label>Staff to Alter:</label>
                    <select class="ui search dropdown" name="s2" id="alts2" required>
                        <option value="">Select Staff to Assign</option>

                    </select>
                </div>
                <div class="field">
                    <label>Course to Alter:</label>
                    <select class="ui search dropdown" name="c2" id="altc2" required>
                        <option value="">Select Course Associated</option>

                    </select>
                </div>
            </div>
            <button form="ifrm" style="float: right;" class="ui positive button" type="submit">Confirm Alter</button>
            <br/><br/>
        </form>
       
    </div>
</div>
<script>
    var d = "";
    var x, y, response, dt, altto;
    var elec =<?php echo json_encode($ele)?>;

    function getWeekDay(date) {
        var weekdays = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
        var day = date.getDay();
        return weekdays[day];
    }

    $(document).ready(function () {
        $('body')
            .toast({
                position: 'bottom right',
                title: 'Info',
                class: 'warning',
                displayTime: 'auto',
                closeIcon: true,
                showIcon: true,
                message: 'Period Once altered cannot be reverted again. In that regard, contact Admin.',
                showProgress: 'top'
            });
        $('#hr,#altc2').dropdown({
            clearable: true
        });
        $('#cal').calendar({
            type: 'date'
        });
        $('.message .close').on('click', function () {
            $(this).closest('.message').transition('fade');
        });

        $.ajax({
            url: "./AJAX/adModules.php",
            data: 's1drop=opt',
            type: 'POST',
            success: function (r) {
                r=r.trim();
                var res = JSON.parse(r);
                for (const i of res) {
                    $("#alterfrom").append("<option value='" + i.code + "'>" + i.name + "</option>");
                }
            }
        });
        $("#alterfrom").dropdown({
            clearable: true,
            onChange: function (value, text, $selectedItem) {
                if (value != "") {
                    $.ajax({
                        url: "./AJAX/adModules.php",
                        data: 's1c1=' + value,
                        type: 'POST',
                        success: function (r) {
                            // console.log(r);
                            // return false;
                            response = JSON.parse(r);
                            var arr = [];
                            var i;
                            var dates = response[0];
                            altto=response[1];
                            for (i of Object.keys(dates)) {
                                var r = i.split("-");
                                arr.push(new Date(r[0], r[1] - 1, r[2]));
                            }
                            $('#cal').calendar({
                                type: 'date',
                                enabledDates: arr,                            
                                formatter: {
                                    date: function (date, settings) {
                                        if (!date) return '';
                                        var day = date.getDate();
                                        var month = date.getMonth() + 1;
                                        day=(day<10)?'0'+day:day;
                                        month=(month<10)?'0'+month:month;
                                        var year = date.getFullYear();
                                        return day + '/' + month + '/' + year;
                                    }
                                },
                                onChange: function (date, settings) {
                                    var datecreated;
                                    $('#hr').dropdown('clear');
                                    $("#hr").html("<option value=''>Select Period</option>");
                                    if (!date) return '';

                                    x = (date.getMonth() + 1);
                                    y = date.getDate()
                                    if (x <= 9) {
                                        x = "0" + x;
                                    }
                                    if (y <= 9) {
                                        y = "0" + y;
                                    }
                                    var day = date.getFullYear() + '-' + x + '-' + y;
                                    for (let index = 0; index < dates[day].length; index++) {
                                        $("#hr").append("<option value='" + dates[day][index] + "'>" + dates[day][index] + "</option>");
                                    }
                                }
                            });
                            $('#hr').dropdown({
                                maxSelections: 3
                            });
                            $('#alts2').dropdown('clear');
                            $("#alts2").html("<option value=''>Select Staff to be Assigned</option>");
                            Object.keys(altto).forEach(key => {
                                $("#alts2").append("<option value='" + key + "'>" + altto[key][0][0] + "</option>");
                            });
                

                        }
                    });
                }

            }
        });
        $("#alts2").dropdown({
            clearable: true,
            onChange: function (value, text, $selectedItem) {
                $('#altc2').dropdown('clear');
                $("#altc2").html("<option value=''>Select Associated Course</option>");
                if(Array.isArray(altto[value]))
                {
                    for (i of altto[value]) {
                    $("#altc2").append("<option value='" + i[1] + "'>" + i[2] + "</option>");
                }
                }
                
            }
        });
    });
</script>
</body>
        </html>
            
    
