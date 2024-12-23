<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}
require "conn.php";
// Check if the form is submitted
if ($_POST) {
    $TKNO=$_POST["TKNO"];
    $EMPNAME = $_POST["EMPNAME"];
    $OPNAME = $_POST["OPNAME"];
    $SKILL = $_POST["SKILL"];
    $LINE= $_POST["LINE"];
    

    // Insert query to add data to the skillmatrix table
    $sql = "INSERT INTO skillmatrix (TKNO, EMPNAME, $OPNAME) VALUES ('$TKNO', '$EMPNAME',$SKILL)";
    $sql1="inser into allemp values('$TKNO', '$EMPNAME','$LINE')";
    if(mysqli_query($con, $sql)&&mysqli_query($con, $sql1)){
        echo "Record added successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        input[type="text"], input[type="search"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Add New Employee</h2>
        <form action="add.php" method="post">
            <input type="text" name="TKNO" placeholder=" TOKEN NO" required>
            <input type="text" name="EMPNAME" placeholder="Employee Name" required>
            <input type="search" list="predefined" placeholder="Select Operation" name="OPNAME" required>
            
            <!-- Predefined list of operation names from the database -->
            <datalist id="predefined">
                <?php
                // Fetch column names or operations from the database
                $S = "SHOW COLUMNS FROM skillmatrix";
                $res = $con->query($S);

                if ($res) {
                    while ($row = $res->fetch_assoc()) {
                        echo "<option value='" . $row['Field'] . "'></option>";
                    }
                } else {
                    echo "<option value=''>Error fetching operations</option>";
                }
                ?>
            </datalist>

            <input type="number" name="SKILL" placeholder="Skill Level" required>
          <input type="text" name="LINE" placeholder=" Line"required>
            <input type="submit" value="ADD">
        </form>
    </div>

</body>
</html>
