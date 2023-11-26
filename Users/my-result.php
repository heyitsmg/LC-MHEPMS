<?php
session_start();

include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php"); 
    exit();
}

// Fetch user ID from the session
$user_id = $_SESSION['id'];

// Fetch username from the user table
$query = "SELECT `username` FROM `user` WHERE `id` = ?";
$stmt = $link->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username);

// Fetch the username
if ($stmt->fetch()) {
    // Use the fetched username for the user_scores table
    $stmt->close();

    $sql = "SELECT us.score_id, u.username, us.score, us.recommendation, us.routine, us.created_at
            FROM user_scores us
            JOIN user u ON u.username = us.username
            WHERE u.username = ?";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Check for query execution success
    if (!$result) {
        die("Error in SQL query: " . mysqli_error($link));
    }
} else {
    // Handle the case where no username is found for the given ID
    echo "No username found for this user ID.";
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <title>My Evaluation Records</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');

.light {
    --mainColor: #64bcf4;
    --hoverColor: #5bacdf;
    --backgroundColor: #f1f8fc;
    --lightOne: #919191;
    --lightTwo: #aaa;
  }
  
  *,
  *::before,
  *::after {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }
  
  body {
    font-family: "Poppins", sans-serif;
  }
  
  .stop-scrolling {
    height: 100%;
    overflow: hidden;
  }
  
  
  
  a {
    text-decoration: none;
  }
  
  .big-wrapper {
    position: relative;
    padding: 0rem 0 3rem;
    width: 100%;
    min-height: 100vh;
    overflow: hidden;
    background-color: var(--backgroundColor);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  
  .container {
    position: relative;
    width: 100%;
    margin: 0 auto;
    margin-top: 2rem;
    padding: 0 3rem;
    z-index: 10;
  }
  
  header {
    position: relative;
    z-index: 70;
    position: fixed;
    background-color: var(--backgroundColor);
    width: 100%;
  }
  
  header .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .overlay {
    display: none;
  }
  
  .logo {
    display: flex;
    align-items: center;
    cursor: pointer;
  
  }
  
  .logo img {
    width: 40px;
    margin-right: 0.6rem;
    margin-top: -1.09rem;
  }
  
  .logo h3 {
    color: var(--darkTwo);
    font-size: 1.55rem;
    line-height: 1.2;
    font-weight: 700;
    margin-top: -1.09rem;
  }

  
  .container .form {
    border-radius: 10px;
    box-shadow: 0 0 20px 3px rgba(100, 100, 100, 0.1);
    width: 1200px; 
    overflow: hidden;
    margin-top: 5rem;
    padding-bottom: 1rem;
    padding-top: 3rem;
    padding-left: 4rem;
    padding-right: 4rem;
}

.form {
    align-content: center;
    text-align: justify;
    background-color: white;
}

h2 {
    padding: 0;
    text-align: center;
    margin: 0;
    font-size: 34px; 
    margin-top: -2rem;
    margin-bottom: 1rem;
}

p {
    text-align: justify;
    margin-bottom: 5px;
}

button {
  border-radius: 10px;
  background-color: #03cae4;
  color: #fff;
  border: none;
  display: block;
  width: 150px; 
  height: 40px;
  cursor: pointer;
  font-size: 15px; 
  font-family: inherit;
  padding: 0.3rem; 
  margin-bottom: 3px; 
  margin-left: auto;
  margin-right: 0; 
}


button span {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
}


button:hover {
    background-color: #04adc4;
}

button:focus {
    outline: none;
    background-color: #44b927;
}
</style>

  </head>
  <body>

  <?php include 'sidebar.php'; ?>

<!-- CONTENT -->
<section id="content">
    <!-- MAIN -->
    <main>
        <div class="container" id="evaluation">
            <div class="form">
                <h2>Evaluation Results</h2>

                <?php
                // Check if there are evaluation records
                if (mysqli_num_rows($result) > 0) {
                    // Loop through the records and display them
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<p>Total Score: " . htmlspecialchars($row['score']) . "</p>";
                      echo "<p>Assessment Result: " . htmlspecialchars($row['recommendation']) . "</p>";                  
                      echo "<p>Routine: " . htmlspecialchars($row['routine']) . "</p>";
                      echo "<p><small>Date Assessed: " . htmlspecialchars($row['created_at']) . "</small></p>";
                      echo "<hr>";
                    }
                } else {
                    echo "<p>No evaluation records found for the user.</p>";
                }
                ?>
            </div>
        </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script>
    function proceedToHome() {
        window.location.href = 'homepage.php';
    }
</script>

</body>
</html>