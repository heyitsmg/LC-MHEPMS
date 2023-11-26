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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $totalScore = $_POST['totalScore'];
        $recommendation = $_POST['recommendation'];
        $routine = $_POST['routine'];

        // Insert the data into the database
        $stmt = $link->prepare("INSERT INTO `user_scores` (`username`, `score`, `recommendation`, `routine`, `created_at`) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("siss", $username, $totalScore, $recommendation, $routine);

        if ($stmt->execute()) {
            header("Location: evaluation-result.php");
            exit();
        } else {
            header("Location: error.php");
            exit();
        }
    }
} else {
    // Handle the case where no username is found for the given ID
    echo "No username found for this user ID.";
}


// Define your JavaScript data
$dass21Data = array(
    array(
        'question' => '1. I found it hard to wind down',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '2. I was aware of dryness of my mouth',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '3. I could not seem to experience any positive feeling at all',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '4. I experienced breathing difficulty (e.g. excessively rapid breathing, breathlessness in the absence of physical exertion)',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '5. I found it difficult to work up the initiative to do things',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '6. I tended to over-react to situations',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '7. I experienced trembling (e.g. in the hands)',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '8. I felt that I was using a lot of nervous energy',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '9. I was worried about situations in which I might panic and make a fool of myself',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '10. I felt that I had nothing to look forward to ',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '11. I found myself being agitated',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '12.I found it difficult to relax',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '13. I felt down-hearted and blue',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '14. I was intolerant of anything that kept me from getting on with what I was doing',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '15. I felt i was close to panic',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '16. I was unable to become enthusiastic about anything',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '17. I felt I was not worth much as a person',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '18. I felt that I was rather touchy',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '19. I was aware of the action of my heart in the absence of physical exertion (e.g. sense of heart rate increase, heart missing a beat)',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '20. I felt scared without any good reason',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    ),
    array(
        'question' => '21. I felt that life was meaningless',
        'choices' => array(
            array('text' => 'Did not apply to me at all', 'value' => 0),
            array('text' => 'Applied to me to some degree, or some of the time', 'value' => 1),
            array('text' => 'Applied to me to a considerable degree or a good part of the time', 'value' => 2),
            array('text' => 'Applied to me very much or most of the time', 'value' => 3),
        ),
        'selectedChoice' => null,
    )
);

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Users/css/evaluation.css">
    <title>Evaluation</title>
  </head>
  <body>

  <main>

    <div class="big-wrapper light">
        <header>
            <div class="container">
                <div class="logo" onclick="proceedToHome()">
                        <img src="../image/lc.png" alt="logo"> <h3>Mental Health Matters!</h3> 
                </div>
            </div>
        </header>

            
    <center>
        <div class="container" id="evaluation">
            <div class="form">
                <h2>EVALUATION FORM</h2>
                <p id="direction">
                <strong>Direction:</strong> Please read each statement and choose which indicates how much the statement applied to you over the past week. There are no right or wrong answers. Do not spend too much time on any statement.
                </p>
                <br>
                <h3 id="question">Question Text</h3>
                    <form id="evaluationForm" action="" method="post">
                        <ul>
                            <li>
                                <input type="radio" name="answer" id="a" class="answer" value="0">
                                <label for="a" class="answer-text">Answer</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="a" class="answer" value="1">
                                <label for="b" class="answer-text">Answer</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="c" class="answer" value="2">
                                <label for="c" class="answer-text">Answer</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="d" class="answer" value="3">
                                <label for="d" class="answer-text">Answer</label>
                            </li>
                        </ul>
                        <br>
                        <button type="submit" id="submit">Submit</button>


                        <?php foreach ($dass21Data as $index => $question): ?>
                            <input type="hidden" name="dass21Data[<?= $index ?>][question]" value="<?= $question['question'] ?>">
                            <?php foreach ($question['choices'] as $choiceIndex => $choice): ?>
                                <input type="hidden" name="dass21Data[<?= $index ?>][choices][<?= $choiceIndex ?>][text]" value="<?= $choice['text'] ?>">
                                <input type="hidden" name="dass21Data[<?= $index ?>][choices][<?= $choiceIndex ?>][value]" value="<?= $choice['value'] ?>">
                            <?php endforeach; ?>
                            <input type="hidden" name="dass21Data[<?= $index ?>][selectedChoice]" value="<?= $question['selectedChoice'] ?>">
                        <?php endforeach; ?>
                    </form>
            </div>
        </div>
    </div>
</main>

<script>
const dass21Data = <?php echo json_encode($dass21Data); ?>;
let currentQuestionIndex = 0;
let recommendation, routine;

document.addEventListener('DOMContentLoaded', function () {
    loadQuestion();

    document.getElementById('submit').addEventListener('click', function (e) {
        e.preventDefault();

        if (is21stQuestion()) {
            proceedToRecommendation();
        } else {
            saveAnswer();
            currentQuestionIndex++;
            loadQuestion();
        }
    });
});

function is21stQuestion() {
    return currentQuestionIndex === dass21Data.length - 1;
}

function proceedToHome() {
    window.location.href = 'homepage.php';
}

function loadQuestion() {
    const currentQuestion = dass21Data[currentQuestionIndex];
    document.getElementById('question').textContent = currentQuestion.question;

    const answerElements = document.querySelectorAll('.answer');
    for (let i = 0; i < answerElements.length; i++) {
        answerElements[i].nextElementSibling.textContent = currentQuestion.choices[i].text;
    }
}

function saveAnswer() {
    const selectedChoice = document.querySelector('input[name="answer"]:checked');
    if (selectedChoice) {
        const value = selectedChoice.value;
        dass21Data[currentQuestionIndex].selectedChoice = value;

        // Log the selected choice
        console.log(`Question ${currentQuestionIndex + 1}: Selected Choice - ${value}`);
    }
}

function calculateTotalScore() {
    let totalScore = 0;
    for (const question of dass21Data) {
        const selectedChoice = question.selectedChoice;
        if (selectedChoice !== null) {
            totalScore += parseInt(selectedChoice, 10);
        }
    }
    console.log(`Total Score: ${totalScore}`);
    return totalScore;
}




function proceedToRecommendation() {
    const totalScore = calculateTotalScore();

    console.log('Total Score:', totalScore);

    if (totalScore >= 0 && totalScore <= 9) {
        recommendation = "Normal";
        routine = "Congratulations on maintaining a healthy lifestyle! Continue with a well-rounded routine including:\n" +
            "- 30 minutes of brisk walking or jogging\n" +
            "- 7-9 hours of quality sleep\n" +
            "- Regular hydration\n" +
            "- Balanced diet\n" +
            "- Strength training 2-3 times a week\n" +
            "- Flexibility exercises like yoga or stretching";
    } else if (totalScore >= 10 && totalScore <= 13) {
        recommendation = "Mild";
        routine = "Focus on increasing your activity level. Consider:\n" +
            "- 30 minutes of brisk walking, light jogging, or cycling\n" +
            "- 7-9 hours of quality sleep\n" +
            "- 20-30 minute naps for a quick energy boost\n" +
            "- Bodyweight exercises like squats and push-ups\n" +
            "- Include fruits, vegetables, and whole grains in your diet";
    } else if (totalScore >= 14 && totalScore <= 20) {
        recommendation = "Moderate";
        routine = "Increase the intensity of your workouts. Include:\n" +
            "- 45 minutes to 1 hour of running, cycling, or high-intensity interval training (HIIT)\n" +
            "- Adequate rest and recovery between sessions\n" +
            "- Balanced nutrition with a focus on protein for muscle recovery\n" +
            "- Stay hydrated\n" +
            "- Consider consulting with a fitness professional for personalized guidance";
    } else {
        recommendation = "Severe";
        routine = "It's essential to seek professional help. Consider reaching out to a mental health professional, counselor, or therapist to discuss your feelings and experiences in more detail. They can provide personalized support and guidance tailored to your specific needs.";
    }

    // Console logs for debugging
    console.log('Recommendation:', recommendation);
    console.log('Routine:', routine);

    document.getElementById('evaluationForm').innerHTML += `
        <input type="hidden" name="totalScore" value="${totalScore}">
        <input type="hidden" name="recommendation" value="${recommendation}">
        <input type="hidden" name="routine" value="${routine}">
    `;

    document.getElementById('submit').click();

    // Use AJAX to send data to the server
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'result-evaluation.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        
    };
    xhr.send('totalScore=' + totalScore + '&recommendation=' + recommendation + '&routine=' + routine);
}
</script>


</body>
</html>