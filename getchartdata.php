<?php
require "conn.php";

$line = isset($_GET['line']) ? $_GET['line'] : '';
if ($line) {
    $sql = "SELECT target, completed, date FROM lineeff WHERE  line = ? and date >= CURDATE() - INTERVAL 1 MONTH ORDER BY date";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $line); 
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    
    $sql = "SELECT target, completed, date FROM lineeff WHERE date >= CURDATE() - INTERVAL 1 MONTH ORDER BY date limit 6 ";
    $result = $con->query($sql);
}

$data = array();


if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

// Set the header to return JSON
header('Content-Type: application/json');

// Return the data as a JSON response
echo json_encode($data);

// Close the connection
$con->close();
?>
