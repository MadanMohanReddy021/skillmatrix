<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}
require "conn.php";
$table = isset($_POST['table']) ? $_POST['table'] : '';
$date=isset($_POST['date']) ? $_POST['date'] :'';


$available_tables = ['line12', 'line3', 'line4', 'line5', 'line6'];


function displayTable($con, $table,$date) {
    $sql = "SELECT * FROM $table where date='$date'";  
    $result = $con->query($sql);

   
    if ($result->num_rows > 0) {
      
        $columns = $result->fetch_fields();
        
      
        echo "<table id='myTable' border='1'><tr>";
        foreach ($columns as $column) {
            echo "<th>" . $column->name . "</th>";  
        }
        echo "</tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . $value . "</td>"; 
            }
            echo "</tr>";
        }

        
        echo "</table>";
    } else {
        echo "No data found in the table.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Table to Display</title>
    <style>
                   input {
     width:300px;
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
input{
    width: 39%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 20px;
            align-items: center;
            margin-left: 30%;
}
input:hover{
     border-color: #4CAF50

}
select{
            width: 40%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 20px;
            align-items: center;
            margin-left: 30%;
        }
        select:hover
        {
            border-color: #4CAF50

        }
table {
    margin-top: 20px;
}
    </style>
    <script>
        function hideRowsWithNullInSpecificColumn() {
            var table = document.getElementById("myTable");
            var rows = table.querySelectorAll("tr");
            var columnToCheck = 0;
            
            for (var i = 1; i < rows.length; i++) { 
                var cells = rows[i].getElementsByTagName("td");
                if (cells[columnToCheck] && (cells[columnToCheck].innerText.trim() === "" || cells[columnToCheck].innerText.trim().toLowerCase() === "null")) {
                    rows[i].style.display = "none"; 
                } else {
                    rows[i].style.display = ""; 
                }
            }
        }


        
    </script>
</head>
<body>

<h2 ALIGN="CENTER">HOURLY PRODUCTION</h2>

<form method="POST" action="">
    
    <select name="table" id="table" onchange="this.form.submit()">
        <option value="">- - - - - - - - - - - - - - - -Select A LINE- - - - - - - - - - - - - - - -</option>
        <?php
      $lines=["line1&2","line3","line4","line5","line6"];
      $i=0;
        foreach ($available_tables as $available_table) {
            echo "<option value='$available_table'" . ($table == $available_table ? " selected" : "") . ">".$lines[$i++]."</option>";
        }
        ?>
    </select><br>
    <input type="date" name="date" id=""onchange="this.form.submit()"/>
</form>

<?php

if ($table != '') {
    echo "<h3>Displaying data from $table</h3>";
    displayTable($con, $table,$date);  
    
    echo"<script> hideRowsWithNullInSpecificColumn();</script>";
}

?>

</body>
</html>


