<?php
$con=new mysqli("localhost","root","","company");
$sql="select *from skillmatrix";
$cols="show columns from skillmatrix";
$res=mysqli_query($con,$sql);
$colres=mysqli_query($con,$cols);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Search</title>
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
/* .button {
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
} */
    </style>
</head>
<body>

    <h2>Table with Search</h2>

    <!-- Search Box -->
    <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Search for names and tokens no..">
<button onClick="hideZeroColumns()">GET</button>
    <!-- Table -->
    <table id="myTable" border="1">
        <thead><?php
        echo"<tr>";
        while($columns=mysqli_fetch_assoc($colres))
        {
            echo"<th>".$columns["Field"]."</th>";
        }
        echo"</tr>";
        echo"</thead>";
        echo" <tbody>";
        $colres=mysqli_Query($con,$cols);
        $columns = [];
        while ($col = mysqli_fetch_assoc($colres)) {
           $columns[] = $col['Field'];
          }
          while ($row = mysqli_fetch_assoc($res)) {
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<td>" . $row[$column] . "</td>";
            }
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
