<?php
require "conn.php";
$op_sql="select *from opnames";
$op_res=mysqli_query($con,$op_sql);
$op_array=[];
while($op_row=mysqli_fetch_assoc($op_res))
{
    $op_array[$op_row["OP"]]=$op_row["OPN"];
    // echo $op_array[$op_row["OP"]]."&nbsp  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp        ".$op_row["OP"]."<br>";
    $r_op_array[$op_row["OPN"]]=$op_row["OP"];
}
?>
