<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}
// Create a connection to the MySQL database
require "conn.php";
require "getopname.php";
// Check if the connection was successful
?>
<html lang="en">
<head>
    <title>Get SkillS of OPNAME</title>
    <style>
      
      .note{
border:1px dotted red;
font-size:medium;
margin-left:75%;
margin-bottom:20px;
background-color:skyblue;
}
  .n{
    color:orangered;
    font-size:large;
  }   
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    /* Styling for form and input fields */
    form {
        max-width: 500px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: fadeInUp 1s ease-out;
    }

    fieldset {
        border: none;
    }

    legend {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
        color: #333;
    }

    input[type="search"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.3s;
    }

    input[type="search"]:focus {
        border-color: #4CAF50;
    }

    input[type="submit"] {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        font-size: 1.1rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
        transform: scale(1.05);
    }

    input[type="submit"]:active {
        background-color: #388E3C;
        transform: scale(0.98);
    }

    /* Styling for the table */
    table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
}


table thead {
    background-color:rgba(2, 106, 176, 0.68);
    color: white;
}


table th {
    padding: 10px;
    text-align: left;
    background-color:rgba(2, 106, 176, 0.68);
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

    /* Animations */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Button Styling */
    .button {
        padding: 12px 30px;
        font-size: 16px;
        cursor: pointer;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s, transform 0.3s ease-in-out, box-shadow 0.3s ease;
        margin: 5px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: bounceIn 1s ease-in-out;
    }

    .button:hover {
        background-color: #45a049;
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .button:active {
        background-color: #388E3C;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        transform: scale(0.98);
    }

    /* Bounce In animation for buttons */
    @keyframes bounceIn {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }
        50% {
            transform: scale(1.2);
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

</head>
<body><div class="note"><p> <div class="n">Note:</div> 1= Fully Known , 0.5= Partially Known</p></div>
    <form action="getskillS.php" method="post">
        <fieldset align="center">
            <legend>GET SKILL</legend>
            <input type="search" list="predefined" placeholder="OPERATION" name="OPNAME" required>
            <datalist id="predefined">
                <?php
                // Fetch column names from the opnames table
                $S = "SELECT * FROM `opnames`";
                $res = $con->query($S);
                
                // Check if the query is successful
                if ($res) {
                    // Loop through each column and create an <option> element
                    while ($row = $res->fetch_assoc()) {
                        echo "<option value='" . $row["OP"] . "' required>".$row["OPN"]."</option>";
                        echo $row["OP"] ;
                    }
                } else {
                    echo "<option value=''>Error fetching columns</option>";
                }
                ?>
            </datalist>
           <br> <input type="submit" value="GET"></input>
        </fieldset>
    </form>
</body>
</html>
<?php

if ($_POST) {
    $OPNAME = $_POST["OPNAME"];  // Get the value of OPNAME from the form

    // SQL query to fetch TKNO, EMPNAME, and the column specified by OPNAME
    $sql = "SELECT LINE,TKNO, EMPNAME, $OPNAME FROM skillmatrix where $OPNAME!=0 order by $OPNAME DESC";

    // Execute the query
    $result = $con->query($sql);

    // Check if the query returns any rows
    if ($result->num_rows > 0) {
        // Start the table and add headers
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr><th>TKNO</th><th>EMPNAME</th><th>LINE</th><th>$op_array[$OPNAME]</th></tr>";

        // Loop through the results and display data in table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["TKNO"] . "</td><td>" . $row["EMPNAME"] . "</td><td>" .$row["LINE"]. "</td><td>" .$row[$OPNAME]. "</td></tr>";
        }

        // Close the table
        echo "</table>";
    } else {
        echo "No results found.";
    }
}
?>


