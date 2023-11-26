<?php
session_start();

include('config.php');

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['blog_id'], $_POST['comment_content'])) {

    $blog_id = mysqli_real_escape_string($link, $_POST['blog_id']);
    $comment_content = mysqli_real_escape_string($link, $_POST['comment_content']);

    // Get the user information
    $user_id = $_SESSION['id'];

    // Fetch username based on user ID using a prepared statement
    $usernameQuery = "SELECT username FROM user WHERE id = ?";
    $stmt = mysqli_prepare($link, $usernameQuery);

    // Bind the parameter
    mysqli_stmt_bind_param($stmt, "i", $user_id);

    // Execute the statement
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Error executing username query: " . mysqli_stmt_error($stmt));
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

    // Insert the comment into the database using a prepared statement
    $insertCommentQuery = "INSERT INTO comments (blog_id, username, comment_content, comment_date) 
                            VALUES (?, ?, ?, NOW())";

    $stmtInsertComment = mysqli_prepare($link, $insertCommentQuery);

    // Bind parameters
    mysqli_stmt_bind_param($stmtInsertComment, "iss", $blog_id, $username, $comment_content);

    // Execute the statement
    $insertCommentResult = mysqli_stmt_execute($stmtInsertComment);

    // Check for query execution success
    if (!$insertCommentResult) {
        error_log("Error in SQL query: " . mysqli_error($link));
        die("Error in submitting the comment.");
    }

    // Notify the post owner
    $notifyOwnerQuery = "INSERT INTO notifications (user_id, content, created_at) 
                        VALUES ((SELECT user_id FROM blogs WHERE blog_id = ?), 'Someone commented on your post.', NOW())";

    $stmtNotifyOwner = mysqli_prepare($link, $notifyOwnerQuery);

    // Bind parameters
    mysqli_stmt_bind_param($stmtNotifyOwner, "i", $blog_id);

    // Execute the statement
    $notifyOwnerResult = mysqli_stmt_execute($stmtNotifyOwner);

    // Check for query execution success
    if (!$notifyOwnerResult) {
        error_log("Error in SQL query: " . mysqli_error($link));
        // Handle the error as needed
    }

    // Redirect back to the post view after successful comment submission
    header("Location: forum-viewpost.php?blog_id=$blog_id");
    exit();
} else {
    // Redirect to the forum feed if the form was not submitted correctly
    header("Location: forum.php");
    exit();
}
?>
