<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');  // Redirect to login page if not logged in
    exit;
}
require "conn.php";
if($_POST)
{
    $TKNO=$_POST["TKNO"];
    $sql="delete from skillmatrix where TKNO='$TKNO'";
    $sql1="delete from allemp where TKNO='$TKNO'";
    if(mysqli_query($con,$sql)&&mysqli_query($con,$sql1))
    {
        echo' DELETED SUCCESSFULLY';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        input[type="text"], input[type="search"], input[type="number"] {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DELETE</title>
</head>
<body><h2 ALIGN="CENTER">DELETE AN OPERATOR</h2>
    <form action="delete.php" method="post" class="form-container">
        <input type="text" name="TKNO" placeholder="Enter Token No.">
        <input type="submit" value="DELETE">
    </form>
</body>
</html>