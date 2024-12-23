<?php
ini_set('display_errors', 'Off');   // Disable displaying errors in the browser
error_reporting(E_ALL & ~E_WARNING); // Disable warnings, but keep other errors

if (isset($_POST['save_changes'])) {
   require "conn.php";
    $opnameArray = $_POST['OPNAME'];
    $tknoArray = $_POST['TKNO'];
    $empnameArray = $_POST['EMPNAME'];
    $GETTABLE=$_GET["TABLE"];
    $target=(int)$_POST["target"];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "company";
    $htarget=(int)$target/8;
    

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $stmt = $con->prepare("INSERT INTO lineeff(line, target, htarget) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $GETTABLE, $target, $htarget); 
    $stmt->execute();
    for ($i = 0; $i < count($opnameArray); $i++) {
        $opname = $opnameArray[$i];
        $tkno = $tknoArray[$i];
        $getemp=mysqli_query($con,"select EMPNAME from allemp where TKNO='$tkno'");
        $RES=mysqli_fetch_array($getemp);
        
         $empname = $RES["EMPNAME"];;
         $sql="insert into  $GETTABLE(TKNO,EMPNAME,OPNAME,date) values('$tkno','$empname','$opname',CURDATE()) ";
         mysqli_query($con, $sql);
        
    }
    $con->close();
    echo "Changes saved successfully!";
}
?>
