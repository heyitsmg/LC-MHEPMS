<?php
// Include the database configuration file
include '../Users/config.php';

// Fetch categories from the database
$sql = "SELECT `categoryId`, `blog_category` FROM `category`";
$result = mysqli_query($link, $sql);

// Check for query execution success
if (!$result) {
    die("Error in SQL query: " . mysqli_error($link));
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input data
    $category = mysqli_real_escape_string($link, $_POST['category']);
    $title = mysqli_real_escape_string($link, $_POST['title']);
    $content = mysqli_real_escape_string($link, $_POST['content']);

    // Assuming you have a session for the logged-in user, fetch the user information
    session_start();
    $user_id = $_SESSION['id']; // Replace with the actual session variable for user ID

    // Fetch username based on user ID
    $usernameQuery = "SELECT username FROM user WHERE id = $user_id";
    $usernameResult = mysqli_query($link, $usernameQuery);

    if ($usernameResult && $usernameRow = mysqli_fetch_assoc($usernameResult)) {
        $username = $usernameRow['username'];

        // Insert the post into the database
        $insertQuery = "INSERT INTO blogs (blog_category, blog_title, blog_by, blog_date, blog_content) 
                        VALUES ('$category', '$title', '$username', NOW(), '$content')";

        $insertResult = mysqli_query($link, $insertQuery);

        // Check for query execution success
        if ($insertResult) {
            // Redirect to forum.php after successful submission
            header("Location: posts.php");
            exit(); // Make sure to exit the script after the header
        } else {
            die("Error in SQL query: " . mysqli_error($link));
        }
    } else {
        die("Error fetching username: " . mysqli_error($link));
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <style> 
 @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

a {
    text-decoration: none;
}
li {
    list-style: none;
}

:root {
    --poppins: 'Poppins', sans-serif;
    --lato: 'Lato', sans-serif;

    --light: #F9F9F9;
    --blue: #3C91E6;
    --light-blue: #CFE8FF;
    --grey: #eee;
    --dark-grey: #AAAAAA;
    --dark: #342E37;
    --red: #DB504A;
    --yellow: #FFCE26;
    --light-yellow: #FFF2C6;
    --orange: #FD7238;
    --light-orange: #FFE0D3;
    --green: #30ee59;
    --light-green: #90e9a4;
}

html {
    overflow-x: hidden;
}

body {
    font-family: var(--poppins);
    background: #eee;
    overflow-x: hidden;
}

#content {
    position: relative;
    width: calc(100% - 280px);
    align-items: center;
    transition: .3s ease;
}


#content main {
    width: 100%;
    padding: 36px 24px;
    font-family: var(--poppins);
    max-height: calc(100vh - 56px);
    overflow-y: auto;
}

#content main .head-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    grid-gap: 16px;
    flex-wrap: wrap;
}

.form-container {
    width: 100%; /* Change to 100% to take up the full width */
    max-width: 780px;
    margin: 0 auto; /* Center the form container horizontally */
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #ccc;
    margin-top: 2rem;
}


.form-group {
    margin-bottom: 20px;
    display: flex; 
    flex-direction: column;
}

label {
    margin-bottom: 8px;
    font-size: 16px;
}

select,
input,
textarea {
    width: 100%;
    padding: 10px;
    margin-top: 4px; /* Add margin-top for spacing between label and input */
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

textarea {
    height: 100px;
}

button {
    background-color: #3498db;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    margin: 0;
    margin-left: auto; 
}


button:hover {
    background-color: #2980b9;
}

    </style>

    <title>Create New Post</title>
</head>
<body>

<?php include 'admin_navbar.php'; ?>
<br>
    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>

            <div class="form-container">
                <form method="POST" action="posts-create.php">

                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category" id="category">
                            <option value="">Select Category</option>
                            <?php
                            // Display categories dynamically
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['blog_category']}'>{$row['blog_category']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content:</label>
                        <textarea id="content" name="content" class="input-field" required></textarea>
                    </div>

                    <div class="form-group">
                        <center><button type="submit" name="submit" class="btn btn-primary">Submit Post</button>
                    </div>
                </form>

            </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->


</body>
</html>
