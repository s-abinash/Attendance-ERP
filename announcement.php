
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
<div class="ui orange ribbon label" style="margin-left: 15px;margin-top: 8px">New in Version 3.0</div>
  <div class="header">New Updates</div>
  
  <i class="close icon"></i>
  
  <div class="image content">
  <!-- <div class="ui vertical banner test ad"> -->
    <img class="image" src="./images/ann.jpg" style="height: 300px; width: 200px;">
    <!-- </div> -->
    <div class="scrolling content" style="height: 350px;overflow: auto;">
    
    <div class="ui bulleted list">
        <h3 class="item">Now as a <span class="ui red text">Progressive Web App </span><div class="ui yellow horizontal label">New</div></h3>
        
        <h4><i class="laptop icon"></i><span id="img1" style="color:#1E70BF;cursor: pointer;">:&nbsp; See how to enable&nbsp;</span>|&nbsp;
        <i class="mobile alternate icon"></i><span id="img2" style="color:#1E70BF;cursor: pointer;">:&nbsp; See how to enable</span></h4>
        <h3 class="item">Google Form auto fill will be enabled by Sunday (26/07/2020) <div class="ui olive horizontal label">Upcoming</div></h3> 
        <h4><i class="video icon"></i>:&nbsp;<span id="img3" style="color:#1E70BF;cursor: pointer;"> See Demo</span></h4>
        <h3 class="item">Staff can alter their period to another staff. Check it out in the NavBar. <div class="ui yellow horizontal label">New</div></h3>
        <h3 class="item">You can now export the attendance Data to Various Formats.</h3>
        <h3 class="item">Altered period assigned to you will be visible as Red Stripe in Calendar in Mark Attendance.</h3>
        <h3 class="item">You can re-alter the period altered to you by someone by using the same Alter Period Page</h3>
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


