<?php
include '../Users/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    if ($_POST["action"] == "delete" && isset($_POST["blog_id"])) {
        $blogId = mysqli_real_escape_string($link, $_POST["blog_id"]);

        // Delete comments associated with the blog post
        $deleteCommentsSql = "DELETE FROM `comments` WHERE `blog_id` = '$blogId'";
        $deleteCommentsResult = mysqli_query($link, $deleteCommentsSql);

        if ($deleteCommentsResult) {
            // Now, delete the blog post
            $deleteSql = "DELETE FROM `blogs` WHERE `blog_id` = '$blogId'";
            $deleteResult = mysqli_query($link, $deleteSql);

            if ($deleteResult) {
                echo "Post and associated comments deleted successfully.";
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            } else {
                echo "Error deleting post: " . mysqli_error($link);
            }
        } else {
            echo "Error deleting comments: " . mysqli_error($link);
        }
    }
}

// Fetch post data with usernames from the database
$sql = "SELECT b.`blog_id`, b.`blog_date`, u.`username` AS `blog_by`, b.`blog_title`, b.`blog_content` 
        FROM `blogs` b
        JOIN `user` u ON b.`blog_by` = u.`username`";

$result = mysqli_query($link, $sql);

// Check for query execution success
if (!$result) {
    die("Error in SQL query: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="en">
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
        }

        html {
            overflow-x: hidden;
        }

        body.dark {
            --light: #0C0C1E;
            --grey: #060714;
            --dark: #FBFBFB;
        }

        body {
            background: var(--grey);
            overflow-x: hidden;
        }

        p {
            font-family: var(--lato);
            font-size: 15px;
            display: flex;
            align-items: center;
            color: var(--blue);
            position: sticky;
            margin-left: 10px;
        }

        /* CONTENT */
        #content {
            overflow-y: auto;
            position: relative;
        }
        #content main {
            width: calc(100% - 40px);
            margin: 0 auto; /* Center the content */
            padding: 36px 24px;
            font-family: var(--poppins);
            max-height: calc(100vh - 56px);
            margin-top: 2rem;
        }
        #content main .head-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            grid-gap: 16px;
            flex-wrap: wrap;
        }
        #content main .head-title .left h1 {
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark);
        }

        #content main .table-data {
            display: flex;
            flex-wrap: wrap;
            grid-gap: 24px;
            margin-top: 24px;
            width: 100%;
            color: var(--dark);
        }
        #content main .table-data > div {
            border-radius: 20px;
            background: var(--light);
            padding: 24px;
            overflow-x: auto;
        }
        #content main .table-data .head {
            display: flex;
            align-items: center;
            grid-gap: 16px;
            margin-bottom: 24px;
        }

        .create-post-btn {
            background-color: #3C91E6;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            width: 130px;
            height: 30px;
        }

        .create-post-btn:hover {
            background-color: #265d91;
        }


        #content main .table-data .head .icon-container {
            display: flex;
            align-items: center;
            margin-right: -1rem;
        }

        #content main .table-data .head .searchInput {
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 30px;
            width: 170px;
        }

        #content main .table-data .head .searchResults {
            margin-top: 10px; /* Adjust the margin as needed */
        }

        #content main .table-data .head a {
            margin-right: auto;
            font-size: 18x;
            font-weight: 300;
        }
        #content main .table-data .head .bx {
            cursor: pointer;
            margin-left: 1rem;
        }

        #content main .table-data .order {
            flex-grow: 1;
            flex-basis: 500px;
        }
        #content main .table-data .order table {
            width: 100%;
            border-collapse: collapse;
        }
        #content main .table-data .order table th {
            padding-bottom: 12px;
            font-size: 13px;
            text-align: left;
            border-bottom: 1px solid var(--grey);
        }
        #content main .table-data .order table td {
            padding: 16px 0;
        }
        #content main .table-data .order table tr td:first-child {
            display: flex;
            align-items: center;
            grid-gap: 12px;
            padding-left: 6px;
        }

        #content main .table-data .order table tbody tr:hover {
            background: var(--grey);
        }


    </style>

    <title>Posts</title>
</head>
<body>

<?php include 'admin_navbar.php'; ?>
<br>
    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>
        <div class="head-title">
				<div class="left">
					<h1>User Posts</h1>
				</div>
                <div class="icon-container">
                    <button class="create-post-btn" onclick="location.href='posts-create.php'">Create New Post</button>
                </div>
			</div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <a>Lists of Posts</a>                
                        <div class="icon-container">
                            <input type="text" id="searchInput" class="searchInput" placeholder=" Search" oninput="performSearch()">                           
                        </div>        
                        <div class="searchResults" id="searchResults"></div>
                        
                    </div>
                    

                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date Posted</th>
                                <th>Username</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Check if there are any results
                            if(mysqli_num_rows($result) > 0){
                                // Start the loop
                                $counter = 1;
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<tr>";
                                    echo "<td>" . $counter . "</td>";
                                    echo "<td>" . $row["blog_date"] . "</td>";
                                    echo "<td>" . $row["blog_by"] . "</td>";
                                    echo "<td>" . $row["blog_title"] . "</td>";
                                    
                                    echo "<td>";
                                    echo "<div class='dropdown'>";

                                    // Use a JavaScript function to handle redirection and form submission
                                    echo "<form method='post' action='".$_SERVER['PHP_SELF']."' id='deleteForm_" . $row["blog_id"] . "'>";
                                    echo "<input type='hidden' name='blog_id' value='" . $row['blog_id'] . "'>";
                                    echo "<select style='background: #CFE8FF; border-radius: 5px; padding: 5px; color: #000;' name='action' onchange='handleAction(this.value, " . $row["blog_id"] . ")'>";
                                    echo "<option value='' selected>Choose Action</option>";
                                    echo "<option value='view'>View</option>";
                                    echo "<option value='delete'>Delete</option>";
                                    echo "</select>";
                                    echo "</form>";

                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";

                                    $counter++;
                                }
                            } else {
                                // No results
                                echo "<tr><td colspan='6'>No results</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script>
        function handleAction(action, blogId) {
            if (action === 'view') {
                window.location.href = '../Users/forum-viewpost.php?blog_id=' + blogId;
            } else if (action === 'delete') {
                // Show a confirmation prompt
                var confirmDelete = confirm("Are you sure you want to delete this post?");
                
                // If the user confirms, submit the form for delete action
                if (confirmDelete) {
                    document.getElementById('deleteForm_' + blogId).submit();
                }
            }
        }

        function performSearch() {
            // Get the value from the search input
            var searchQuery = document.getElementById('searchInput').value.toLowerCase();

            // Get all table rows
            var rows = document.querySelectorAll('.table-data tbody tr');

            // Loop through each row and hide/show based on the search query
            rows.forEach(function(row) {
                var category = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                // If the category contains the search query, show the row, otherwise hide it
                if (category.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>

<?php
// Close connection
mysqli_close($link);
?>
