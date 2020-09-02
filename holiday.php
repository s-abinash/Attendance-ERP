<?php
session_start();

if(!isset($_SESSION['id']))
{
    header('Location: index.html');
}
include_once("./db.php");
$sid=$_SESSION["id"];
$res=$con->query("SELECT * FROM staff where `staffid` LIKE '$sid'")->fetch_assoc();
if($res["designation"]!=="HOD")
{
    header('Location: home.php');
}
else
{
    $dep=$res["dept"];
    // $res=$con->query("SELECT date from holiday");
    //     $hol=array();
    //     while($row=$res->fetch_assoc())
    //     {
    //         array_push($hol,$row["date"]);
    //     }
     
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holiday Entry</title>
    <script src="./assets/jquery.min.js"></script>
    <script src="./assets/Fomantic/dist/semantic.min.js"></script>
    <link rel="icon" type="image/png" href="./images/KEC.png">

    <?php include_once('./assets/notiflix.php'); ?>
    <style>
 
    </style>

</head>

<body id="root">
    <?php
include_once('./navbar.php');
?>
    <style>
    body {
        background: url("./images/bgpic.jpg");
    }
    </style>
    <div class="ui raised segment" style="width:80%;margin:auto;margin-top:2%">
        <form class="ui form" id="frm">
        <div class="ui raised segment" style="width:96%;margin:auto;">
            <div class="ui header" style="text-align:center;margin-top:1%;font-size:26px">Mark Holidays</div>
            <div style="width:45%;margin:auto;">
                <select name="holidays[]" multiple="" class="ui fluid dropdown" id="holidays" >
                    <option value="">Select the Dates from Calendar</option>
                </select>
            </div>
            <div class="ui calendar" id="inline_calendar" style="width:45%;margin:auto;margin-top:1%;" onselect="func()">
            </div>
          <br>
        <div  style="width:90%;margin:auto">
        <div class="two fields">
    
            <div class="field" >
                <label>Date Exemption Type</label>
                <div class="ui search selection dropdown" id="type">
                    <input name="type" type="hidden">
                    <div class="default text">Exemption Type</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="Holiday">Holiday</div>
                            <div class="item" data-value="Exam">Exam</div>
                        </div>
                    </div>
                </div>
            
            <div class="field" >
                <label>Year</label>
                <select name="year[]" multiple="" class="ui fluid dropdown" id="year" >
                    <option value="">Choose Year</option>
                    <option value="2019">II</option>
                    <option value="2018">III</option>
                    <option value="2017">IV</option>
                    <?php 
                        if($dep=='CSE')
                        {
                            echo "<option value='2020' >ME</option>"; 
                        }
                     ?>
                </select>
                 
                </div>   
            </div>
       
        <br>
        <div class="field">
            <label>Comments</label>
            <input placeholder="Comments" name="comment" type="text">
        </div>
        <br>
        </div>

        <center>
            <button class="ui primary button"  type="submit" >Mark as Holiday</button>
        </center>
        </div>
        </form>
    </div>
    <script>
        var arr=[];
    
        // var ar=[];
        // var dates=
        <?php //echo json_encode($hol);?>;
        // for (i of dates) 
        // {
        //     var r = i.split("-");
        //     ar.push({date:new Date(r[0], r[1] - 1, r[2]),message:"Holiday",class: 'green'});
        // }
        $(document).ready(function(){
        
            $('#inline_calendar').calendar({
                type: 'date',
                
                // disabledDates: ar,
                formatter: {
                    date: function (date, settings) {
                        if (!date) return '';
                       
                        var day = date.getDate();
                        var month = date.getMonth() + 1;
                        var year = date.getFullYear();
                        if(day<10)
                        {
                            day='0'+day;
                        }
                        if(month<10)
                        {
                            month='0'+month;
                        }
                        var dat=day + '/' + month + '/' + year;
                        arr.push(dat);
                        if(arr.indexOf(dat)!==-1)
                        {
                            $("#holidays").append("<option value='"+dat+"' selected>"+dat+"</option>");
                        }
                      
                       
                        return '';
                    }
                },
                disabledDaysOfWeek: [0,6],
                inline:true
            });
            $('#type').dropdown({
    allowAdditions: true
  })
;
          
            $('#holidays,#year').dropdown({
                clearable: true,
                sortSelect: true,
                
            });
            $("#frm").on("submit",function(e)
            {
                e.preventDefault();
                if($("#holidays").val()=="")
                {
                    Notiflix.Notify.Warning("Please Choose the Dates First !");
                    return ;
                }
               
                $.ajax({
                    url: "./AJAX/adModules.php",
                    data: $("#frm").serialize(),
                    type: "POST",
                    success: function(res) {
                       
               
                       if(res=="success")
                       {
                        Notiflix.Notify.Success("Holidays Declared Successfully");
                        window.setTimeout(function() {
                            window.location.href = 'home.php';
                        }, 1200);
                       }
                       else
                       {
                        Notiflix.Notify.Warning("Please check the details");

                       }
                        
                    }
                });
           
                return false;
                
            });
        });
    </script>
</body>

</html>
