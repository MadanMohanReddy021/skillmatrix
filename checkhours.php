<?php
require "conn.php";
$hour=$_POST["hour"];
$line=$_POST["line"];
$sql="select * from $line where date=curdate() and $hour IS NULL";
$res=mysqli_query($con,$sql);
if(mysqli_num_rows($res)>1)
{
    echo'yes';
}
else{
    echo'0';
}
?>
