
<script type="text/javascript">
$(document).ready(function(){
  $("#ann").click(function() {
  $('.ui.longer.modal').modal({
    centered: false,
    transition: 'horizontal flip'
  }).modal('show');
  return false;
  });
});

</script>
<div class="ui longer modal">
<a class="ui teal ribbon label">New in 3.0</a>
  <div class="header">New Updates</div>
  
  <i class="close icon"></i>
  
  <div class="image content">
  <!-- <div class="ui vertical banner test ad"> -->
    <img class="image" src="./images/ann.jpg" style="height: 300px; width: 200px;">
    <!-- </div> -->
    <div class="scrolling content" style="height: 350px;overflow: auto;">
    
    <div class="ui bulleted list">
        <h3 class="item">Now as a <span class="ui red text">Progressive Web App </span><div class="ui yellow horizontal label">New</div></h3>
        <i class="laptop icon"></i>:&nbsp;
        <a href="./images/announcements/pwa_lap.png" target="_blank"> See how to enable</a>&nbsp;|&nbsp;
        <i class="mobile alternate icon"></i>:&nbsp;
        <a href="./images/announcements/pwa_mob.jpg" target="_blank"> See how to enable</a></h5>
        <h3 class="item">Google Form auto fill will be enabled by Sunday (26/07/2020) <div class="ui olive horizontal label">Upcoming</div></h3> 
        <h3 class="item">Staff can alter their period to another staff. Check it out in the NavBar. <div class="ui yellow horizontal label">New</div></h3>
        <h3 class="item">You can now export the attendance Data to Various Formats.</h3>
        <h3 class="item">Altered period assined to you will be visible as Red Stripe in Calendar in Mark Attendance.</h3>
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