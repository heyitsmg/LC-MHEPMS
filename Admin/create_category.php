<?php
include '../Users/config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blog_category = mysqli_real_escape_string($link, $_POST['blog_category']);
    $blog_description = mysqli_real_escape_string($link, $_POST['blog_description']);

    // Insert the new category into the database
    $insert_query = "INSERT INTO `category` (`blog_category`, `blog_description`, `date_created`) VALUES ('$blog_category', '$blog_description', CURRENT_TIMESTAMP)";
    $insert_result = mysqli_query($link, $insert_query);

    // Check for query execution success
    if (!$insert_result) {
        die("Error in SQL query: " . mysqli_error($link));
    }

    // Redirect to the topic categories page after inserting
    header("Location: category.php");
    exit();
}

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



/* MAIN */
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

  .form-group body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
}

.form-group form {
    width: 300px; /* Adjust the width as needed */
    text-align: center;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group label {
    display: block;
    margin-bottom: 10px;
}

.form-group input, .form-group textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

.form-group button {
    background-color: #3498db; /* Blue color */
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.form-group button:hover {
    background-color: #2980b9; /* Lighter shade of blue on hover */
}

.form-container {
    width: 100%; 
    max-width: 550px;
	height: 400px;
    margin: 0 auto; /* Center the form container horizontally */
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border: 1px solid #ccc;
    margin-top: 2rem;
}
textarea {
    width: 100%;
	height: 120px;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

    </style>

    <title>Create Category</title>
</head>
<body>

<?php include 'admin_navbar.php'; ?>

<!-- CONTENT -->
<section id="content">
		
		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Create New Category</h1>
					
				</div>
				
			</div>

            <!-- Form to create a new category -->
            <div class="form-container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <div class="form-group">
                    <input type="hidden" name="date_created" value="<?php echo $category['date_created']; ?>">
                    </div>    

                    <div class="form-group">
                        <label for="blog_category">Category</label>
                        <input type="text" id="blog_category" name="blog_category" required>
                    </div>
                    <div class="form-group">
                        <label for="blog_description">Description</label>
                        <textarea id="blog_description" name="blog_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create Category</button>
                    </div>
                </form>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->



</body>
</html>
