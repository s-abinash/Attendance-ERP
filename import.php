<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>

</head>

<?php

include_once('./navbar.php');
$course="18CSE51-Theory of Computation";
$date="06/07/2020";
?>
<style>
body {
    background: url("./images/bgpic.jpg");
}

#card {
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
</style>

<div class="ui raised padded container segment" id="card" style="margin:auto;">
    <div class="ui form">
        <div class="field">
            <label>Course</label>
            <input type="text" value="<?php echo $course; ?>" readonly />
        </div>
        <div class="field">
            <label>Date</label>
            <input type="text" value="<?php echo $date; ?>" readonly />
        </div>

    </div>
</div>

</body>

</html>

<?php

include_once('./assets/simplexlsx-master/src/SimpleXLSX.php');

$a = array();
if ($xlsx = SimpleXLSX::parse('./files/sample.xlsx')) {
    foreach ($xlsx->rows(6) as $r) {
        $s = implode($r);
        $str = substr(trim($s), -8);
        array_push($a,$str);
        //echo $str . '<br/>';
    }
} else {
    echo SimpleXLSX::parseError();
}
?>