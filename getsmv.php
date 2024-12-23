<?php
require "conn.php";
$smv_sql="select *from smv";
$smv_res=mysqli_query($con,$smv_sql);
$smv_array=[];
while($smv_row=mysqli_fetch_assoc($smv_res))
{
    $smv_array[$smv_row["OP"]]=$smv_row["SMV"];
}
?>
