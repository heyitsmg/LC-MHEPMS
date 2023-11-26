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

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <title>Evaluation Notice</title>

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
    margin-top: 0;
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
  width: 150px; /* Adjusted width */
  height: 40px;
  cursor: pointer;
  font-size: 15px; 
  font-family: inherit;
  padding: 0.3rem; 
  margin-bottom: 3px; 
  margin-left: auto;
  margin-right: 0; 
}

/* Center the text within the button */
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

  <main>
    <div class="big-wrapper light">
        <header>
            <div class="container">
                <div class="logo" onclick="proceedToHome()">
                        <img src="../image/lc.png"  alt="logo"><h3>Mental Health Matters!</h3> 
                </div>
            </div>
        </header>
<center><br><br>
        <div class="container" id="evaluation">
            <div class="form">
                <h2>Important Notice</h2>
                <center><p>
                The Lemery Colleges Mental Health Evaluation and Progress Monitoring System is a platform dedicated to assessing and monitoring the students' mental health. Before proceeding, please read the following information carefully:
                </p>
                <br>
                <p>
                    <strong>Confidentiality and Security:</strong> The system places a high priority on safeguarding the privacy of participants' data. All information gathered during the evaluation will be treated as confidential and securely stored. This commitment to confidentiality aims to create a safe space for individuals to openly share their mental health experiences without fear of unauthorized access or disclosure.
                </p>
                <br>
                <p>
                    <strong>Notice:</strong> The evaluation primarily utilizes the DASS-21, a tool designed to measure the levels of depression, anxiety, and stress. It's essential to understand that the DASS-21 doesn't provide specific diagnostic categories but rather evaluates variations in the degree of these mental health indicators. This distinction is important, as the assessment focuses on assessing the severity of symptoms rather than assigning specific diagnoses.
                </p>
                <br>
                <p>
                <strong>Acknowledgement: </strong>Hereby clicking Proceed, you agree to the terms outlined in the provided information as part of your participation in the Lemery Colleges Mental Health Evaluation and Progress Monitoring System. This agreement establishes a mutual understanding between you and the system, ensuring that you are fully aware of the confidentiality measures in place and the nature of the assessment tool being used. This commitment reflects a responsible and ethical approach to mental health assessment, prioritizing your well-being and privacy throughout the evaluation process.
                </p>
                <br>
                <button id="submit" onclick="proceedToEval()">Proceed</button>
            </div>
        </div>
    </div>
</main>

<script>
        function proceedToEval() {
            window.location.href = 'evaluation.php';
        }

        function proceedToHome() {
            window.location.href = 'homepage.php';
        }
</script>

  </body>
</html>