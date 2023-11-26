<?php
session_start();

// Include config.php to get database credentials
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user ID from the session
$user_id = $_SESSION['id'];
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- My CSS -->
    <link rel="stylesheet" href="../Users/css/homepage.css">
    <title>Homepage</title>


    
  </head>
  <body>
    <main>
      <div class="big-wrapper light">

        <header>
          <div class="container">

            <div class="logo">
              <img src="../image/lc.png" alt="Logo">
              <h3>Mental Health Matters!</h3>
            </div>

            <div class="links">
              <ul>
                <li><a href="evaluation-notice.php">Evaluation Form</a></li>
                <li><a href="forum.php">Community Forum</a></li>
                <li><a href="my-dashboard.php">My Account</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
            </div>

            <div class="overlay"></div>

            <div class="hamburger-menu">
              <div class="bar"></div>
            </div>
          </div>
        </header>

        <div class="showcase-area">
          <div class="container">
            <div class="left">
              <div class="big-title">
                <br>
                <h1>"One Step at a Time, One Mind at a Time."</h1>
                <p class="text">
                  Lemery Colleges Mental  Evaluation and Progress Monitoring System
                </p>
              </div>
              
              <div class="cta">
                <a href="evaluation-notice.php" class="btn">Get started</a>
              </div>
            </div>

            <div class="right">
              <img src="../image/home4.png" class="person" />
            </div>
          </div>
        </div>

      </div>
    </main>

  </body>
</html>
