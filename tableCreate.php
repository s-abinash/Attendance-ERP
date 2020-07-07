<?php
   
   include_once("./db.php");


$cnt=0;
$str="CREATE TABLE `18-CSE-A` (date varchar(10) NOT NULL,code varchar(10) NOT NULL,period int NULL";

for($i=1;$i<=9;$i++)
{
    $str.="18CSR00".$i." VARCHAR(2) NULL,";   
}
for($i=10;$i<=60;$i++)
{
    $str.="18CSR0".$i." VARCHAR(2) NULL,";   
}
for($i=239;$i<=243;$i++)
{
    $str.="18CSL".$i." VARCHAR(2) NULL,";   
}

$str.="PRIMARY KEY(DATE,CODE,period),FOREIGN KEY (CODE) REFERENCES COURSE_LIST(CODE))";

if($con->query($str))
{
    echo "Successfull";
}
else
{
    echo $str;
    echo "error";
}





?>
