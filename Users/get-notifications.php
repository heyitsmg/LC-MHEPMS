<?php
session_start();

include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php"); 
    exit();
}

$user_id = $_SESSION['id'];
$notifications = fetchNotifications($link, $user_id);

include 'forumside.php';

function fetchNotifications($link, $user_id)
{
    $notifications = [];

    $sql = "SELECT n.*, b.blog_id, b.blog_title, u.username AS commenter_username
            FROM notifications n
            LEFT JOIN blogs b ON n.blog_id = b.blog_id
            LEFT JOIN user u ON n.commenter_id = u.id
            WHERE n.commenter_id = ? AND n.is_read = 0";

    $stmt = mysqli_prepare($link, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $notifications = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // Mark notifications as read
            markNotificationsAsRead($link, $user_id);

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle error fetching result
            echo "Error fetching notifications: " . mysqli_error($link);
        }
    } else {
        // Handle error in SQL query
        echo "Error in SQL query: " . mysqli_error($link);
    }

    return $notifications;
}

function markNotificationsAsRead($link, $user_id)
{
    $updateSql = "UPDATE notifications SET is_read = 1 WHERE commenter_id = ?";
    $updateStmt = mysqli_prepare($link, $updateSql);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, 'i', $user_id);
        mysqli_stmt_execute($updateStmt);

        // Close the statement
        mysqli_stmt_close($updateStmt);
    } else {
        // Handle error in update SQL query
        echo "Error in update SQL query: " . mysqli_error($link);
    }
}

    $notifications = fetchNotifications($link, $user_id);

    foreach ($notifications as $notification) {
        $content = "@" . $notification['commenter_username'] . " commented on your post: '" . $notification['blog_title'] . "'";
        $targetUrl = 'forum-viewpost.php?blog_id=' . urlencode($notification['blog_id']);
    
        // Check if the notification is read or unread and set appropriate styles
        $notificationClass = $notification['is_read'] ? 'notification-item read' : 'notification-item unread';
    
        echo "<div class='{$notificationClass}'>";
        echo "<a href='{$targetUrl}'>";
        echo "<p>{$content}</p>";
        echo "<small>{$notification['created_at']}</small>";
        echo "</a>";
        echo "</div>";
        echo "<script>console.log('Target URL:', '{$targetUrl}');</script>"; // Debugging statement
    }
    
?>
