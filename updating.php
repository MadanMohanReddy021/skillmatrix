<?php
ini_set('display_errors', 'Off');   // Disable displaying errors in the browser
error_reporting(E_ALL & ~E_WARNING); // Disable warnings, but keep other errors

session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}
// Database connection
require "conn.php";
require "getopname.php";
require "getsmv.php";
$gettable=$_GET["TABLE"];
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
$sql = "SELECT TKNO,EMPNAME,OPNAME FROM $gettable where date=CURDATE()";// add ' where date=CURDATE()' IN THE QUERY
$result = $con->query($sql);
 

$operation_sql = "SHOW COLUMNS FROM skillmatrix";
$operation_res = $con->query($operation_sql);

// Prepare the list of operation names for the datalist
$operation_names = [];
while ($operation_row = $operation_res->fetch_assoc()) {
    $operation_names[] = $operation_row["Field"];
}
unset($operation_names[0]);
unset($operation_names[1]);
// Update employee data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $selected_hour = $_POST['selected_hour'];

    
    foreach ($_POST['TKNO'] as $key => $TKNO) {
       
        $updated_hour_value =(int) $_POST["hour"][$key];
        $update_sql = $con->prepare("UPDATE $gettable SET $selected_hour = ? WHERE TKNO = ? and date=curdate()" );
        $update_sql->bind_param('is', $updated_hour_value, $TKNO);

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

                $hour_array=array($hour_row["H1"],$hour_row["H2"],$hour_row["H3"],$hour_row["H4"],$hour_row["H5"],$hour_row["H6"],$hour_row["H7"],$hour_row["H8"]);
                $smv=$smv_array[$r_op_array[$hour_row["OPNAME"]]];
                $total=$hour_array[0]+$hour_array[1]+$hour_array[2]+$hour_array[3]+$hour_array[4]+$hour_array[5]+$hour_array[6]+$hour_array[7];
            } 
            rsort($hour_array);
            $avg=($hour_array[0]+$hour_array[1]+$hour_array[2])/3;

            
            $efficiency = round((($avg*$smv)/60)*100);//efficeincy

            
            $skill_grade =0.0;
            if($efficiency==0)
            {
                $skill_grade =0.0;
            }
            elseif ($efficiency >= 0 && $efficiency <= 50) {
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
   

}

    
   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee Hours</title>
    <script src="jj.js"></script>
    <script>
        $(document).ready(function()
    {
$("#note").hide();
$("#selected_hour").change(function()
{
    var hour=$(this).val();
    var line='<?php echo $gettable;?>';
    $.ajax({
        url:'checkhours.php',
        type:'post',
        data:{
            hour:hour,
            line:line
        },
        success:function(response){
            console.log(response);
            if(!(response=='yes'))
        {
            $(".container").slideUp(1000);
            $("#note").slideDown(1000);
            $("#note").html("You have alredy uploaded for the selected hour:  "+hour+"and line:  "+line);
    
        }
        else{
            $(".container").slideDown(1000);
            $("#note").slideUp(1000);
        }
        },
        error:function(xhr,status,error)
        {
            console.log('ERROR:'+error);
        }
    });
});
    });
    </script>
    <style>
    .notes
    {
        width: 32%;
        height:30%;
        margin-left: 33%;
        background-color: rgb(185, 51, 46);
        border: 2px solid #FFD700;
        border-radius: 10px;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        color: whitesmoke;
        align-content: center;
    }      
    .no
    {
        width: 33%;
        height:30%;
        margin-left: 32%;
        background-color: rgb(185, 51, 46);
        border: 1px solid #FFD700;
        border-radius: 10px;
        box-shadow: 5px 5px 15px rgba(0,0,0,0.2);
        color: whitesmoke;
        align-content: center;
    }      
    #note{
        font-size: x-large;
    }
    #action{
        font-size: x-large;
        font-family: Arial, Helvetica, sans-serif;
    }
     input {
     width:300px;
}
    input[type="checkbox"]   {
        margin-left: 0 px;
    }
    table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
}


table thead {
    background-color:rgba(0, 105, 175, 0.62);
    color: white;
}


table th {
    padding: 10px;
    text-align: left;
}


table tr:nth-child(even) {
    background-color:rgba(0, 255, 242, 0.1);
}


table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}


table tr:hover {
    background-color: #ddd;
}


table td:first-child {
    font-weight: bold;
}


table {
    margin-top: 20px;
}
.button {
            padding: 12px 30px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            width:20%;
            margin-left:40%;
            cursor: pointer; 
 }
.button:hover {
            background-color: #45a049;
} 
.container {
            margin: 0 auto;
            background-color: #ffffff;
            padding: 2px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #BFE2FF; 
        }

        h2 {
            text-align: center;
            color: #007BFF; /* Skyblue color for the heading */
            margin-bottom: 20px;
        }

        label {
            font-size: 1rem;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }
        input {
            width: 95%;
            font-size: 1rem;
            border-radius: 4px;
            border: 1px solid #BFE2FF; /* Skyblue border for dropdown */
            background-color: #fff;
            color: #333;
          padding:10px;
        }

        input:focus {
            border-color: #28a745; /* Green border on focus */
            outline: none;
        }

        select {
            width: 100%;
            padding: 5px;
            font-size: 1rem;
            border-radius: 4px;
            border: 1px solid #BFE2FF; /* Skyblue border for dropdown */
            background-color: #fff;
            color: #333;
            margin-bottom: 20px;
        }

        select:focus {
            border-color: #28a745; /* Green border on focus */
            outline: none;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            select {
                font-size: 0.9rem;
                padding: 8px;
            }
        }
    </style>
    <script>
        // Function to confirm form submission
        function confirmSubmit() {
            // Show a confirmation dialog
            var confirmation = confirm("Are you sure you want to submit the form?");
            
            // If user clicks "OK", form will be submitted, otherwise it will be cancelled
            if (confirmation) {
                return true;  // Proceed with form submission
            } else {
                return false; // Prevent form submission
            }
        }
        
    </script>
    <script src="jj.js"></script>
    <script>
        $(document).ready(function()
    {
        let var1=<?php echo $result->num_rows;?> ;
        if(!(var1>0))
        {
            $(".container").hide();
            $("#action").html("YOU NOT BALANCED THIS LINE FOR TODAY.FIRST BALANCE THE LINE.");
            $(".no").show();
        }
        else{
            $(".container").show();
            $(".no").hide();
        }
    })
    </script>
</head>
<body>
<div class="no"><p id="action"></p></div>
<div class="notes"><p id="note"></p></div>
<div class="container">
    <h2>Update Employee Hourly Production of <?php echo $gettable;?></h2>
    
    <form method="POST" onsubmit="return confirmSubmit()" action="updating.php?TABLE=<?php echo $gettable;?>">
    <div class="form-group">
        <label for="selected_hour">Select Hour to Update (1-8):</label>
        <select id="selected_hour" name="selected_hour" required>
            <option value="">Select an Hour</option>
            <option value="H1">Hour 1</option>
            <option value="H2">Hour 2</option>
            <option value="H3">Hour 3</option>
            <option value="H4">Hour 4</option>
            <option value="H5">Hour 5</option>
            <option value="H6">Hour 6</option>
            <option value="H7">Hour 7</option>
            <option value="H8">Hour 8</option>
        </select>
    </div>
<div class="datatable">
        <table id="myTable" border="1">
            <tr>
                <th>Token No</th>
                <th>Operator Name</th>
                <th>Operation Name</th>
                <th>Production  </th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                // Loop through the employees and display each one in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['TKNO'] . "<input type='hidden' name='TKNO[]' value='" . $row['TKNO'] . "' /></td>";
                    echo "<td>" . $row['EMPNAME'] . "</td>";
                    echo "<td>" . $row['OPNAME'] ;
                    echo "<td><input type='text' name='hour[]" . $row['TKNO'] . "'    id='hour" . $row['TKNO'] . "' /></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>YOU NOT BALANCED THIS LINE FOR TODAY.FIRST BALANCE THE LINE.</td></tr>";
            }
            ?>
        </table>
        <br />
        <input type="submit" class="button" value="UPDATE" />
        </div>
    </form>
    </div>
    <script>
        function hideRowsWithNullInSpecificColumn() {
            var table = document.getElementById("myTable");
            var rows = table.getElementsByTagName("tr");
            var columnToCheck = 0;
            
            for (var i = 1; i < rows.length; i++) { 
                var cells = rows[i].getElementsByTagName("td");
                
                // Check if the cell in the specified column is null or empty
                if (cells[columnToCheck] && (cells[columnToCheck].innerText.trim() === "" || cells[columnToCheck].innerText.trim().toLowerCase() === "null")) {
                    rows[i].style.display = "none"; // Hide the row
                } else {
                    rows[i].style.display = ""; // Show the row
                }
            }
        }

        // Call the function to hide rows with null or empty cells in the "Age" column
        hideRowsWithNullInSpecificColumn();
    </script>
</body>
</html>

<?php
$con->close();
?>
