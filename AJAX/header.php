<?php
    
    $sql="SELECT `code` FROM `course_list` where `status` LIKE 'active' AND `category` LIKE 'elective'";
    $res=$con->query($sql);
    $ele=array();
    while($row=mysqli_fetch_array($res))
    {
        array_push($ele,$row['code']);
    }
    function ttfun($con,$ttname,$classname,$course)
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
        return $day_per;
    }
    function timetablesfn($con,$tab,$code)
    {
        $timetable=array();
        $tt_res=$con->query("select * from tt_home order by id asc");
        
        while($row=$tt_res->fetch_assoc())
        {
             $tt=array();
             $tt["from"]=$row["from_date"];
             $tt["to"]=$row["to_date"];
             $tt["tt"]=ttfun($con,$row["rev"],$tab,$code);
             array_push($timetable,$tt);
        }
        return $timetable;
    }
?>