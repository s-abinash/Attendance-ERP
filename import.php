<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link rel="icon" type="image/png" href=".images/KEC.png">
  <link rel="stylesheet" href="./assets/Fomantic/dist/semantic.min.css" type="text/css" />


  <!-- No Script Part -->
  <noscript>
    <meta http-equiv="refresh" content="0; URL='./errorfile/noscript.html'" /></noscript>
  <!--  -->
  <?php include_once('./assets/notiflix.php'); ?>
  <script src="./assets/jquery.min.js"></script>
  <script src="./assets/Fomantic/dist/semantic.min.js"></script>
</head>
<body>
    
</body>
</html>

<?php

include_once('./assets/simplexlsx-master/src/SimpleXLSX.php');

$a = array();
if ($xlsx = SimpleXLSX::parse('./files/sample.xlsx')) {
    foreach ($xlsx->rows(6) as $r) {
        $s = implode($r);
        $str = substr(trim($s), -8);
        array_push($str);
        echo $str . '<br/>';
    }
} else {
    echo SimpleXLSX::parseError();
}
?>
