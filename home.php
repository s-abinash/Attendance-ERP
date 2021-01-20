<?php
    session_start();
    if(!isset($_SESSION["id"]))
    {
        header('Location: ./login.php');
    }
    else
    {
        $staffid=$_SESSION['id'];
    }
    include_once("./db.php");
    include_once("./navbar.php");
    include_once("./AJAX/header.php");

    $staffid = $_SESSION['id'];
        //echo '<script>alert("'.$staffid.'");</script>';
        $sql = "SELECT * from `staff` where `staffid` like '$staffid'";
        $data = $con->query($sql);
        $row = $data->fetch_assoc();
        if ($row['status'] == 'Not Changed') {
        echo "<script>$(function(){
        $('body')
        .toast({
            position: 'bottom right',
            title: 'Warning',
            class: 'warning',
            displayTime: 3000,
            closeIcon: true,
            showIcon: true,
            message: 'Password needs to be changed atleast once',
            showProgress: 'top'
        });
        });</script>";
        }
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
        <div class="ui header" style="text-align:center;font-size:30px;margin-top:2%;color:#ADEFD1FF">Your Class Associations
        </div>
        <table class="ui selectable striped  table" style="margin:auto;width:80%;margin-top:2%">
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
                    $result=$con->query("SELECT * FROM `course_list` WHERE staffA LIKE '%$id%' OR staffB LIKE '%$id%' OR staffC LIKE '%$id%' OR staffD LIKE '%$id%' ORDER BY batch desc");
                    $core_list=array();
                    $elect_list=array();
                    $lab_list=array();
                    $proj_list=array();
                    while($row=$result->fetch_assoc())
                    {
                        
                        if($row["category"]==="core")
                        {
                            array_push($core_list,$row);
                        }
                        else if($row["category"]==="elective")
                        {
                            array_push($elect_list,$row);
                        }
                        else if($row["category"]==="lab")
                        {
                            array_push($lab_list,$row);
                        }
                        else if($row["category"]==="proj")
                        {
                            array_push($proj_list,$row);
                        }
                    }

                    if(!empty($core_list))
                    {
                        echo '<tr ><td colspan="5" style="font-size:17px" class="left aligned"><em>General Course</em></td></tr>';
                        foreach ($core_list as $core) 
                        {
                            $batch=(2020%intval($core["batch"]))+1;
                            $year=$batch==2?"II":($batch==3?"III":"IV");
                            $sec="";
                            if(substr_count($core["staffA"],$id))
                            {
                                $sec="A";

                            }
                            if(substr_count($core["staffB"],$id))
                            {
                                $sec="B";
                            }
                            if(substr_count($core["staffC"],$id))
                            {
                                $sec="C";
                            }
                            if(substr_count($core["staffD"],$id)) 
                            {
                                $sec="D";
                            }
                           
                            if($batch==1)
                            {
                                $year='ME';
                                $sec='-';
                            }
                            $code=$core["code"];
                            $name=$core["name"];
                            $btn=strval($core["batch"]%2000)."-".$core["dept"]."-".$sec."/".$code;
                            echo '<tr>
                            <td>'.$year.'</td>
                            <td>'.$sec.'</td>
                            <td>'.$code.'</td>
                            <td>'.$name.'</td>
                            <td class="right aligned"><button class="ui primary right icon button" id="'.$btn.'" onclick="attend(this.id)"> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button><button class="ui black right icon button" id="'.$btn.'" onclick="history(this.id)"> View History &nbsp&nbsp<i class="history icon"></i></button><button class="ui purple right icon button" id="'.$btn.'" onclick="consolidate(this.id)"> Report &nbsp&nbsp<i class="file export icon"></i></button></td>
                            </tr>'; 
                        }
                    }
                    
                    if(!empty($elect_list))
                    {
                        echo '<tr ><td colspan="5" style="font-size:17px" class="left aligned"><em>Elective Course</em></td></tr>';
                        foreach ($elect_list as $row) 
                        {
                        $batch=(2020%intval($row["batch"]))+1;
                        $year=$batch==2?"II":($batch==3?"III":"IV");
                        $sec="";
                        if($row["staffA"]==$id)
                        {
                            $sec.="A ";
                        }
                        if($row["staffB"]==$id)
                        {
                            $sec.="B ";
                        }
                        if($row["staffC"]==$id)
                        {
                            $sec.="C ";
                        }
                        if($row["staffD"]==$id) 
                        {
                            $sec.="D ";
                        }
                        if($batch==1)
                        {
                            $year='ME';
                            $sec='-';
                        }

                        $code=$row["code"];
                        $name=$row["name"];
                        $btn=strval($row["batch"]%2000)."-".$row["dept"]."-".$sec[0]."/".$code;
                        if($code==="18CSE02")
                        {
                            $sec="A ".$sec;
                        }
                        echo '<tr>
                        <td>'.$year.'</td>
                        <td>'.$sec.'</td>
                        <td>'.$code.'</td>
                        <td>'.$name.'</td>
                        <td class="right aligned">
                            <button class="ui primary right icon button" id="'.$btn.'" onclick="attend(this.id)"> Mark Attendance &nbsp; &nbsp;<i class="check icon"></i></button>
                            <button class="ui black right icon button" id="'.$btn.'" onclick="history(this.id)"> View History &nbsp; &nbsp;<i class="history icon"></i></button>
                            <button class="ui purple right icon button" id="'.$btn.'" onclick="consolidate(this.id)"> Report &nbsp; &nbsp;<i class="file export icon"></i></button>
                        </td>
                        </tr>';
                        }
                    }

                    if(!empty($lab_list))
                    {
                        echo '<tr ><td colspan="5" style="font-size:17px" class="left aligned"><em>Laboratory Course</em></td></tr>';
                        foreach ($lab_list as $row) 
                        {
                        $batch=(2020%intval($row["batch"]))+1;
                        $year=$batch==2?"II":($batch==3?"III":"IV");
                        if(substr_count($core["staffA"],$id))
                        {
                            $sec="A";
                        }
                        if(substr_count($core["staffB"],$id))
                        {
                            $sec="B";
                        }
                        if(substr_count($core["staffC"],$id))
                        {
                            $sec="C";
                        }
                        if(substr_count($core["staffD"],$id)) 
                        {
                            $sec="D";
                        }
                        if($batch==1)
                        {
                            $year='ME';
                            $sec='-';
                        }
                        $code=$row["code"];
                        $name=$row["name"];
                        $btn=strval($row["batch"]%2000)."-".$row["dept"]."-".$sec."/".$code;
                        echo '<tr>
                        <td>'.$year.'</td>
                        <td>'.$sec.'</td>
                        <td>'.$code.'</td>
                        <td>'.$name.'</td>
                        <td class="right aligned"><button class="ui primary right icon button " id="'.$btn.'"  onclick="attend(this.id)"> Mark Attendance &nbsp;&nbsp;<i class="check icon"></i></button><button class="ui black right icon button" id="'.$btn.'" onclick="history(this.id)"> View History &nbsp;&nbsp;<i class="history icon"></i></button><button class="ui purple right icon button" id="'.$btn.'" onclick="consolidate(this.id)"> Report &nbsp; &nbsp;<i class="file export icon"></i></button></td>
                        </tr>';
                        }
                    }
        
                    if(!empty($proj_list))
                    {
                        echo '<tr ><td colspan="5" style="font-size:17px" class="left aligned"><em>Project Course</em></td></tr>';
                        foreach ($proj_list as $core) 
                        {
                            $batch=(2020%intval($core["batch"]))+1;
                            $year=$batch==2?"II":($batch==3?"III":"IV");
                           
                            if(substr_count($core["staffA"],$id))
                            {
                                $sec="A";
                            }
                            if(substr_count($core["staffB"],$id))
                            {
                                $sec="B";
                            }
                            if(substr_count($core["staffC"],$id))
                            {
                                $sec="C";
                            }
                            if(substr_count($core["staffD"],$id)) 
                            {
                                $sec="D";
                            }
                            if($batch==1)
                            {
                                $year='ME';
                                $sec='-';
                            }
                            $code=$core["code"];
                            $name=$core["name"];
                            $btn=strval($core["batch"]%2000)."-".$core["dept"]."-".$sec."/".$code;
                            echo '<tr>
                            <td>'.$year.'</td>
                            <td>'.$sec.'</td>
                            <td>'.$code.'</td>
                            <td>'.$name.'</td>
                            <td class="right aligned"><button class="ui primary right icon button" id="'.$btn.'" onclick="attend(this.id)"> Mark Attendance &nbsp&nbsp<i class="check icon"></i></button><button class="ui black right icon button" id="'.$btn.'" onclick="history(this.id)"> View History &nbsp&nbsp<i class="history icon"></i></button><button class="ui purple right icon button" id="'.$btn.'" onclick="consolidate(this.id)"> Report &nbsp&nbsp<i class="file export icon"></i></button></td>
                            </tr>'; 
                        }
                    }
                   

                ?>
            </tbody>
        </table>
    </div>

    <div id="seg" style="display:none">
    </div>

    <script type="text/javascript">
    function frm2check()
    {
        var date=document.getElementById("dat").value;
        var period=document.getElementById("hr").value;
        if(data =='' || period=='')
        {
            Notiflix.Notify.Failure('Please select Date and Period');
            return false;
        }
        else
        {
            return true;
        }
    }
    
    </script>



    <div class="ui tiny inverted modal" id="datepickermod">
        <div class="header">
            KEC Student+
            <button class="ui right floated negative icon button" id="closebtn1">
                <i class=" close icon"></i>
            </button>
        </div>
        <div class="content">
            <form autocomplete="off" class="ui form" id="frm2" method="POST" action="./import.php" onsubmit="frm2check()">
                <br></br>
                <center>
                <div id="fm1">
                    <div class="two fields">
                        <div class="field">
                            <div class="ui header"><span class="ui inverted grey text"> Choose Date to mark the
                                    Attendance</span></div><br>
                            <div class="ui calendar" id="cal">
                                <div class="ui  focus input  left icon">
                                    <i class="calendar icon"></i>
                                    <input type="text" name="dates" placeholder="Date/Time" id="dat" required readonly style="cursor:pointer">
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="ui header"><span class="ui inverted grey text"> Select <br>Period Handled</span>
                            </div>
                            <br>
                            <select name="hrs[]" multiple="" class="ui selection dropdown" id="hr"  required>
                                <option value="">Select Period</option>
                             
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
                </div>
                <div id="fm2">
                </div>
                </center>
                
                
        </div>
        <div class="actions">
            <button class="ui primary right labeled icon button" id="modalnxt">
                Next<i class="checkmark icon"></i>
            </button>
            <button class="ui positive right labeled icon button"
             type="submit" name="homy" id="homy" disabled>
                Proceed<i class="arrow circle right icon"></i></i>
            </button>
            </form>
        </div>
    </div>
    <script>
    var d = "";
    var x,y;
    var response;
    var dt;
    var elec=<?php echo json_encode($ele)?>;
   
    function getWeekDay(date)
    {
    var weekdays = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
    var day = date.getDay();
    
    return weekdays[day];
    }

    function attend(id) {
        $('.preloader').css("display","");
        var btn = id.split("/");
        d = "tab=" + btn[0] + "&code=" + btn[1];
        $.ajax({
            url: "./AJAX/handler.php",
            data: d,
            type: "POST",
            success: function(res) {
            //    console.log(res);
            //     return false;
                response=JSON.parse(res);
                var arr = [];
                var i;
                var dates =response[0];
                var tt_rev=response[1];
                var alt=response[2];
                var alted=response[3];
    
                if ((!(Array.isArray(dates) && dates.length) && alted=="Empty") ||((JSON.stringify(Object.keys(alt)) === JSON.stringify(dates))&& alted=="Empty")) {
                    // Notiflix.Notify.Info("You have no pending Attendance reports to be uploaded");
                    $('body')
                        .toast({
                            position: 'bottom right',
                            title: 'All Done!',
                            displayTime: 5000,
                            class: 'success',
                            closeIcon: true,
                            showIcon: true,
                            message: 'You have no pending attendance to be uploaded',
                            showProgress: 'top'
                        });
                    return false;
                }
               
                for (i of dates) 
                {
                    var r = i.split("-");
                    arr.push(new Date(r[0], r[1] - 1, r[2]));
                }
                var deldate=[];
                var delday=[];
               
                if(alt!="Empty")
                {
                    for (const altdat in alt) {
                        var r = altdat.split("-");
                        var alt_date=new Date(r[0], r[1] - 1, r[2]);
                        x=(alt_date.getMonth() + 1);
                        y=alt_date.getDate()
                        if(x<=9)
                        {
                            x="0"+x;
                        }
                        if(y<=9)
                        {
                            y="0"+y;
                        }
                        var tt;
                        datecreated=parseInt((alt_date.getFullYear())+''+(x)+''+(y)) 
                        tt_rev.forEach(rev => {
                            var from=rev["from"].replaceAll("-","");
                            var to=rev["to"].replaceAll("-","");
                            if((datecreated>=parseInt(from))&&(datecreated<=parseInt(to)))
                            {
                                tt=rev["tt"];
                                return;
                            }
                       });
                        var alt_day=tt[getWeekDay(alt_date)];
                        if((alt_day.length==alt[altdat].length)&&(!(Object.keys(alted)).includes(altdat)))
                        {
                            deldate.push(alt_date);
                        }
                        else
                        {
                            delday.push(altdat);
                        }
                    }
                }
                var al=[];
                var foc=[];
                if(alted!="Empty")
                {
                    for (const alteddat in alted) {
                        var r = alteddat.split("-");
                        var p=new Date(r[0], r[1] - 1, r[2]);
                        arr.push(p);
                        foc.push(p);
                        al.push(alteddat);
                    }
                }
                $('#cal').calendar({
                    type: 'date',
                     enabledDates: arr,
                    disabledDates: [
                        {
                            date: deldate,
                            message: 'Altered'
                        }
                    ],
                    eventClass: 'inverted red',
                    eventDates: [    
                        {
                            date: foc,
                            message: 'Altered Period'
                        }
                    ],
                   
                    formatter: {
                        date: function(date, settings) {
                            if (!date) return '';
                            var day = date.getDate();
                            var month = date.getMonth() + 1;
                            var year = date.getFullYear();
                            return day + '/' + month + '/' + year;
                        }
                    },
                    onChange   : function(date, settings) {
                        var datecreated;
                        $('#hr').dropdown('clear');
                        $("#hr").html("<option class='item' value=''>Select Period</option>");
                        if (!date) return '';
                            
                            x=(date.getMonth() + 1);
                            y=date.getDate()
                            if(x<=9)
                            {
                                x="0"+x;
                            }
                            if(y<=9)
                            {
                                y="0"+y;
                            }
                            var day = date.getFullYear() + '-' +x+ '-' +y ;
                            var tt;
                            if(dates.includes(day))
                            {
                                datecreated=parseInt((date.getFullYear())+''+(x)+''+(y));
                                tt_rev.forEach(rev => {
                            var from=rev["from"].replaceAll("-","");
                            var to=rev["to"].replaceAll("-","");
                            if((datecreated>=parseInt(from))&&(datecreated<=parseInt(to)))
                            {
                                tt=rev["tt"];
                                return;
                            }
                           
                       });
                                var ar=tt[getWeekDay(date)];    
                                for (i of ar)
                                {
                                    $("#hr").append("<option class='item' value='"+i+"'>"+i+"</option>");
                                }
                            }                            
                            if(al.includes(day))
                            {
                                for(i of alted[day])
                                {
                                    $("#hr").append("<option class='item' value='"+i+"'>"+i+"</option>");
                                }
                                
                            }
                            if(delday.includes(day))
                            {
                                for(i of alt[day])
                                {
                                    $("#hr option[value='"+i+"']").remove();
                                }
                                
                            }
                            // if($('#hr > option').length==1)
                            // {   
                            //     $('#frm2').form('set value', 'hrs', ar[0]);    
                            // }
                    }
                });
                $('#hr').dropdown({
                    maxSelections: 3
                });
                $('#tab').val(btn[0]);
                $('#code').val(btn[1]);
                if(elec.includes(btn[1]))
                {
                    $('#frm2').attr('action','importElec.php');
                }
                $("#fm1").show();
                $("#fm2").html("");
                $("#modalnxt").show();
                $( "#homy" ).prop( "disabled", true );
                $("#datepickermod").modal({
                    centered: false
                }).modal("show");
            }
        });
        $('.preloader').css("display","none");
    }

    function history(id) {
        $('.preloader').show();
        var btn1 = id.split("/");
        d1 = "cls=" + btn1[0] + "&code=" + btn1[1];
        
        $.ajax({
            url: "./AJAX/handler.php",
            data: d1,
            type: "POST",
            success: function(r) {
                if (r === '') {
                    // Notiflix.Notify.Info("You haven't uploaded any Attendance reports yet");
                    $('body')
                        .toast({
                            position: 'bottom right',
                            title: 'No History !',
                            displayTime: 3000,
                            class: 'warning',
                            closeIcon: true,
                            showIcon: true,
                            message: 'You have not uploaded any Attendance reports yet',
                            showProgress: 'top'
                        });
                    $('.preloader').hide(); 
                    return false;
                }
                $("#seg").html("");
                $("#seg").append(
                    '<button class="ui left floated circular teal icon button" id="bt" data-tooltip="Back to Home" data-position="right center" data-inverted=""  onclick="clss()" style="margin-left:2%;"><i class="arrow left icon"></i></button><div class="ui header" style="text-align:center;font-size:30px;margin-top:2%;color:#ADEFD1FF">Attendance History &nbsp;&nbsp;<i class="history icon"></i></div>' +
                    r);
                $("#tabl").hide();
                $("#seg").show();
               
                // Notiflix.Notify.Info("Hover on Absentees count to the view Absentees List");
                $('body').toast({
                    position: 'bottom right',
                    title: 'Tip !',
                    displayTime: 5000,
                    closeIcon: true,
                    showIcon: true,
                    message: 'Hover on Absentees count to view Absentee List',
                    showProgress: 'top'
                });
               $('.preloader').hide(); 
            }
            
        })
        
    }
    function consolidate(id) {
        $('.preloader').show();
        var btn2 = id.split("/");
        d2 = "tname=" + btn2[0] + "&ccode=" + btn2[1] + "&consolidate=true";
        $.ajax({
            url: "./AJAX/handler.php",
            data: d2,
            type: "POST",
            success: function(r) {
                if (r == 'empty') {
                    $('.preloader').hide();
                    // Notiflix.Notify.Info("You haven't uploaded any Attendance reports yet to consolidate");
                    $('body').toast({
                    position: 'bottom right',
                    title: 'Error!',
                    displayTime: 3000,
                    closeIcon: true,
                    class: 'error',
                    showIcon: true,
                    message: 'You have not uploaded any attendance yet to get Report.',
                    showProgress: 'top'
                });
                    
                    return false;

                } else if (r == "export_ready") {
                    window.location.href = "export.php";
                }else if (r == "export_ready_for_Elec") {
                    window.location.href = "exportElec.php";
                } else {
                    $('.preloader').hide();
                    // Notiflix.Notify.Warning("Error in retrieving data.Please try again Else Contact Admin");
                    $('body').toast({
                    position: 'bottom right',
                    title: 'Error!',
                    displayTime: 3000,
                    closeIcon: true,
                    class: 'error',
                    showIcon: true,
                    message: 'Error in retrieving data. Please try again Else Contact Admin.',
                    showProgress: 'top'
                });
                }

            }
        })
    }
   
    $(document).ready(function() {
        //$('.message .close').on('click', function() {
        //$(this).closest('.message').transition('fade');});
        $("#datepickermod").modal();
        $('.ui.dropdown').dropdown();
        $("#closebtn1").click(function() {
            
            $("#datepickermod").modal("hide");
            $('form').form('clear');
            $('#hr').dropdown('clear');

        });
        $('#cal').calendar({
            type: 'date'
        });
        $("#modalnxt").click(function (e) {
            var pds=$("#hr").val();
            $("#fm1").hide();
            $("#fm2").html("");
            pds.forEach(i => {
                $("#fm2").append(
            '<div class="two fields">'+
                '<div class="field"><span class="ui large  text">'
                 +((i>3)?i+'<sup>th</sup>':((i==1)?'1<sup>st</sup>':((i==2)?'2<sup>nd</sup>':((i==3)?'3<sup>rd</sup>':''))))+' Hour'+
                '</span></div>'+
                '<div class="field">'+
                '<select name="'+i+'" class="ui fluid dropdown"  required>'+
                    '<option class="item" value="">Select Class Type</option><option class="item" value="Theory">Theory</option>'+
                    '<option class="item" value="Tutorial">Tutorial</option><option class="item" value="Test">Test</option>'+
                    '<option class="item" value="Laboratory">Laboratory</option><option class="item" value="Project">Project</option>'+
                '</select>'+
                '</div>'+
            '</div>');
            });


            
          
           $("#modalnxt").hide();
           $( "#homy" ).prop( "disabled", false );

            e.preventDefault();
        });
    });

    function googleForm()
    {
        $(".ui.modal").modal("hide");
    }
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
                else if (r == "go&editElec") {
                    window.location.href = "editAttdElec.php";
                }
            }
        });
    }

    
    </script>
    
</body>

</html>
