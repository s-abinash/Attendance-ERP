
<script type="text/javascript">
$(document).ready(function(){
  $("#ann").click(function() {
  $('.ui.longer.modal').modal({
    centered: false,
    transition: 'horizontal flip'
  }).modal('show');
  return false;
  });
  $("#img1").click(function() {
      $('#modal1').modal({
        centered: false,
      }).modal('show');
  });
  $("#img2").click(function() {
      $('#modal2').modal({
        centered: false,
      }).modal('show');
  });
 // $('.ui.embed').embed();
  $("#img3").click(function() {
      $('#modal3').modal({
        centered: false,
      }).modal('show');
  });
});

</script>
<div class="ui longer modal">
<div class="ui orange ribbon label" style="margin-left: 15px;margin-top: 8px">New in Version 4.1</div>
  <div class="header">Announcement <i class="bullhorn icon"></i></div>
  
  <i class="close icon"></i>
  
  <div class="image content">
  <!-- <div class="ui vertical banner test ad"> -->
    <img class="image" src="./images/ann.jpg" style="height: 300px; width: 200px;">
    <!-- </div> -->
    <div class="scrolling content" style="height: 350px;overflow: auto;">
    
    <div class="ui bulleted list">
        <h3 class="item">Google Login is now enabled. Select your kongu.edu account to sign in. <div class="ui yellow horizontal label">New</div></h3>
        <h3 class="item">Advisor Report is available (Cumulative and Period wise). <div class="ui yellow horizontal label">New</div></h3>
        <h3 class="item">Intimation Mail will be sent to the Attd. Pending faculty every week Monday by 3.00 PM. <div class="ui yellow horizontal label">New</div></h3>
        <h3 class="item">Not Entered Report is available for Advisors. <div class="ui yellow horizontal label">New</div></h3>
        <h3 class="item">Holiday entry for HOD.</h3>
        <h3 class="item">Altered period assigned to you will visible as Red Stripe in Calendar in Mark Attendance.</h3>
        <h3 class="item">You can re-alter the period altered to you by someone, by altering that.</h3>
        <h3 class="item">Now as a <span class="ui red text">Progressive Web App </span></h3>
        <h4><i class="laptop icon"></i>:&nbsp;<span id="img1" style="color:#1E70BF;cursor: pointer;font-size: 15px;"> See how to enable</span>&nbsp;|&nbsp;
        <i class="mobile alternate icon"></i>:&nbsp;<span id="img2" style="color:#1E70BF;cursor: pointer;font-size: 15px;"> See how to enable</span></h4>
        <h3 class="item"><span class="ui red text">Google Form Auto Fill </span>is enabled. Check demo.</h3>
        <h4><i class="video icon"></i>:&nbsp;<span id="img3" style="color:#1E70BF;cursor: pointer;"> See Demo Video</span></h4>
        <h3 class="item">Staff can alter their period to another staff.</h3>
    </div>
  </div>
</div>
<div class="actions">
    <div class="ui cancel button">Close</div>
  </div>
</div>
<style>
.ui.longer.modal {
 margin-top: 30%;
 margin-bottom: 20%;
}
</style>

<!-- Image 1 -->
<div class="ui basic modal" id="modal1">
  <i class="close icon"></i>
  <div class="ui icon header">
  <i class="laptop icon"></i>
  <center>
    Install in Laptop
    </center>
  </div>
  <div class="content">
 <center><img type="image/png" src="./images/announcements/pwa_lap.png" height="300" width="700"/></center>
  </div>
  <div class="actions">
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      Okay
    </div>
  </div>
</div>


<!-- Image 2 -->
<div class="ui basic modal" id="modal2">
  <i class="close icon"></i>
  <div class="ui icon header">
  <i class="mobile alternate icon"></i>
  <center>
    Install in Mobile
    </center>
  </div>
  <div class="content">
   <center> <img type="image/jpeg" src="./images/announcements/pwa_mob.jpg" height="700" width="300"/></center>
  </div>
  <div class="actions">
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      Okay
    </div>
  </div>
</div>

<!-- Video -->
<div class="ui basic modal" id="modal3">
  <i class="close icon"></i>
  <div class="ui icon header">
  <center>
    Meeting URL Demo
    </center>
  </div>
  <div class="content">
  <center>
  <!-- <div class="ui embed"> -->
    <video width="820" height="440" loop controls >
      <source src="./images/announcements/URL_Demo.mp4" type="video/mp4"/>
    </video>
  <!-- </div> -->
    </center>
  </div>
  <div class="actions">
    <div class="ui green ok inverted button">
      <i class="checkmark icon"></i>
      Okay
    </div>
  </div>
</div>


