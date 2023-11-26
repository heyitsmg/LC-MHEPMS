<?php
session_start();

include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: index.php"); 
    exit();
}

$user_id = $_SESSION['id'];

$sql = "SELECT b.blog_id, b.blog_title, b.blog_by, u.username AS username, b.blog_date, b.blog_content, b.blog_category
        FROM blogs b
        JOIN user u ON b.blog_by = u.username
        ORDER BY b.blog_date DESC";
$result = mysqli_query($link, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap">
    <title>Forum Feed</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: var(--poppins);
            background-color: #f0f2f5;
            color: #1c1e21;
        }

        .box-info {
            margin: 36px auto; 
            padding: 16px;
            width: 1020px;
        }

        .post {
            width: 100%;
            padding: 16px;
            background: #fff;
            display: flex;
            flex-direction: column;
            box-shadow: 0 9px 20px rgba(34, 32, 32, 0.1);
            margin-bottom: 50px;
            border: 1px solid #ccc;
        }


        .post:hover {
            background: #d3e5f7;
        }

        .post-title {
            font-size: 20px;
            font-weight: bold;
            color: var(--dark);
            margin-bottom: 0;
            text-align: center; 
        }

        .post-content {
            color: var(--dark);
            font-size: 15px;
            line-height: 1.4;
            margin-bottom: 8px;
            text-align: center; 
        }

        .post-details {
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .post-category,
        .post-author,
        .post-date {
            color: var(--dark);
            font-size: 12px;
            margin-bottom: 8px;
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
    <br><BR>
    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>

            <div class="box-info">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <div class="post" >
                            <a href="forum-viewpost.php?blog_id=<?php echo $row['blog_id']; ?>" style="text-decoration: none; color: inherit;">
                            <center><h5 class="post-title"><a href="forum-viewpost.php?blog_id=<?php echo $row['blog_id']; ?>"><?php echo $row['blog_title']; ?></a></h5></center>
                            <center><p class="post-author">@<?php echo $row['username']; ?></p></center>
                            <br><br>
                            <center><p class="post-content"><?php echo $row['blog_content']; ?></p>
                            <br><br>
                            <div class="post-details" style="text-align: right;">
                                <p class="post-category">Category: <?php echo $row['blog_category']; ?> | Date: <?php echo $row['blog_date']; ?></p>
                            </div>
                            </a>
                        </div>
                        <?php
                    }
                } else {

                    echo "<p>No blog posts found</p>";
                }
                ?>
            </div>





        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

</body>
</html>
