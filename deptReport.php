<?php
    session_start();
    if(!isset($_SESSION["id"]))
    {
        header('Location: ./login.php');
    }
    else if($_SESSION["id"]!=="CSE003SF")
    {
        header('Location: ./home.php');
    }
    include_once("./db.php");
    include_once("./navbar.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Report</title>
    <style>
    body {
        background-image: url("./images/bgpic.jpg");
    }
    </style>
</head>
<body>
<div class="ui raised card" style="margin:0 auto;margin-top:5%;width:30%" id="card">
  <div class="content">
    <div class="header">Department Report</div>
    <div class="meta">
      <span class="category">Weekly Class Details</span>
    </div>
    <div class="description" style="padding-top:3%">
    <div class="ui form"  autocomplete="off">
            <div class="field">
            <label>Year</label>
            <select class="ui selection dropdown" id="batch" required>
                <option value="">Select Year of Study</option>
                <option value="2019">UG - II Year</option>
                <option value="2018">UG - III Year</option>
                <option value="2017">UG - IV Year</option>
                <option value="2020">PG - I Year ( ME )</option>
                
            </select>
            </div>
            <div class="field">
            <label>Report Start date</label>
            <div class="ui calendar" id="start">
                <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" placeholder="Start" id="st"  autocomplete="off">
                </div>
            </div>
            </div>
            <div class="field">
            <label>Report End date</label>
            <div class="ui calendar" id="end">
                <div class="ui input left icon">
                <i class="calendar icon"></i>
                <input type="text" placeholder="End" id="en"  autocomplete="off">
                </div>
            </div>
            </div>
        
        </div>
    </div>
  </div>
  <div class="extra content">
  <!-- <div class="left floated author">
        <button class="ui black button">
            Back
        </button>
    </div> -->
    
        <button class="ui primary fluid raised button" id="submit">
            Generate
        </button>
    
  </div>
</div>

<div class="ui raised segment" style="margin:0 auto; margin-top:3%;width:80%;display:none" id="table">
   
<table class="ui purple striped table">

  <thead>
    <tr><h1 class="ui block header">Online class Weekly Report</h1></tr>
    <tr>
        <th class="ten wide">Level of Programme</th>
        <th class="six wide" id="pro"></th>
    </tr>
    <tr>
        <th class="ten wide">Semester</th>
        <th class="six wide" id="sem"></th>
    </tr>
    <tr>
        <th class="ten wide">Generated Report Period</th>
        <th class="six wide" id="pd"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>No.of.Theory Sessions Conducted</td>
      <td id="theory"></td>
    </tr>
    <tr>
      <td>No.of.Lab Sessions Conducted</td>
      <td id="lab"></td>
    </tr>
    <tr>
      <td>No.of.Tutorial Sessions Conducted</td>
      <td id="tut"></td>
    </tr>
    <tr>
      <td>No.of.Project Sessions Conducted</td>
      <td  id="proj"></td>
    </tr>
    <tr>
      <td>No.of.Test Sessions Conducted</td>
      <td  id="test"></td>
    </tr>
  </tbody>
  <tfoot>
    <tr>
    
        
    
  </tr></tfoot>
</table>
<br>
    <button class="ui black button" id="back">
            Back
    </button>
</div>
<script>
 $(document).ready(function(){
    
    var today = new Date();

    $('#start').calendar({
        type: 'date',
        minDate: new Date(2021,00,02),
        maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() ),
        formatter: {
            date: function(date, settings) {
                if (!date) return '';
                var day = date.getDate();
                day=(day<10)?'0'+day: day;
                var month = date.getMonth() +1;
                month=(month<10)?'0'+month: month;
                var year = date.getFullYear();
                return day + '/' + month + '/' + year;
            }
        },
    endCalendar: $('#end')
    });
    $('#end').calendar({
    type: 'date',
    maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() ),
    formatter: {
        date: function(date, settings) {
            if (!date) return '';
            var day = date.getDate();
            day=(day<10)?'0'+day: day;
            var month = date.getMonth()+1 ;
            month=(month<10)?'0'+month: month;
            var year = date.getFullYear();
            return day + '/' + month + '/' + year;
        }
    },
    startCalendar: $('#start')
    });
    $("#batch").dropdown();
    $("#submit").click(function(){
        $("#submit").addClass("loading");
        var b=$("#batch").val();
        var s=$("#st").val();
        var e=$("#en").val();
        if(b===""||s===""||e==="")
        {
            Notiflix.Notify.Warning("Please fill all the fields");
            $("#submit").removeClass("loading");
            return;
        }
        $("#pro").html(b===2020?'PG':'UG');
        $("#sem").html(b==2017?8:(b==2018?6:(b==2019?4:1)));
        $("#pd").html(s+" to "+e);
        var d="batch="+b+"&st="+s+"&en="+e+"&dept=generate";
        $.ajax({
            url: "./AJAX/util_handler.php",
            data: d,
            type: "POST",
            success: function(res) {
                
                $("#submit").removeClass("loading");
                response=JSON.parse(res);

                $("#theory").html(response["theory"]);
                $("#lab").html(response["lab"]);
                $("#tut").html(response["tut"]);
                $("#test").html(response["test"]);
                $("#proj").html(response["proj"]);
                $("#card").hide();
                $("#table").show(); 
            }
            });
    });
    $("#back").click(function(){
        $("#table").hide();
        $("#card").show();
    });
 });
</script>
</body>
</html>