<?php

include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $totalScore = $_POST['score'];
    $routine = $_POST['routine'];
    $user_id = $_POST['user_id'];

    if (!$link) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    $sql = "INSERT INTO user_scores (user_id, score, routine, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = mysqli_prepare($link, $sql);

    mysqli_stmt_bind_param($stmt, "isd", $user_id, $totalScore, $routine);

    if (mysqli_stmt_execute($stmt)) {
        echo 'Scores saved successfully.';
    } else {
        echo 'Error saving scores: ' . mysqli_error($link);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
}
?>
