<?php
// Include the database configuration file
include('config.php');

// Fetch categories from the database
$sql = "SELECT `categoryId`, `blog_category`, `blog_description` FROM `category`";
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
    <title>Topic Category</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #1c1e21;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            background-color: #ffffff;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 15px;
        }

        .card h2 {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .card p {
            font-size: 18;
            line-height: 1.4;
            color: #6b757f;
        }

        .link-box {
            color: #3C91E6;
        }

        .head-title h1 {
            font-size: 24px;
        }

        .center-container {
            text-align: center;
        }
</style>

<script>
        document.addEventListener('DOMContentLoaded', function() {

            var currentPage = window.location.pathname;

            var links = document.querySelectorAll('.side-menu.top li a');
            links.forEach(function(link) {
                if (link.getAttribute('href') === currentPage) {
                    link.parentNode.classList.add('active');
                    link.style.color = 'var(--blue)';
                }
            });
        });

    </script>
</head>

<body>

    <?php include('forumside.php'); ?>
    <br><br><br><br>
    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>
            

            <div class="container mt-5 center-container">
                <div class="container mt-5">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="mb-0">
                                    <?php echo $row['blog_category']; ?>
                                </h2>
                                
                                 <p>  <?php echo $row['blog_description']; ?> </p>
                                
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
</body>
</html>
