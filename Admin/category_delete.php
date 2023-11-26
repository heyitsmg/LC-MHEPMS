<?php
include '../Users/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['id'])) {
    $action = mysqli_real_escape_string($link, $_POST['action']);
    $id = mysqli_real_escape_string($link, $_POST['id']);

    // Delete category from the database
    $delete_query = "DELETE FROM `category` WHERE `categoryId` = $id";
    $delete_result = mysqli_query($link, $delete_query);

    // Check for query execution success
    if (!$delete_result) {
        die("Error in SQL query: " . mysqli_error($link));
    }

    // Redirect to category list page after deletion
    header("Location: category.php");
    exit();
}

mysqli_close($link);
?>
