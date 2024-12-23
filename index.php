<?php

session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');  
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    
.dis
{
    position:fixed;
    top:0;
    left:40%;
}
img {
  position: absolute;  
  top: 10%;
  left: 0;
  width: 100%; 
  height: 90%;  
  z-index: -1; 
 border:solid blue;
}

        
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1 align="center">Skill Tracker: Auto mates the skill matrix to update based on hourly poduction</h1>
    <img src="skillmatrix.webp" alt=""><?php
    if(isset($_GET["log"]))
    {
        $log=$_GET["log"];
    
    echo" <div class='dis'>".$log."</div>";
}
    ?>
</body>
</html>