<?php
require "conn.php";
$speeds = [];
$hours=["H1","H2","H3","H4","H5","H6","H7","H8"];
    $sql="select line,H1,H2,H3,H4,H5,H6,H7,H8,htarget from lineeff where date=curdate()";
    $res=mysqli_query($con,$sql);
    $data=[];
    $noofhours=[];
    while($row=mysqli_fetch_assoc($res)){
        $line=$row["line"];
       $htarget=$row["htarget"];
       $count=0;
       $total=0;
       foreach($hours as $hour)
       {
        if(isset($row[$hour]))
        {
            $total+=$row[$hour];
            $count+=1;
        }
       }
       $speeds[$line]=$total;
       $noofhours[$line]=$count;

    }
    $data=[$speeds,$noofhours];
echo json_encode($data);
?>
