<?php
session_start();

include('config.php');

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment_id = $_POST['comment_id'];
    $reply_content = $_POST['reply_content'];

    $user_id = $_SESSION['id'];

    $usernameQuery = "SELECT username FROM user WHERE id = ?";
    $stmt = mysqli_prepare($link, $usernameQuery);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the statement
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Error executing username query");
        die("Error retrieving username.");
    }

    // Get the result
    $usernameResult = mysqli_stmt_get_result($stmt);

    // Fetch the result into an associative array
    $usernameRow = mysqli_fetch_assoc($usernameResult);

    if (!$usernameRow) {
        die("No user found for ID: $user_id");
    }

    $username = $usernameRow['username'];

    // Insert the reply into the database using a prepared statement
    $insertReplyQuery = "INSERT INTO comment_replies (comment_id, username, reply_content, reply_date) 
                        VALUES (?, ?, ?, ?)";

    $stmtInsertReply = mysqli_prepare($link, $insertReplyQuery);

    // Bind parameters
    $reply_date = date("Y-m-d H:i:s"); // Format date and time
    mysqli_stmt_bind_param($stmtInsertReply, "isss", $comment_id, $username, $reply_content, $reply_date);

    // Execute the statement
    $insertReplyResult = mysqli_stmt_execute($stmtInsertReply);

    // Check for query execution success
    if (!$insertReplyResult) {
        error_log("Error in SQL query: " . mysqli_error($link));
        die("Error in submitting the reply. Please check the error log for more details.");
    }

    // Check the number of affected rows
    if (mysqli_stmt_affected_rows($stmtInsertReply) > 0) {
        // Redirect back to the post view after successful reply submission
        header("Location: forum-viewpost.php?blog_id=$comment_id");
        exit();
    } else {
        error_log("No rows affected by the insert query");
        die("Error in submitting the reply. No rows affected.");
    }



    // Redirect back to the post view after successful reply submission
    header("Location: forum-viewpost.php?blog_id=$blog_id");
    exit();
} else {
    // Redirect to the forum feed if the form was not submitted correctly
    header("Location: forum.php");
    exit();
}
?>
