<?php
    $sql="SELECT `code` FROM `course_list` where `status` LIKE 'active' AND `category` LIKE 'elective'";
    $res=$con->query($sql);
    $ele=array();
    while($row=mysqli_fetch_array($res))
    {
        array_push($ele,$row['code']);
    }
    $project_array=array(
        "14CSP81"=>array(
                            "A"=>array("CSE010SF","CSE022SF","CSE029SF","CSE038SF","CSE040SF"),
                            "B"=>array("CSE017SF","CSE037SF","CSE041SF","CSE052SF","CSE035SF"),
                            "C"=>array("CSE043SF","CSE036SF","CSE053SF","CSE026SF","CSE030SF"),
                            "D"=>array("CSE008SF","CSE014SF","CSE028SF","CSE031SF","CSE021SF")),
        "18CSP61"=>array(
            "A"=>array("CSE019SF","CSE019SF","CSE019SF","CSE019SF","CSE019SF"),
            "B"=>array("CSE034SF","CSE034SF","CSE034SF","CSE034SF","CSE034SF"),
            "C"=>array("CSE025SF","CSE025SF","CSE025SF","CSE025SF","CSE025SF"),
            "D"=>array("CSE032SF","CSE032SF","CSE032SF","CSE032SF","CSE032SF")
        ));
    function ttfun($con,$ttname,$classname,$course,$project_array,$sid)
    {
        $sql="SELECT * FROM `$ttname` WHERE `class` LIKE '$classname'";
        $res=$con->query($sql);
        $day_per=array();
        while($row=$res->fetch_assoc())
        { 
            $per=array();
            foreach($row as $in=>$v)
            {
                if(strpos($v,$course)!==false)
                {
                    array_push($per,$in);
                } 
            }
            if(!empty($per))
            {
                $day_per+=array($row["day"]=>$per);
            }   
         }
        if(($course=="14CSP81")||($course=="18CSP61"))
        {
            $section=strtoupper(explode("-",$classname)[2]);
            $day_per["Saturday"]=array(array_search($sid, $project_array[$course][$section])+1);
        }
        return $day_per;
    }
    function timetablesfn($con,$tab,$code,$project_array,$sid)
    {
        $timetable=array();
        $tt_res=$con->query("select * from tt_home order by id asc");
        while($row=$tt_res->fetch_assoc())
        {
             $tt=array();
             $tt["from"]=$row["from_date"];
             $tt["to"]=$row["to_date"];
             $tt["tt"]=ttfun($con,$row["rev"],$tab,$code,$project_array,$sid);
             array_push($timetable,$tt);
        }
        return $timetable;
    }
?>
