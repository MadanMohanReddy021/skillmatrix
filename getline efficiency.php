<?php
require "conn.php";
$sql = "SELECT line, eff FROM lineeff";


$result = $con->query($sql);
if ($result->num_rows > 0) {
   echo"<h2>Line Wise Efficiency</h2>";
    echo "<table border='1'>
            <tr>
                <th>Line</th> 
                <th>Efficeincy</th>    
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['line'] . "</td> 
                <td>" . $row['eff'] . "</td>    
              </tr>";
    }
    echo "</table>";
} else {
   
    echo "No records found.";
}


$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
}


table thead {
    background-color: #4CAF50;
    color: white;
}


table th {
    padding: 10px;
    text-align: left;
}


table tr:nth-child(even) {
    background-color: #f2f2f2;
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
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 2px solid #BFE2FF; /* Skyblue border */
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
            padding: 10px;
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
</head>
<body>
    
</body>
</html>