<?php
if (isset($_POST['save_changes'])) {
    // Get the submitted data
    $opnameArray = $_POST['OPNAME'];
    $tknoArray = $_POST['TKNO'];
    $empnameArray = $_POST['EMPNAME'];

    // Connect to the database
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "your_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Loop through all the data and update the database
    $stmt = $conn->prepare("UPDATE line12 SET TKNO = ?, EMPNAME = ? WHERE OPNAME = ?");
    for ($i = 0; $i < count($opnameArray); $i++) {
        $opname = $opnameArray[$i];
        $tkno = $tknoArray[$i];
        $empname = $empnameArray[$i];

        // Bind the parameters and execute the statement
        $stmt->bind_param("sss", $tkno, $empname, $opname);
        $stmt->execute();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the index page (or show a success message)
    echo "Changes saved successfully!";
    // header('Location: index.php');
}
?>
