<?php
// Database connection (modify according to your database)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "company";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if TKNO is provided in GET request
if (isset($_GET['TKNO'])) {
    $TKNO = $_GET['TKNO'];
    
    // Query to fetch EMPNAME from allemp table based on TKNO
    $sql = "SELECT EMPNAME FROM allemp WHERE TKNO = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $TKNO);
    $stmt->execute();
    $stmt->bind_result($empname);
    
    // Check if result is found
    if ($stmt->fetch()) {
        echo $empname;  // Output the EMPNAME
    } else {
        echo "No EMPNAME found";
    }
    
    $stmt->close();
}

// Close connection
$conn->close();
?>
