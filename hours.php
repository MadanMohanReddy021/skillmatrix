<?php
// Database connection
$servername = "localhost";
$username = "root"; // your username
$password = ""; // your password
$dbname = "company"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission to update hours
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the selected hour and value
    $selected_hour = $_POST['hour']; // selected hour (h1 to h8)
    $hour_value = $_POST['h_value']; // updated value for the selected hour
    $tkno = $_POST['TKNO']; // We need TKNO to identify the record

    // Update query
    if (is_numeric($hour_value)) {
        $updateQuery = "UPDATE hours SET $selected_hour = '$hour_value' WHERE TKNO = '$tkno'";
        if ($conn->query($updateQuery) === TRUE) {
            echo "Record updated successfully for $selected_hour.<br>";
        } else {
            echo "Error updating record: " . $conn->error . "<br>";
        }
    } else {
        echo "Please enter a valid numeric value for $selected_hour.<br>";
    }
}

// Fetch data from the database
$sql = "SELECT TKNO, EMPNAME, OPNAME, h1, h2, h3, h4, h5, h6, h7, h8 FROM hours";
$result = $conn->query($sql);

// Check if we have any results
if ($result->num_rows > 0) {
    // Output data of each row
    echo "<form method='POST'>";
    
    // Dropdown for selecting the hour (h1 to h8)
    echo "<label for='hour'>Select Hour:</label>
          <select name='hour' id='hour' onchange='showInputField()'>
              <option value='h1'>h1</option>
              <option value='h2'>h2</option>
              <option value='h3'>h3</option>
              <option value='h4'>h4</option>
              <option value='h5'>h5</option>
              <option value='h6'>h6</option>
              <option value='h7'>h7</option>
              <option value='h8'>h8</option>
          </select><br><br>";

    echo "<table border='1'>";
    echo "<tr><th>TKNO</th><th>EMPNAME</th><th>OPNAME</th><th>Selected Hour Value</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><input type='text' name='TKNO' value='" . $row['TKNO'] . "' readonly></td>";
        echo "<td>" . $row['EMPNAME'] . "</td>";
        echo "<td>" . $row['OPNAME'] . "</td>";

        // Display only the input field for the selected hour (h1 to h8)
        echo "<td><input type='number' name='h_value' id='hour_value'></td>";
        
        echo "</tr>";
    }

    echo "</table>";
    echo "<input type='submit' value='Update Hours'>";
    echo "</form>";
} else {
    echo "No records found.";
}

$conn->close();
?>

<script>
// JavaScript to update the input field based on selected hour
function showInputField() {
    var selectedHour = document.getElementById("hour").value; // Get selected hour (h1 to h8)
    
    // Get all rows in the table
    var rows = document.querySelectorAll('tr');
    
    // Loop through all rows and update the input field for each row based on the selected hour
    rows.forEach(function(row) {
        var hourValueField = row.querySelector('[name="h_value"]'); // Find the hour value input field in the row
        if (hourValueField) {
            // Get the value of the selected hour and update the input field for that specific hour
            var currentHourValue = row.querySelector('[name="h_value_' + selectedHour.substring(1) + '"]').value;
            // Set the value of the selected hour field
            hourValueField.value = currentHourValue;
        }
    });
}
</script>
