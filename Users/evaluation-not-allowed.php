<?php

require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Pending</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            background: url("../image/background2.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            color: #fff;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 150rem;
            height: 35rem;
            background: transparent;
            border-radius: 20px;
            box-shadow: 3px 10px 12px #145DA0;
            backdrop-filter: blur(10px) brightness(75%);
            text-align: center;
            padding: 20px;
        }

        h2 {
            font-size: 40px;
            margin-bottom: 10px;
        }

        p {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .logologin {
            height: 12rem;
            width: 12rem;
            margin-bottom: 20px;
            margin-top: 4rem;
        }

        .back-to-login-btn {
            background-color: #1a1740;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 15px;
        }

        .back-to-login-btn:hover {
            background-color: #4FC0D0;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <center><br><br>
        <div class="container">
            <img src="../image/lc.png" class="logologin" alt="Logo">
            <h2>Mental Health Evaluation and Progress Monitoring System</h2>
            <h3>Evaluation Not Allowed</h3>
            <p>Sorry, you are not allowed to take the evaluation at this time. Please check back later.</p>
            <a href="homepage.php" class="back-to-login-btn">Back to Home</a>
        </div>
    </center>
</body>
</html>
