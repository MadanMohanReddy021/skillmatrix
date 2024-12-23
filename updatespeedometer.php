<?php
require "conn.php";
$hour=$_GET["hour"];
$line=$_GET["line"];
$sql="select $hour from $line where date=curdate()-1 and OPNAME='Waist Band Spot Tacking'";
$res=mysqli_query($con,$sql);
$total=0;
while($row=mysqli_fetch_assoc($res))
{
$total+=$row[$hour];
}
$update="update lineeff set $hour=$total, completed=completed+$total where date=curdate()-1 and line='$line'";
$ress=mysqli_query($con,$update);


echo' <h1> ADDED SUCCESSFULLY </H1>';
if ($hour === 'H8') {
    header("Location:trigger.php?TABLE=$gettable");
}
?>