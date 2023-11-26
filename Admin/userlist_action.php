<?php
require_once "../Users/config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if 'id' and 'action' parameters are set in the URL
    if (isset($_GET['id']) && isset($_GET['action'])) {
        $user_id = $_GET['id'];
        $action = $_GET['action'];

        // Perform action based on the value of 'action'
        switch ($action) {
            case 'approve':
                $status = 'approved';
                updateStatus($user_id, $status);
                break;
            case 'deny':
                $status = 'denied';
                updateStatus($user_id, $status);
                break;
            // Add more cases for other actions if needed
            default:
                // Invalid action
                break;
        }
    }
}

function updateStatus($user_id, $newStatus) {
    global $link;

    // Update the user status in the database
    $sql = "UPDATE user SET status = ? WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "si", $newStatus, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            // Status updated successfully
            echo "Status updated successfully";
        } else {
            // Error updating status
            echo "Error updating status: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt);
    } else {
        // Error preparing statement
        echo "Error preparing statement: " . mysqli_error($link);
    }
    mysqli_close($link);
}


?>
