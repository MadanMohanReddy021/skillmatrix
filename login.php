
<?php
session_start();
require "conn.php";
if($_POST){
    $user=$_POST["username"];
    $pass=$_POST["password"];
    $sql="select *  from admin where ID='$user' AND PASS='$pass'";
    $result=mysqli_query($con,$sql);
    if(mysqli_num_rows($result)> 0){
        $_SESSION['admin']=1;
        header("location:index.php?log=Login Sucessfull");
    }
    else{
        header('location:index.php?log=Invalid userId or Password');
    }
}
else{

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: fadeIn 1s ease-out;
        }

        .login-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            box-shadow:0px 10px 20px #28a745;
            max-width: 400px;
            animation: slideIn 0.8s ease-out;
        }

        .login-form h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            animation: fadeIn 1s ease-out;
        }

        .input-group {
            margin-bottom: 15px;
            opacity: 0;
            animation: fadeInUp 1s forwards;
        }

        .input-group:nth-child(1) {
            animation-delay: 0.2s;
        }

        .input-group:nth-child(2) {
            animation-delay: 0.4s;
        }

        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            border-color: #007BFF;
            outline: none;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #28a745; /* Green color */
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            opacity: 0;
            animation: fadeInUp 1s forwards;
            animation-delay: 0.6s;
            border-radius: 20px;
        }

        .login-button:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .footer {
            text-align: center;
            margin-top: 15px;
        }

        .footer a {
            color: #007BFF;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Keyframe Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            0% {
                transform: translateY(20px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <form class="login-form" action="login.php" method="post">
        <h2>Login</h2>
        
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
<br>
        <button type="submit" class="login-button">Login</button>

    </form>
</div>

</body>
</html>
<?php } ?>