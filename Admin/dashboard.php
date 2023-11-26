<?php
session_start();

// Include config.php to get database credentials
include '../Users/config.php';

$user_id = $_SESSION['id'];

// Fetch data for topic categories
$categorySql = "SELECT `categoryId`, `date_created`, `blog_category`, `blog_description` FROM `category` WHERE 1";
$categoryResult = mysqli_query($link, $categorySql);
$categoryCount = mysqli_num_rows($categoryResult);

// Fetch data for registered users
$userSql = "SELECT COUNT(*) as userCount FROM `user`";
$userResult = mysqli_query($link, $userSql);

// Initialize the variable to avoid the notice
$userCount = 0;

// Check if the result set has rows and fetch the data
if ($userResult) {
    $userData = mysqli_fetch_assoc($userResult);
    $userCount = $userData['userCount'];
}

// Initialize $first_name variable
$first_name = "";

// Check if the user is logged in and fetch the user's first name
if (isset($_SESSION['id'])) {
    $userSql = "SELECT `id`, `role`, `date_created`, `first_name`, `last_name`, `username`, `email`, `password` FROM `user` WHERE id = $user_id";
    $userResult = mysqli_query($link, $userSql);

    // Check if the result set has rows and fetch the data
    if ($userResult) {
        $userData = mysqli_fetch_assoc($userResult);
        $first_name = $userData['first_name'];
    }
}

// Fetch data for published posts
$postSql = "SELECT `blog_id`, `blog_title`, `blog_by`, `blog_date`, `blog_content` FROM `blogs` WHERE 1";
$postResult = mysqli_query($link, $postSql);
$postCount = mysqli_num_rows($postResult);

// Close connection
mysqli_close($link);
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
            --green: #30ee59;
            --light-green: #90e9a4;
        }

        html {
            overflow-x: hidden;
        }


        body {
            background: var(--grey);
            overflow-x: hidden;
        }

        body.dark {
            --light: #0C0C1E;
            --grey: #060714;
            --dark: #FBFBFB;
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

        #content main .box-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            grid-gap: 24px;
            margin-top: 36px;
        }
        #content main .box-info li {
            padding: 24px;
            background: var(--light);
            border-radius: 20px;
            display: flex;
            align-items: center;
            grid-gap: 24px;
        }
        #content main .box-info li .bx {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            font-size: 36px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #content main .box-info li:nth-child(1) .bx {
            background: var(--light-blue);
            color: var(--blue);
        }

        #content main .box-info li:nth-child(2) .bx {
            background: var(--light-yellow);
            color: var(--yellow);
        }

        #content main .box-info li:nth-child(3) .bx {
            background: var(--light-orange);
            color: var(--orange);
        }

        #content main .box-info li .text h3 {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
        }
        #content main .box-info li .text p {
            color: var(--dark);	
        }
    </style>

    <title>Dashboard</title>
</head>

<body>
    
<?php include 'admin_navbar.php'; ?>

    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Welcome, <?php echo $first_name; ?>!</h1>
                    
                </div>
            </div>

            <ul class="box-info">
                <li>
					<a href="category.php">
                    <i class='bx bxs-tag' ></i></a>
                    <span class="text">
                        <h3><?php echo $categoryCount; ?></h3>
                        <p>Topic Categories</p>
                    </span>
					
                </li>
                <li>
				<a href="userlist.php">
                    <i class='bx bxs-group' ></i></a>
                    <span class="text">
                        <h3><?php echo $userCount; ?></h3>
                        <p>Registered Users</p>
                    </span>
                </li>
                <li>
				<a href="posts.php">
                    <i class='bx bxs-book-open' ></i></a>
                    <span class="text">
                        <h3><?php echo $postCount; ?></h3>
                        <p>Published Posts</p>
                    </span>
                </li>
            </ul>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    

</body>
</html>
