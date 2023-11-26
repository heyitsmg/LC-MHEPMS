<?php
include '../Users/config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the username based on the provided user ID
    $fetchUsernameQuery = "SELECT `username` FROM `user` WHERE `id` = ?";
    $fetchUsernameStmt = mysqli_prepare($link, $fetchUsernameQuery);

    if ($fetchUsernameStmt) {
        mysqli_stmt_bind_param($fetchUsernameStmt, 'i', $id);
        mysqli_stmt_execute($fetchUsernameStmt);
        mysqli_stmt_bind_result($fetchUsernameStmt, $username);

        if (mysqli_stmt_fetch($fetchUsernameStmt)) {
            mysqli_stmt_close($fetchUsernameStmt);

            // Delete related records from other tables
            $relatedTables = ['user_scores', 'comment_replies', 'comments', 'blogs'];

            foreach ($relatedTables as $relatedTable) {
                $deleteRelatedQuery = "DELETE FROM `$relatedTable` WHERE `username` = ?";
                $deleteRelatedStmt = mysqli_prepare($link, $deleteRelatedQuery);

                if ($deleteRelatedStmt) {
                    mysqli_stmt_bind_param($deleteRelatedStmt, 's', $username);
                    mysqli_stmt_execute($deleteRelatedStmt);
                    mysqli_stmt_close($deleteRelatedStmt);
                } else {
                    // Handle error if needed
                    echo "Error deleting related records from $relatedTable";
                }
            }

            // Delete the user from the 'user' table
            $deleteUserQuery = "DELETE FROM `user` WHERE `id` = ?";
            $deleteUserStmt = mysqli_prepare($link, $deleteUserQuery);

            if ($deleteUserStmt) {
                mysqli_stmt_bind_param($deleteUserStmt, 'i', $id);
                mysqli_stmt_execute($deleteUserStmt);
                mysqli_stmt_close($deleteUserStmt);

                // You can echo a success message if needed
                echo "User and related records deleted successfully";
            } else {
                // You can echo an error message if needed
                echo "Error deleting user";
            }
        } else {
            // Handle error if the user ID is not found
            echo "User not found";
        }
    } else {
        // Handle error if there's an issue fetching the username
        echo "Error fetching username";
    }
}

// Close the database connection
mysqli_close($link);
?>
