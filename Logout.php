<?php
    session_start();
    include_once('./assets/notiflix.php');
?>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="icon" type="image/png" href="KEC.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/Fomantic/dist/semantic.min.css" type="text/css" />
  <script src="./assets/jquery.min.js"></script>
  <script src="./assets/Fomantic/dist/semantic.min.js"></script>
  <link rel="icon" type="image/png" href="./KEC.png">
  <link rel="stylesheet" type="text/css" href="./assets/animate.min.css"/>
  <!-- No Script Part -->
	<noscript><meta http-equiv="refresh" content="0; URL='./errorfile/noscript.html'" /></noscript>
	<!-- -------- -->
    <?php require_once('./assets/notiflix.php');?>
    <script>
        $(document).ready(function(){
            $('.ui.card').transition('drop');
            $('.ui.card').transition('drop');
            });
</script>
</head>
<body>
<style>
body{
    background-image:url('backlogout.jpg');
}
</style>


<?php
$status='';
if(isset($_SESSION['uname'])||isset($_SESSION['user'])||isset($_SESSION['kecadmin'])||isset($_SESSION['developer']))
{

    session_destroy();
	session_unset();
    $status="Logout Successful";
    
}
else{

    session_destroy();
    session_unset();
    //echo "<script> Notiflix.Report.Warning( 'No User Session Detected', 'Logout Successful. Please fill the Feedback form <a href='./entity/feedback.php'>Click here!</a>', 'Okay', function(){location.replace('index.php');} );</script>";
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
       You have logout out successfuly.<br> We wish to have your valuable feedback.<br> Please spare 5 minutes and give your opinion.
      </div>
    </div>
    <div class="extra content">
    <center><div class="ui form">
      <div class="two fields">
      <div class="field"><a href="https://https://forms.office.com/Pages/ResponsePage.aspx?id=DQSIkWdsW0yxEjajBLZtrQAAAAAAAAAAAAN__hxfHbFUOFNCUEFCVzQ1TERNTThDRVFFRk1FVzZJNi4u">
      <button class="ui primary button">Fill Feedback</button></a></div>
      <div class="field"><button onclick="window.open('./index.php', '_self');" class="ui secondary button">Close</button></div>
    </div></center></div>
    <div class="ui bottom attached positive button" onclick="window.open('./index.php', '_self');">
      <i class="sign language icon"></i>
      Thank You!
    </div>
  </div></div>
</div>
</center>
  <style>
.ui.container{
    /* margin-top: 60px; */
}
.ui.card{
    width: 400px;
   
}
.image{
    height: 100px;
}
img{
    width: auto;
     height: auto;}
</style>

</body>
</html>
