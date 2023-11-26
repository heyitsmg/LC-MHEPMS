<?php
session_start();


include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php"); 
    exit();
}

// Fetch user ID from the session
$user_id = $_SESSION['id'];

// Fetch user data from the database
$sql = "SELECT `first_name` FROM `user` WHERE `id` = $user_id";
$result = mysqli_query($link, $sql);

// Check for query execution success
if (!$result) {
    die("Error in SQL query: " . mysqli_error($link));
}

// Check if there is a user with the given ID
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $first_name = $user['first_name'];
} else {
    die("User not found");
}

// Close the database connection
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



/* MAIN */
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

#content main .head-title .left h1 {
	font-size: 36px;
	font-weight: 600;
	margin-bottom: 10px;
	color: var(--dark);
}
</style>

    <title>Fitbit Dashboard</title>
</head>
<body>

    <?php include 'sidebar.php'; ?>
<br><br>

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
                
            </ul>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->


</body>
</html>
