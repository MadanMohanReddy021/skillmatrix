<?php
require "conn.php";
require "getopname.php";
require "getsmv.php";

if(isset($_POST["line"]))
{
    echo"w000w";
}
var_dump($_POST);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gettable=$_POST["line"];
    
    $selected_hour = $_POST['selected_hour'];

    
    foreach ($_POST['TKNO'] as $key => $TKNO) {
       
        $updated_hour_value =(int) $_POST["hour"][$key];

        
        $updated_operation_name = $_POST['operation'][$key];


        $update_sql = $con->prepare("UPDATE $gettable SET $selected_hour = ? , OPNAME= ? WHERE TKNO = ? and date=curdate()" );
        $update_sql->bind_param('iss', $updated_hour_value, $updated_operation_name, $TKNO);

        if ($update_sql->execute()) {
            // echo "Updated $selected_hour successfully for Token No: $TKNO <br />";
        } else {
            echo "Error updating $selected_hour for Token No: $TKNO: " . $con->error . "<br />";
        }
        
        
        if ($selected_hour === 'H8') {
            
            $hour_sql="select OPNAME,H1,H2,H3,H4,H5,H6,H7,H8 from $gettable where TKNO= '$TKNO'  and date=curdate()";
            $hour_res=mysqli_query($con, $hour_sql);
            
            $i=0;
           $hour_array=[];
            while( $hour_row = mysqli_fetch_assoc($hour_res )  ) {
                // $total =$hour_row["H1"]+$hour_row["H2"]+$hour_row["H3"]+$hour_row["H4"]+$hour_row["H5"]+$hour_row["H6"]+$hour_row["H7"]+$hour_row["H8"];
                $hour_array=array($hour_row["H1"],$hour_row["H2"],$hour_row["H3"],$hour_row["H4"],$hour_row["H5"],$hour_row["H6"],$hour_row["H7"],$hour_row["H8"]);
                
                $smv=$smv_array[$r_op_array[$hour_row["OPNAME"]]];
                $total=$hour_array[0]+$hour_array[1]+$hour_array[2]+$hour_array[3]+$hour_array[4]+$hour_array[5]+$hour_array[6]+$hour_array[7];
            //     for( $i= 1; $i<9; $i++ ){

            //     $hour_array[($i++)-1]=(int)$hour_row['H' . $i];
            //     $total +=$hour_row["H".$i];
            //    } 
                 
            }
            rsort($hour_array);
            $avg=(($hour_array[0]+$hour_array[1]+$hour_array[2]))/3;

            
            $efficiency = round((($avg*$smv)/60)*100);

            // Calculate skill grade based on efficiency
            $skill_grade =0.0;
            if ($efficiency >= 0 && $efficiency <= 50) {
                $skill_grade = 0.25;
            } elseif ($efficiency > 50 && $efficiency <= 90) {
                $skill_grade = 0.5;
            } elseif ($efficiency > 90) {
                $skill_grade = 1;
            }

            // Now, update the table with total, efficiency, and skill grade
            $update_sql = $con->prepare("UPDATE $gettable SET total = ?, eff = ?, skill = ? WHERE TKNO = ?  and date=curdate()");
            $update_sql->bind_param('iids', $total, $efficiency, $skill_grade, $TKNO);
            if ($update_sql->execute()) {
                // echo "Total, Efficiency, and Skill updated successfully for Token No: $TKNO <br />";
            } else {
                echo "Error updating total, efficiency, and skill for Token No: $TKNO: " . $con->error . "<br />";
            }
            
        }
    }
    header("Location:updatespeedometer.php?line=$gettable&hour=$selected_hour");
    if ($selected_hour === 'H8') {
         header("Location:trigger.php?TABLE=$gettable");
    }

}
?>