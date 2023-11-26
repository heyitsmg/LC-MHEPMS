<?php
include '../Users/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the 'categoryId' parameter is set in the form
    if (isset($_POST['categoryId'])) {
        $categoryId = $_POST['categoryId'];
        $newCategory = isset($_POST['blog_category']) ? mysqli_real_escape_string($link, $_POST['blog_category']) : '';
        $newDescription = isset($_POST['blog_description']) ? mysqli_real_escape_string($link, $_POST['blog_description']) : '';
        
        
       // Update the category in the database, including the current timestamp for 'date_created'
        $updateSql = "UPDATE `category` SET
        `blog_category` = '$newCategory',
        `blog_description` = '$newDescription',
        `date_created` = NOW()
        WHERE `categoryId` = $categoryId";


        $updateResult = mysqli_query($link, $updateSql);

        if ($updateResult) {
            // Use JavaScript to show a notification and redirect after a delay
            echo '<script>
                    alert("The category has been changed successfully.");
                    window.location.href = "category.php";
                  </script>';
        } else {
            die("Error updating category: " . mysqli_error($link));
        }
    } else {
        die("Invalid request. Please provide a category ID.");
    }
}

// Close connection
mysqli_close($link);
?>
