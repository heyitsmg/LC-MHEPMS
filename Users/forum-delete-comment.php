<?php
session_start();

include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['comment_id'])) {
    $commentId = $_GET['comment_id'];

    // Check if the logged-in user is the owner of the comment
    $checkOwnershipQuery = "SELECT username FROM comments WHERE comment_id = $commentId";
    $checkOwnershipResult = mysqli_query($link, $checkOwnershipQuery);

    if ($checkOwnershipResult) {
        $commentData = mysqli_fetch_assoc($checkOwnershipResult);
        $commentOwner = $commentData['username'];

        if ($commentOwner == $_SESSION['username']) {
            // Delete the comment and its replies
            $deleteRepliesQuery = "DELETE FROM comment_replies WHERE comment_id = $commentId";
            $deleteRepliesResult = mysqli_query($link, $deleteRepliesQuery);

            $deleteCommentQuery = "DELETE FROM comments WHERE comment_id = $commentId";
            $deleteCommentResult = mysqli_query($link, $deleteCommentQuery);

            if ($deleteRepliesResult && $deleteCommentResult) {
                header("Location: forum-viewpost.php?blog_id=$currentBlogId");
                exit();
            } else {
                // Handle the error (display an error message or redirect to an error page)
                die("Error deleting comment: " . mysqli_error($link));
            }
        } else {
            // Redirect to the view post page with an error message
            header("Location: forum-viewpost.php?blog_id=$currentBlogId&error=not_owner");
            exit();
        }
    } else {
        // Handle the error (display an error message or redirect to an error page)
        die("Error checking ownership: " . mysqli_error($link));
    }
} else {
    // Redirect to the forum page if the request is not valid
    header("Location: forum.php");
    exit();
}
?>
