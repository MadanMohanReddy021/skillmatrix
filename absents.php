<?php
require "conn.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $absent = $_POST['absent'];
    $replacement = $_POST['replacement']; 
    $table = $_POST['line'];

    $absentArray = explode(",", $absent);
    $replacementArray = explode(",", $replacement);

    $absentArray = array_map('trim', $absentArray);
    $replacementArray = array_map('trim', $replacementArray);
    $sql="insert into $table (TKNO,EMPNAME,OPNAME,LINE)select *from allemp where LINE=$table";
    mysqli_query($con, $sql);

    // foreach ($absentArray as $TKNO) {
    //    $delete=" DELETE FROM $table where   TKNO='$TKNO'";
    //    mysqli_query($con, $delete);
    // }
    
    // foreach ($replacementArray as $item) {
    //     $insert="insert into $table (TKNO,EMPNAME,OPNAME,LINE)select *from allemp where TKNO='$TKNO' ";
    // }
    // echo "</ul>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Multiple Inputs in Two Fields</title>  <style>
     body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 40px 80px rgba(100, 226, 111, 0.644);
            max-width: 500px;
            margin: auto;
        }

        input[type="text"], input[type="search"], input[type="number"] {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 20px;
        }
        select{
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 20px;
            align-items: center;
        }
        option{
            margin-left:100px;
        }
        input:hover
        {
            border-color: #4CAF50

        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 20px;
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
</head>
<body>

  <h2 align="center">ENTER ABSENT EMPLOYEES TOKEN NO. AND TOKEN NO. OF REPLACED EMPLOYEES</h2>
  <form action="absents.php" class="form-container"method="POST">
    <select name="line" id="">
    <option value="">--SELECT LINE--</option>
        <option value="line12">LINE1</option>
        <option value="line12">LINE2</option>
        <option value="line3">LINE3</option>
        <option value="line4">LINE4</option>
        <option value="line5">LINE5</option>
        <option value="line6">LINE6</option>
        <option value="line7">line7</option>
        <option value="parts12">LINE5</option>
        <option value="parts34">LINE6</option>
        <option value="parts56">line7</option>
    </select>
    <br><br>
    <label for="absent">Absent (separate with commas):</label><br>
    <input type="text" id="absent" name="absent" placeholder="token no.  of absents.separated by commas"><br><br>

    <label for="replacement">Replacement (separate with commas):</label><br>
    <input type="text" id="replacement" name="replacement" placeholder="token no.  of replacement.separated by commas"><br><br>

    <input type="submit"></input>
  </form>

</body>
</html>