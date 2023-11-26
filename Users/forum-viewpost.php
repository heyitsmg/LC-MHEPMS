<?php
session_start();
$user_id = $_SESSION['id'];

include('config.php');

if (isset($_GET['blog_id'])) {
    $blogId = $_GET['blog_id'];

    // Fetch the blog post
    $blogQuery = "SELECT b.blog_id, b.blog_title, b.blog_by, u.username AS username, b.blog_date, b.blog_content, b.blog_category
            FROM blogs b
            JOIN user u ON b.blog_by = u.username
            WHERE b.blog_id = $blogId";
    $blogResult = mysqli_query($link, $blogQuery);

    if (!$blogResult) {
        die("Error in SQL query: " . mysqli_error($link));
    }

    // Fetch the comments
    $commentsQuery = "SELECT c.comment_id, c.comment_date, c.comment_content, u.username AS comment_username
            FROM comments c
            JOIN user u ON c.username = u.username
            WHERE c.blog_id = $blogId";
    $commentsResult = mysqli_query($link, $commentsQuery);

    if (!$commentsResult) {
        die("Error in SQL query: " . mysqli_error($link));
    }
    $commentData = array();

    while ($comment = mysqli_fetch_assoc($commentsResult)) {
        $commentId = $comment['comment_id'];
    
        // Fetch replies for each comment
        $repliesQuery = "SELECT r.reply_id, r.reply_date, r.reply_content, u.username AS reply_username
            FROM comment_replies r
            JOIN user u ON r.username = u.username
            WHERE r.comment_id = $commentId";
    
        $repliesResult = mysqli_query($link, $repliesQuery);
    
        if (!$repliesResult) {
            die("Error in SQL query: " . mysqli_error($link));
        }
    
        $comment['replies'] = array();
    
        while ($reply = mysqli_fetch_assoc($repliesResult)) {
            $comment['replies'][] = $reply;
        }
    
        $commentData[] = $comment;    
    }
} else {
    header("Location: forum.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap">
    <title>View Post</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

        body {
            font-family: var(--poppins);
            background-color: #eee;
            color: #1c1e21;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .post {
            width: 100%;
            padding: 16px;
            background: #fff;
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            border: 1px solid #ccc;
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
            text-align: center; /* Center-align the post details */
        }

        .post-category,
        .post-author,
        .post-date {
            color: var(--dark);
            font-size: 12px;
            margin-bottom: 8px;
        }

        .card .comments-card{
            margin-top: 0;
            padding: 15px;
            background-color: #fff;
        }

        .comment {
            margin-bottom: 10px;
        }

        .comment p {
            margin: 0;
            font-size: 15px;
        }

        .comment small {
            color: #888;
            font-size: 12px;
        }

        .comments-card h4 {
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .comments-card form {
            display: flex;
            flex-direction: column;
        }

        .comments-card textarea {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .comments-card button {
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

        .comments-card button:hover {
            background-color: #23527c;
        }

        .comments-card center {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

<script>
    function toggleReplyForm(commentId) {
        var replyForm = document.getElementById('replyForm' + commentId);
        if (replyForm.style.display === 'none' || replyForm.style.display === '') {
            replyForm.style.display = 'block';
        } else {
            replyForm.style.display = 'none';
        }
    }
</script>
</head>

<body>

    <?php include('forumside.php'); ?>
    <br><br><br>

    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>
            <div class="container mt-5">
                <?php
                if (mysqli_num_rows($blogResult) > 0) {
                    $row = mysqli_fetch_assoc($blogResult);
                    ?>

                    <!-- Blog post card -->
                    <div class="box-info">
                        <div class="post">
                            <center><h5 class="post-title"><a href="forum-viewpost.php?blog_id=<?php echo $row['blog_id']; ?>"><?php echo $row['blog_title']; ?></a></h5></center>
                            <center><p class="post-author">@<?php echo $row['username']; ?></p></center>
                            <br><br>
                            <center><p class="post-content"><?php echo $row['blog_content']; ?></p>
                                <br><br>
                                <div class="post-details" style="text-align: right;">
                                    <p class="post-category">Category: <?php echo $row['blog_category']; ?> | Date: <?php echo $row['blog_date']; ?></p>
                                </div>
                        </div>
                    </div>

                    <!-- Comments and Comment form card -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <!-- Comments section card -->
                            <div class="comments-card">
                                <h4 class="card-title">Comments Section</h4>
                                <?php

                                $commentsResult = mysqli_query($link, $commentsQuery);

                                while ($comment = mysqli_fetch_assoc($commentsResult)) {
                                    ?>
                                    <div class="comment">
                                        <p>@<?php echo isset($comment['comment_username']) ? $comment['comment_username'] : 'Unknown'; ?>: </p>
                                        <p><?php echo isset($comment['comment_content']) ? $comment['comment_content'] : 'No content'; ?> <br></p>
                                        <small class="text-muted"><?php echo isset($comment['comment_date']) ? $comment['comment_date'] : 'Unknown date'; ?></small>
                                        
                                        
                                    </div>
                                    <?php
                                }
                                ?>

                                <h4 class="card-title">Add a Comment:</h4>
                                <form action="forum-comments.php" method="post">
                                    <input type="hidden" name="blog_id" value="<?php echo $row['blog_id']; ?>">
                                    <textarea name="comment_content" rows="4" placeholder="Type your comment here..." required></textarea>
                                    <button type="submit">Submit Comment</button>
                                </form>

                            </div>
                        </div>
                    </div>

                <?php

                $currentBlogId = $row['blog_id'];
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
