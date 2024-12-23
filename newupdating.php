<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";      // Replace with your database password
$dbname = "company"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch employee data from the database
$sql = "SELECT TKNO,EMPNAME,OPNAME FROM hours";
$result = $conn->query($sql);

// Query to get the column names from the 'parts' table (used for operation names)
$operation_sql = "SHOW COLUMNS FROM skillmatrix";
$operation_res = $conn->query($operation_sql);

// Prepare the list of operation names for the datalist
$operation_names = [];
while ($operation_row = $operation_res->fetch_assoc()) {
    $operation_names[] = $operation_row["Field"];
}

// Update employee data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the selected hour from the dropdown
    $selected_hour = $_POST['selected_hour'];

    // Loop through each employee's data to update
    foreach ($_POST['TKNO'] as $key => $TKNO) {
        // Get the updated value for the selected hour
        $updated_hour_value =(int) $_POST["hour"][$key];

        // Get the updated operation name for the employee (user input)
        $updated_operation_name = $_POST['operation'][$key];

        // Get th
        $current_operation_sql = "SELECT EMPNAME, smv FROM hours WHERE TKNO = ?";
        $current_operation_stmt = $conn->prepare($current_operation_sql);
        $current_operation_stmt->bind_param("s", $TKNO);
        $current_operation_stmt->execute();
        $current_operation_result = $current_operation_stmt->get_result();
        $current_operation_row = $current_operation_result->fetch_assoc();
        $current_operation_name = $current_operation_row['EMPNAME'];
        $smv = $current_operation_row['smv'];  // Assuming 'smv' exists in the 'hours' table

        // First update the selected hour value
        $update_sql = $conn->prepare("UPDATE hours SET $selected_hour = ? , OPNAME= ? WHERE TKNO = ?");
        $update_sql->bind_param('iss', $updated_hour_value, $updated_operation_name, $TKNO);

        if ($update_sql->execute()) {
            // echo "Updated $selected_hour successfully for Token No: $TKNO <br />";
        } else {
            echo "Error updating $selected_hour for Token No: $TKNO: " . $conn->error . "<br />";
        }
        
        // Check if the selected hour is h8 (for calculating total, efficiency, skill)
        if ($selected_hour === 'h8') {
            // Calculate the total of all hours (h1 to h8)
            $hour_sql="select h1,h2,h3,h4,h5,h6,h7,h8 from hours where TKNO= '$TKNO'";
        $hour_res=mysqli_query($conn, $hour_sql);
            $total = 0;
           
            while( $hour_row = mysqli_fetch_assoc($hour_res )  ) {
                for( $i= 1; $i<9; $i++ )
                $total +=(int)$hour_row['h' . $i];
                  // Sum all the hours
            }

            // Calculate efficiency (eff)
            
            $efficiency = round((($total*$smv)/465)*100);

            // Calculate skill grade based on efficiency
            $skill_grade = 0;
            if ($efficiency >= 0 && $efficiency <= 20) {
                $skill_grade = 0;
            } elseif ($efficiency > 20 && $efficiency <= 40) {
                $skill_grade = 1;
            } elseif ($efficiency > 40 && $efficiency <= 60) {
                $skill_grade = 2;
            } elseif ($efficiency > 60 && $efficiency <= 80) {
                $skill_grade = 3;
            } elseif ($efficiency > 80) {
                $skill_grade = 4;
            }

            // Now, update the table with total, efficiency, and skill grade
            $update_sql = $conn->prepare("UPDATE hours SET total = ?, eff = ?, skill = ? WHERE TKNO = ?");
            $update_sql->bind_param('iiis', $total, $efficiency, $skill_grade, $TKNO);
            if ($update_sql->execute()) {
                // echo "Total, Efficiency, and Skill updated successfully for Token No: $TKNO <br />";
            } else {
                echo "Error updating total, efficiency, and skill for Token No: $TKNO: " . $conn->error . "<br />";
            }
            header("Location:trigger.php");
        }
    }

    // Refresh the page to reflect the updated data
   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee Hours</title>
    
    <link rel="stylesheet" href="hours.css">
</head>
<body>
   <div > <h2 >Update Employee Hourly production</h2>
    
    <!-- Hour selection field at the top -->
    <form method="POST" action="">
        <label for="selected_hour">Select Hour to Update (1-8): </label>
        <select id="selected_hour" name="selected_hour" required>
            <option value="">NONE</option>
            <option value="h1">Hour 1</option>
            <option value="h2">Hour 2</option>
            <option value="h3">Hour 3</option>
            <option value="h4">Hour 4</option>
            <option value="h5">Hour 5</option>
            <option value="h6">Hour 6</option>
            <option value="h7">Hour 7</option>
            <option value="h8">Hour 8</option>
        </select>
        <br />
        <br /></div>

        <table border="1">
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

                    // Create a searchable input for operation names
                    echo "<td><input type='text' name='operation[]". $row['TKNO'] ." ' list='operation_list_" . $row['TKNO'] . "' value='" . $row['OPNAME'] . "' />";
                    echo "<datalist id='operation_list_" . $row['TKNO'] . "'>";
                    foreach ($operation_names as $operation_name) {
                        echo "<option value='" . $operation_name . "'>";
                    }
                    echo "</datalist></td>";

                    
                   
                        echo "<td><input type='text' name='hour[]" . $row['TKNO'] . "'    id='hour" . $row['TKNO'] . "' /></td>";
                    

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No records found</td></tr>";
            }
            ?>
        </table>
        <br />
        <input type="submit" class="button" value="UPDATE" />
    </form>


</body>
</html>

<?php
$conn->close();
?>
