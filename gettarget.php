<?php
require "conn.php";
$sql="select line,htarget from lineeff where date=curdate()";
$res=mysqli_query($con,$sql);
$data=[];
while($row=mysqli_fetch_assoc($res))
{
$data[$row["line"]]=$row["htarget"];
}
echo json_encode($data);
?>