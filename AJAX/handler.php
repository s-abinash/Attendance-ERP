<?php
    include_once("../db.php");
    session_start();
    $sid=$_SESSION["id"];
    $ele=array("14CSE06","14CSE11","14CSO07","14ITO01","18ITO02","18MEO01");
    
    if(isset($_POST["tab"]))
    {
         $tab=strtolower($_POST["tab"]);
         $code=$_POST["code"];
         $sql="SELECT * FROM `tt` WHERE `class` LIKE '$tab'";
         $res=$con->query($sql);
         $day=array();
         $day_per=array();
         while($row=$res->fetch_assoc())
         { 
              $per=array();
              foreach($row as $in=>$v)
              {
                   if(strpos($v,$code)!==false)
                   {
                        array_push($per,$in);
                   } 
              }
              if(!empty($per))
              {
                    $day_per+=array($row["day"]=>$per);
              }   
         }
     
         $x=date("Y-m-d");
         $tdy=date_create($x);
         $date=date("2020-07-08");
         $diff=intval(date_diff($tdy,date_create($date))->format("%a"))+1;
         $dates=array();
         for($i=1;$i<=$diff;$i++)
         {    
              $s=date("l", strtotime($date));
               foreach($day_per as $d=>$pd)
               {
                    if($d==$s)
                    {
                         foreach($pd as $periods)
                         {
                              if(in_array($code,$ele))
                              {
                                   
                                   
                                   $sql="SELECT * FROM `$code` where date LIKE '$date' AND code LIKE '$sid' AND `period` LIKE '$periods'"; 
                              }
                              else
                              {
                                   $sql="SELECT * FROM `$tab` where date LIKE '$date' AND code LIKE '$code' AND `period` LIKE '$periods'"; 
                              }
                           
                              $r=$con->query($sql);
                              if($r->num_rows==0)
                              {    
                                   array_push($dates,$date);
                              }
                         }
                    }
               }
               $date=date_format(date_add(date_create($date),date_interval_create_from_date_string("1 days")),"Y-m-d");
          }
          if(in_array($code,array("14CSL71","14CSL72")))
          {
               $c=$dates;
               $dates=array();
               foreach($c as $dt)
               {
                    $x=date_diff(date_create(date("2020-07-08")),date_create(date($dt)))->format("%a");
                    if(($code=="14CSL71")&&(($x/7)%2))
                    {
                         array_push($dates,$dt);
                    }
                    else if(($code=="14CSL72")&&((($x/7)%2)==0))
                    {
                         array_push($dates,$dt);
                    }
                    
               }
          }
          $altsql="SELECT date,period FROM `alteration` WHERE `s1` LIKE '$sid' AND `c1` LIKE '$code' AND date<=CURRENT_DATE";
          $res=$con->query($altsql);
          $alt=array();
          while($row=$res->fetch_assoc())
          { 
          
               $alt+=array($row["date"]=>explode(",",$row["period"]));   
          }  
          if(empty($alt))
          {
               $alt="Empty";
          }  
          $alted="SELECT date,period FROM `alteration` WHERE `s2` LIKE '$sid' AND `c2` LIKE '$code' AND date<=CURRENT_DATE";
          $res=$con->query($alted);
          $alted=array();
         
          while($row=$res->fetch_assoc())
          { 
               $per=array();
               $dated= $row["date"];
               $bv=explode(",",$row["period"]);
               foreach($bv as $periods)
               {
                    if(in_array($code,$ele))
                    { 
                         $sql="SELECT * FROM `$code` where date LIKE '$dated' AND code LIKE '$sid' AND `period` LIKE '$periods'"; 
                    }
                    else
                    {
                         $sql="SELECT * FROM `$tab` where date LIKE '$dated' AND code LIKE '$code' AND `period` LIKE '$periods'"; 
                    }
                    
                                           
                    $r=$con->query($sql);
                    if($r->num_rows==0)
                    {    
                         array_push($per,$periods);
                    } 
               } 
               if(!empty($per))
              {
                    $alted+=array($row["date"]=>$per);
              }   

          }  
          if(empty($alted))
          {
               $alted="Empty";
          }  
          echo json_encode(array($dates,$day_per,$alt,$alted));
          exit();

    }
    else if(isset($_POST["cls"]))
    {
         
         $tab=strtolower($_POST["cls"]);


         $code=$_POST["code"];
         $sql="SELECT * FROM `course_list` WHERE code LIKE '$code'";
         $res=($con->query($sql))->fetch_assoc();
         $name=$res["name"]; 
         $sdept=$res["dept"]; 
         $sem=($res["batch"]=='2017'?'7':$res["batch"]=='2018'?'5':'3');
         $sec="";
         if($res["staffA"]==$sid)
         {
             $sec="A ";
         }
         else if($res["staffB"]==$sid)
         {
             $sec.="B";
         }
         else if($res["staffC"]==$sid)
         {
             $sec.="C";
         }
         else 
         {
             $sec.="D";
         }

         if(in_array($code,$ele))
         {
          $sql="SELECT * FROM `$code` WHERE code LIKE '$sid' ORDER BY `date` DESC,`period` ASC"; 
          $tab=$code;
          $code=$code;
         }
         else{
              $sql="SELECT * FROM `$tab` WHERE code LIKE '$code' ORDER BY `date` DESC,`period` ASC"; 
         }
         $res=$con->query($sql);
    
         while($row=$res->fetch_assoc())
         {
               $cnt=mysqli_num_fields($res)-3;
              $d=date("d-m-Y",strtotime($row["date"]));
              $h=$row["period"];
              $abs='<b><em>Course &nbsp: &nbsp'.$name.'<br><br>Date &nbsp: &nbsp '.$d.'<br><br>Absentees:<br> <ol class="ui  list">';
              $ABS_ROLL=array();
              foreach($row as $ind=>$val)
              {
                   if($val=="A")
                   {
                        array_push($ABS_ROLL,$ind);
                        $abs.='<li>'.$ind.'&nbsp; - &nbsp;'.($con->query("SELECT name from registration where regno like '$ind'"))->fetch_assoc()["name"].'</li>';
                   }
              }
              $abs.='</ol></b></em>';
              if(array_key_exists("P",array_count_values($row)))
              {
                    $P=array_count_values($row)["P"];
              }
              else
              {
                    $P=0;
              }
              if(array_key_exists("A",array_count_values($row)))
              {
                    $A=array_count_values($row)["A"];
              }
              else
              {
                    $A=0;
              }
             
              if(array_key_exists("N/A",array_count_values($row)))
              {
                    $na=array_count_values($row)["N/A"];
              }
              else
              {
                    $na=0;
              }
              $cnt-=$na;

              $stf=($con->query("SELECT * FROM `staff` WHERE `staffid` like '$sid'"))->fetch_assoc();


              echo '<div class="ui raised  segment" style="width:80%;margin:auto;margin-top:3%;">
                     
               <div class="ui black info right circular icon message">
             
               <div class="ui header">
                       
                              Date &nbsp;:&nbsp; '.$d.'  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;   Period &nbsp;: &nbsp '.$h.'</span>
                         </div>
                         <div class="content">
                              <div class="ui inverted small statistics" style="margin-left:25%">
                                   <div class="statistic">
                                        <div class="value">
                                             '.$P.'
                                        </div>
                                        <div class="label">
                                             Present
                                        </div>
                                   </div>
                                   <div class="red statistic" id="'.$d.$h.'" >
                                        <div class="value">
                                             '.$A.'
                                        </div>
                                        <div class="label">
                                             Absent
                                        </div>
                                   </div>
                                   <div class="blue statistic">
                                        <div class="value">
                                             '.$cnt.'
                                        </div>
                                        <div class="label">
                                             Total
                                        </div>
                                   </div>
                                   <div class="statistic">
                                        <div class="value">
                                              <button class="ui right floated tertiary icon button" data-tooltip="Click to Edit Uploaded Attendance" id="'.$code."/".$d."/".$h."/".$tab.'" onclick="editor(this.id);" data-position="top left"><i class="edit large icon" style="color:cyan"></i></button>
                                        </div>
                                        <div class="label">
                                             Edit
                                        </div>
                                   </div>
                                   <div class="statistic">
                                        <div class="value">
//                                            <button class="ui right floated tertiary icon button" id="'.$d.$h.'modal" data-tooltip="Click to Enter Meeting URL" data-position="top left"><i class="linkify icon" style="color:red"></i></button>
                                        </div>
                                        <div class="label">
                                             URL
                                        </div>
                                   </div>
                                   
                         </div></div>
                    </div></div><div class="ui popup" id="pop'.$d.$h.'" style="width:100%">'.$abs.'</div>
                    
                    
                    <script>
                    $(document).ready(function(){
                         $("#'.$d.$h.'")
                         .popup({
                         popup: "#pop'.$d.$h.'",
                         inline     : true,
                         hoverable  : true,
                         });
                        
                    });
                    </script>'.
                    '<div class="ui modal" id="modal'.$d.$h.'">
                    <div class="header">Meeting Link Submission</div>
                    <i class="close icon"></i>
                    <div class="content">
                      
                      
                    
                      
                      
                        <form class="ui form" id="gfrm" onsubmit="googleForm()" action="https://docs.google.com/forms/d/e/1FAIpQLSdsVdDBKvncmxe0wdcDteNqEAMJz-IvdWByge3E9x41QpHB0Q/viewform?usp=pp_url" method="post" target="_blank">
                        <div class="field">
                             <input type="text" name="entry.1760172262" value="'.$stf['name'].'" hidden>
                             <input type="text" name="entry.1519840088"  value="'.$stf["dept"].'" hidden>
                             <input type="text" name="entry.1907877152" value="'.($sdept!='MCSE'?'BE':'ME').'" hidden>
                             <input type="text" name="entry.309081512" value="'.$sdept.'" hidden>

                             <input type="text" name="entry.383571963" value="'.$sem.'" hidden>
                             <input type="text" name="entry.1504310176" value="'.$sec.'" hidden>
                             <input type="text" name="entry.15204943" value="'.$code.'"  hidden>
                             <input type="text" name="entry.668277301" value="'.$name.'" hidden>
                             <input type="text" name="entry.1289128628" value="'.(strpos($name,'Laboratory') !== false?'Laboratory':'Theory').'" hidden>
                             <input type="text" name="entry.1170232087" value="'.$d.'" hidden>
                             <input type="text" name="entry.1628375111" value="'.$h.'" hidden>
                             <input type="text" name="entry.1683190265" value="'.$cnt.'" hidden>
                             <input type="text" name="entry.1675431824" value="'.$P.'" hidden>
                             <input type="text" name="entry.1186250163" value="'.$A.'" hidden>
                             <input type="text" name="entry.1654159561" value="'.implode(' , ',$ABS_ROLL).'" hidden>
                             <input type="text" name="entry.1877284434" value="'.intval(($P/$cnt)*100).'%" hidden>
                             <label>Meeting URL: </label>
                             <input type="url" id="url" name="entry.588869143" pattern="https?://drive.google.com.+" required />
                        </div><br/>
                        <button class="ui violet button" type="submit" style="float:right;">Submit</button>
                        <br/>
                        <br/>
                        </form>
                    </div>
                    </div>

                    
                    <script>
                    $(document).ready(function(){
                         $("#'.$d.$h.'modal").on("click",function(){
                              $("#url").val("");
                              $("#modal'.$d.$h.'").modal("show");
                         });
                    });
                    </script>';  
                      
         }
        exit();
    }
    else if(isset($_POST["consolidate"]))
    {
         
         $tab=$_POST["tname"];
          $code=$_POST["ccode"];
          $_SESSION["tname"]=$tab;
          $_SESSION["ccode"]=$code;
          $_SESSION["cname"]=$name=($con->query("SELECT name FROM `course_list` WHERE code LIKE '$code'"))->fetch_assoc()["name"]; 
         $tab=strtolower($tab);
         if(in_array($_POST["ccode"],$ele))
         {
          $num=($con->query("SELECT date from `$code` where code LIKE '$sid'"))->num_rows;
          if($num>=1)
          {
               echo "export_ready_for_Elec";
          }
         }
         else
         {
          $num=($con->query("SELECT date from `$tab` where code LIKE '$code'"))->num_rows;
          if($num>=1)
          {
               echo "export_ready";
          }
         }
         
          
         if($num==0)
          {
               echo "empty";
          }
         
         exit();
    }
    else if(isset($_POST["editor"]))
    {
          $_SESSION["code"]=$_POST["e_code"];
          $_SESSION["period"]=$_POST["e_period"];
          $_SESSION["date"]=$_POST["e_date"];
          $_SESSION["EditAttnd"]="go&edit";
         if(!in_array($_POST["e_code"],$ele))
         {
          $tab=strtoupper($_POST["edittab"]);
          $arr=explode('-',$tab,3);
          $_SESSION["sec"]=$arr[2];
          $_SESSION["batch"]=$arr[0];
          $_SESSION["dep"]=$arr[1];
          echo "go&edit";
          exit();
         }
         echo "go&editElec";
          exit();
    }
?>

<!-- 





                    <form class="ui form" id="gfrm" onsubmit="googleForm()" action="https://docs.google.com/forms/u/0/d/e/1FAIpQLSdAsc0zaLRv11O-p0HEsQqld3d03_LX-rDnY7LyErzpTzNshg/formResponse" method="post" target="_blank">
                         <div class="field">
                              <input type="text" name="entry.1793626567" value="'.$stf['name'].'" hidden>
                              <input type="text" name="entry.392332705"  value="'.$stf["dept"].'" hidden>
                              <input type="text" name="entry.1531750144" value="'.($sdept!='MCSE'?'BE':'ME').'" hidden>
                              <input type="text" name="entry.1145291381" value="'.$sdept.'" hidden>
                              <input type="text" name="entry.2078851275" value="'.$sem.'" hidden>
                              <input type="text" name="entry.979770386" value="'.$sec.'" hidden>
                              <input type="text" name="entry.1589442083" value="'.$code.'"  hidden>
                              <input type="text" name="entry.1343331822" value="'.$name.'" hidden>
                              <input type="text" name="entry.454501088" value="'.(strpos($name,'Laboratory') !== false?'Laboratory':'Theory').'" hidden>
                              <input type="text" name="entry.58122209" value="'.$d.'" hidden>
                              <input type="text" name="entry.1781180711" value="'.$h.'" hidden>
                              <input type="text" name="entry.429113532" value="'.$cnt.'" hidden>
                              <input type="text" name="entry.524302518" value="'.$P.'" hidden>
                              <input type="text" name="entry.540017284" value="'.$A.'" hidden>
                              <input type="text" name="entry.359089973" value="'.implode(' , ',$ABS_ROLL).'" hidden>
                              <input type="text" name="entry.2014037044" value="'.intval(($P/$cnt)*100).'%" hidden>
                              <label>Meeting URL: </label>
                              <input type="url" id="url" name="entry.454419795" pattern="https?://drive.google.com.+" required />
                         </div><br/>
                         <button class="ui violet button" type="submit" style="float:right;">Submit</button>
                         <br/>
                         <br/>
                    </form>
-->

