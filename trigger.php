<?php
ini_set('display_errors', 'Off');   
error_reporting(E_ALL & ~E_WARNING); 

require "conn.php";
require"getopname.php";
$gettable=$_GET["TABLE"];
$query = "SELECT TKNO, OPNAME, skill FROM  $gettable  where date=curdate()-1";
$result = mysqli_query($con, $query);
if ($result) {
    
    while ($row = mysqli_fetch_assoc($result)) {
        $tkno = $row['TKNO']; 
         
        $opname = $r_op_array[$row['OPNAME']]; 
        $skill = $row['skill'];  
        $updateQuery = " UPDATE skillmatrix SET `$opname` = $skill WHERE TKNO = '$tkno' AND `$opname` < $skill";
        if (mysqli_query($con, $updateQuery)) {
            // echo "Record updated successfully for TKNO: $tkno and OPNAME: $opname<br>";
        } else {
            echo "Error updating record for TKNO: $tkno and OPNAME: $opname: " . mysqli_error($con) . "<br>";
        }
    
    }
}
else {
    echo "Error fetching records: " . mysqli_error($con);
}
mysqli_close($con);
echo"<h1>UPLOADED SUCESSFULLY AND SKILLS ARE UPDATED SUCESSFULLY</h1><br><p>now you can go to home page";
?>
