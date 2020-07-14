<?php
    session_start();
    if(!isset($_SESSION["id"]))
    {
        header('Location: ./login.php');
    }
    include_once("./db.php");
    include_once("./navbar.php");
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

</head>

<body>
    <style>
    body {
        background-image: url("./images/bgpic.jpg");
    }
    </style>
    <div id="tabl">
        <div class="ui header" style="text-align:center;font-size:30px;margin-top:2%;color:#ADEFD1FF">Your Class
            Associations</div>
        <table class="ui selectable striped  table" style="margin:auto;width:80%;margin-top:5%">
            <thead>
                <tr style="color:black;font-size:20px" class="center aligned">
                    <th>Year</th>
                    <th>Section</th>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="center aligned">
                <?php
                    $id=$_SESSION["id"];
                    $sql="SELECT * FROM `course_list` WHERE staffA LIKE '$id' OR staffB LIKE '$id' OR staffC LIKE '$id' OR staffD LIKE '$id' ORDER BY batch desc";
                
                    $res=$con->query($sql);
                    $lab="";
                    $word="Laboratory";
                    echo '<tr ><td colspan="5" style="font-size:17px" class="left aligned"><em>General Course</em></td></tr>';
                    while($row=$res->fetch_assoc())
                    {
                    if(strpos($row["name"],$word) !== false)
                    {
                        $lab=$row;
                        continue;
                    }
                    $batch=(2020%intval($row["batch"]))+1;
                    $year=$batch==2?"II":($batch==3?"III":"IV");
                    if($row["staffA"]==$id)
                    {
                        $sec="A";
                    }
                    else if($row["staffB"]==$id)
                    {
                        $sec="B";
                    }
                    else if($row["staffC"]==$id)
                    {
                        $sec="C";
                    }
                    else 
                    {
                        $sec="D";
                    }
                    $code=$row["code"];
                    $name=$row["name"];
                    $btn=strval($row["batch"]%2000)."-".$row["dept"]."-".$sec."/".$code;
                    echo '<tr>
                    <td>'.$year.'</td>
                    <td>'.$sec.'</td>
                    <td>'.$code.'</td>
                    <td>'.$name.'</td>
                    <td class="right aligned"><button class="ui primary right icon button" id="'.$btn.'" onclick="attend(this.id)"> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button>&nbsp;&nbsp;<button class="ui black right icon button" id="'.$btn.'" onclick="history(this.id)"> View History &nbsp&nbsp<i class="history icon"></i></button><button class="ui brown right icon button" id="'.$btn.'" onclick="consolidate(this.id)"> Consolidation &nbsp&nbsp<i class="file export icon"></i></button></td>
                    </tr>';
                    }
                    if($lab!="")
                    {
                    echo '<tr ><td colspan="5" style="font-size:17px" class="left aligned"><em>Laboratory Course</em></td></tr>';
                    
                    $batch=(2020%intval($lab["batch"]))+1;
                    $year=$batch==2?"II":($batch==3?"III":"IV");
                    if($lab["staffA"]==$id)
                    {
                    $sec="A";
                    }
                    else if($lab["staffB"]==$id)
                    {
                    $sec="B";
                    }
                    else if($lab["staffC"]==$id)
                    {
                    $sec="C";
                    }
                    else 
                    {
                    $sec="D";
                    }
                    $code=$lab["code"];
                    $name=$lab["name"];
                    $btn=strval($lab["batch"]%2000)."-".$lab["dept"]."-".$sec."/".$code;
                
                    echo '    <tr>
                    <td>'.$year.'</td>
                    <td>'.$sec.'</td>
                    <td>'.$code.'</td>
                    <td>'.$name.'</td>
                    <td class="right aligned"><button class="ui primary right icon button " id="'.$btn.'"  onclick="attend(this.id)"> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button><button class="ui black right icon button" id="'.$btn.'" onclick="history(this.id)"> View History &nbsp&nbsp<i class="history icon"></i></button><button class="ui brown right icon button" id="'.$btn.'" onclick="consolidate(this.id)"> Consolidation &nbsp&nbsp<i class="file export icon"></i></button></td>
                    
                </tr>';
                }

                ?>
            </tbody>
        </table>
    </div>

    <div id="seg" style="display:none">
    </div>





    <div class="ui tiny inverted modal" id="datepickermod">
        <div class="header">
            KEC Student+
            <button class="ui right floated negative icon button" id="closebtn1">
                <i class=" close icon"></i>
            </button>
        </div>
        <div class="content">


            <form class="ui form" method="POST" action="./import.php">
                <br></br>
                <center>
                    <div class="two fields">
                        <div class="field">
                            <div class="ui header"><span class="ui inverted grey text"> Choose Date to mark the
                                    Attendance</span></div><br>
                            <div class="ui calendar" id="cal">
                                <div class="ui  focus input  left icon">
                                    <i class="calendar icon"></i>
                                    <input type="text" name="dates" placeholder="Date/Time" required>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="ui header"><span class="ui inverted grey text"> Select <br>Period Handled</span>
                            </div>
                            <br>
                            <select name="hrs[]" multiple="" class="ui selection dropdown" id="hr" required>
                                <option value="">Select Period</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="tab" id="tab">
                    <input type="hidden" name="code" id="code">
                    <!-- <input type="hidden" name="" id=""> -->
                    <br></br>
                    <br></br>
                    <div class="ui inverted floating icon message">
                        <i class="info icon"></i>
                        <div class="content">
                            <p style="font-size:16px;">Only Dates for Pending Attendance will be enabled!</p>
                        </div>
                    </div>

                </center>

        </div>
        <div class="actions">
            <button class="ui positive right labeled icon button" type="submit" name="homy">
                Proceed<i class="checkmark icon"></i>
            </button>
            </form>
        </div>
    </div>
    <script>
    var d = "";

    function attend(id) {
        var btn = id.split("/");
        d = "tab=" + btn[0] + "&code=" + btn[1];
        $.ajax({
            url: "./AJAX/handler.php",
            data: d,
            type: "POST",
            success: function(res) {
                var arr = [];
                var i;
                var dates = JSON.parse(res);
                if (!(Array.isArray(dates) && dates.length)) {
                    Notiflix.Notify.Info("You have no pending Attendance reports to be uploaded");
                    return false;
                }
                for (i of dates) {
                    var r = i.split("-");
                    arr.push(new Date(r[0], r[1] - 1, r[2]));
                }
                $('#cal').calendar({
                    type: 'date',
                    enabledDates: arr,
                    formatter: {
                        date: function(date, settings) {
                            if (!date) return '';
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();
                            return day + '/' + month + '/' + year;
                        }
                    }
                });
                $('#hr').dropdown({
                    maxSelections: 3
                });
                $('#tab').val(btn[0]);
                $('#code').val(btn[1]);
                $("#datepickermod").modal({
                    centered: false
                }).modal("show");
            }
        });
    }

    function history(id) {
        var btn1 = id.split("/");
        d1 = "cls=" + btn1[0] + "&code=" + btn1[1];
        $.ajax({
            url: "./AJAX/handler.php",
            data: d1,
            type: "POST",
            success: function(r) {
                if (r === '') {
                    Notiflix.Notify.Info("You haven't uploaded any Attendance reports yet");
                    return false;
                }
                $("#seg").html("");
                $("#seg").append(
                    '<button class="ui right floated circular teal icon button" id="bt" data-tooltip="Back to Home" data-position="bottom right" data-inverted=""  onclick="clss()" style="margin-right:1%;"><i class="undo icon"></i></button><div class="ui header" style="text-align:center;font-size:30px;margin-top:2%;color:#ADEFD1FF">Attendance History &nbsp;&nbsp;<i class="history icon"></i></div>' +
                    r);
                $("#tabl").hide();
                $("#seg").show();
                Notiflix.Notify.Info("Hover on Absentees count to the view Absentees List");
            }
        })
    }


    function consolidate(id) {
        var btn2 = id.split("/");
        d2 = "tname=" + btn2[0] + "&ccode=" + btn2[1] + "&consolidate=true";
        $.ajax({
            url: "./AJAX/handler.php",
            data: d2,
            type: "POST",
            success: function(r) {
                if (r == 'empty') {

                    Notiflix.Notify.Info("You haven't uploaded any Attendance reports yet to consolidate");
                    return false;
                } else if (r == "export_ready") {
                    window.location.href = "export.php";
                } else {
                    Notiflix.Notify.Warning("Error in retrieving data.Please try again Else Contact Admin");
                }

            }
        })
    }

    $(document).ready(function() {

        $("#datepickermod").modal({});
        $("#closebtn1").click(function() {
            $("#datepickermod").modal("hide");
        });
        $('#cal').calendar({
            type: 'date'
        });
    });

    function clss() {
        $("#tabl").show();
        $("#seg").hide();
    }

    function editor(val) {
        var e = val.split("/");
        var arr = {
            "e_code": e[0],
            "e_date": e[1],
            "e_period": e[2],
            "edittab": e[3],
            "editor": "edit"
        };
        $.ajax({
            url: "./AJAX/handler.php",
            type: "POST",
            data: arr,
            success: function(r) {
                if (r == "go&edit") {
                    window.location.href = "editAttdAdv.php";
                }
            }
        });
    }
    </script>

</body>

</html>