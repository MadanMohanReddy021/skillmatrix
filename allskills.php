<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}
require "conn.php";
$sql="select *from skillmatrix";
$cols="show columns from  skillmatrix";
$res=mysqli_query($con,$sql);
$colres=mysqli_query($con,$cols);
require "getopname.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Employees Skills</title>
    <style>
               input {
     width:300px;
}
.note{
border:1px dotted red;
font-size:medium;
margin-left:55%;
margin-top: -50px;
background-color:skyblue;
position: sticky;
top: 0;
}
   
  input {
     width:50%;
     position: sticky;
    top: 0;
}
  
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-family: Arial, sans-serif;
    text-align: center;
}


table thead {
    background-color:rgb(76, 87, 175);
    color: white;
    position: sticky;
    top: 40px;
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
            width: 50%;
            font-size: 1rem;
            border-radius: 5px;
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
</head>
<body>

   <h2>Skill Martix of all the Operators</h2>
    
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names and tokens no.."><div class="note"><p> Note:1= Fully Known , 0.5= Partially Known</p></div>
<!-- <button class="button">GET</button> -->
    <!-- Table -->
    <table id="myTable" border="1">
        <thead><?php
        echo"<tr>";
        echo"<th>TKNO<th>EMPNAME<th>LINE<th>SKILL";
        echo"</tr>";
        echo"</thead>";
        echo" <tbody>";
        $colres=mysqli_Query($con,$cols);
        $columns = [];
        while ($col = mysqli_fetch_assoc($colres)) {
           $columns[] = $col['Field'];
          }
          unset($columns[0]);
          unset($columns[1]);
          unset($columns[2]);
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            
            echo "<td>" . $row["TKNO"] . "</td>";
            echo "<td>" . $row["EMPNAME"] . "</td>";
            echo "<td>" . $row["LINE"] . "</td>";
            $OPNAMES_NOT0=[];
            foreach ($columns as $column) {
                if( $row[$column]>0)
                {
                    $OPNAMES_NOT0[$column] = $row[$column];
                }
            }
                echo "<td>" ;
                foreach ($OPNAMES_NOT0 as $operation => $level) {
                    echo $op_array[$operation] . ": " . $level . "<br>";
                }
                echo "</td>" ;
            
            echo "</tr>";
        }
        echo" </tbody>";
        ?>
           
      
    </table>

    <script>
              // Function to search the table
              function searchTable() {
            let input = document.getElementById("searchInput"); // Get the search input
            let filter = input.value.toUpperCase(); // Convert search term to uppercase for case-insensitive search
            let table = document.getElementById("myTable"); // Get the table
            let tr = table.getElementsByTagName("tr"); // Get all table rows (including header)

            // Loop through all rows and hide those that don't match the search term
            for (let i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                let td = tr[i].getElementsByTagName("td"); // Get all td elements in the row
                let found = false; // Flag to check if the row matches

                // Loop through each cell in the row and check if it matches the search term
                for (let j = 0; j < td.length; j++) {
                    if (td[j].innerText.toUpperCase().indexOf(filter) > -1) {
                        found = true; // If a match is found, set flag to true
                        break; // No need to check further cells in this row
                    }
                }

                // Show the row if it matches the search term, hide if it doesn't
                if (found) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }

        }
        function hideZeroColumns() {
  const table = document.getElementById('myTable');
  const row = table.rows[0]; // Get the first (and only) row
  const numCols = row.cells.length;

  // Loop through each cell in the row
  for (let i = 0; i < numCols; i++) {
    if (row.cells[i].innerText == '0') { // Check if the cell value is 0
      // Hide the column by setting the display style to 'none'
      for (let j = 0; j < table.rows.length; j++) {
        table.rows[j].cells[i].style.display = 'none';
      }
    }
  }
}


    </script>

</body>
</html>
