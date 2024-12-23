<?php
require "conn.php";
$tkno = $_GET['tkno'];
$empname = [];
$sql = "SELECT EMPNAME FROM allemp WHERE TKNO = '$tkno'";
    $res=mysqli_query($con,$sql);
    while($row=mysqli_fetch_assoc($res)){
        $empname['empname'] = $row['EMPNAME'];
    }
header('Content-Type: application/json');
echo json_encode($empname);
?>