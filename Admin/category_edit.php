<?php
include '../Users/config.php';

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Fetch category details from the database
    $sql = "SELECT `categoryId`, `date_created`, `blog_category`, `blog_description` FROM `category` WHERE `categoryId` = $categoryId";
    $result = mysqli_query($link, $sql);

    // Check for query execution success
    if (!$result) {
        die("Error in SQL query: " . mysqli_error($link));
    }

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        $category = mysqli_fetch_assoc($result);
    } else {
        die("Category not found");
    }

    // Close the result set
    mysqli_free_result($result);
} else {
    die("Invalid request. Please provide a category ID.");
}

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



  .edit body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
}

.edit form {
    width: 300px; /* Adjust the width as needed */
	height: 200px;
    text-align: center;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.edit label {
    display: block;
    margin-bottom: 10px;
}

.edit input {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

.edit textarea {
    width: 100%;
	height: 100px;
    padding: 8px;
    margin-bottom: 15px;
    box-sizing: border-box;
}


.edit button {
    background-color: #3498db; /* Blue color */
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.edit button:hover {
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


    </styles>
    
    <title>Edit Category</title>
</head>
<body>

<?php include 'admin_navbar.php'; ?>

    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Edit Category</h1>
                    
                </div>
            </div>

		<div class="form-container">
            <form action="update_category.php" class="edit" method="post">
                <!-- Include hidden input for categoryId -->
                <input type="hidden" name="categoryId" value="<?php echo $category['categoryId']; ?>">

                <!-- Include hidden input for date_created -->
                <input type="hidden" name="date_created" value="<?php echo date('Y-m-d H:i:s'); ?>">

                <label for="blog_category">Category:</label>
                <input type="text" id="blog_category" name="blog_category" value="<?php echo $category['blog_category']; ?>" required>

                <label for="blog_description">Description:</label>
                <textarea id="blog_description" name="blog_description" required><?php echo $category['blog_description']; ?></textarea>

                <button type="submit">Save Changes</button>
            </form>
		</div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

</body>
</html>
