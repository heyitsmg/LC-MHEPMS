<?php
// Start session (if not already started)
session_start();

// Check if a user is logged in as an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Users/index.php"); // Redirect to login page
    exit();
}

// Include your config file
include '../Users/config.php';

// Fetch user ID from the session
$user_id = $_SESSION['id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch form data
    $first_name = mysqli_real_escape_string($link, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($link, $_POST['last_name']);
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $current_password = mysqli_real_escape_string($link, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($link, $_POST['new_password']);
    $repeat_password = mysqli_real_escape_string($link, $_POST['repeat_password']);

    // Fetch user data from the database
    $sql = "SELECT `id`, `username`, `email`, `password` FROM `user` WHERE `id` = $user_id";
    $result = mysqli_query($link, $sql);

    // Check for query execution success
    if (!$result) {
        die("Error in SQL query: " . mysqli_error($link));
    }

    // Check if there is a user with the given ID
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verify the current password
        if (password_verify($current_password, $user['password'])) {
            // Update user profile settings
            $update_sql = "UPDATE `user` SET `first_name`='$first_name', `last_name`='$last_name', `email`='$email' WHERE `id` = $user_id";
            $update_result = mysqli_query($link, $update_sql);

            if (!$update_result) {
                die("Error updating profile: " . mysqli_error($link));
            }

            // Update password if a new one is provided
            if (!empty($new_password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_password_sql = "UPDATE `user` SET `password`='$hashed_password' WHERE `id` = $user_id";
                $update_password_result = mysqli_query($link, $update_password_sql);

                if (!$update_password_result) {
                    die("Error updating password: " . mysqli_error($link));
                }
            }

            // Redirect to profile page or any other appropriate page
            header("Location: settings.php");
            exit();
        } else {
            // Incorrect current password
            echo "Incorrect current password";
        }
    } else {
        die("User not found");
    }
}

// Close connection
mysqli_close($link);
?>
