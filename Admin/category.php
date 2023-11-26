<?php
include '../Users/config.php';

$sql = "SELECT `categoryId`, `date_created`, `blog_category`, `blog_description` FROM `category` ";
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

/* Add this CSS to your existing stylesheet or create a new one */
.create-category-btn {
    background-color: #3C91E6; /* Choose a color that fits your design */
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.create-category-btn:hover {
    background-color: #265d91; /* Change the color on hover if desired */
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
	font-size: 18px;
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
#content main .table-data .order table tr td .status {
	font-size: 10px;
	padding: 6px 16px;
	color: var(--light);
	border-radius: 20px;
	font-weight: 700;
}
#content main .table-data .order table tr td .status.completed {
	background: var(--blue);
}
#content main .table-data .order table tr td .status.process {
	background: var(--yellow);
}
#content main .table-data .order table tr td .status.pending {
	background: var(--orange);
}

/* MAIN */
/* CONTENT */


@media screen and (max-width: 768px) {
	#sidebar {
		width: 200px;
	}

	#content {
		width: calc(100% - 60px);
		left: 200px;
	}

	#content nav .nav-link {
		display: none;
	}
}



@media screen and (max-width: 576px) {
	#content nav form .form-input input {
		display: none;
	}

	#content nav form .form-input button {
		width: auto;
		height: auto;
		background: transparent;
		border-radius: none;
		color: var(--dark);
	}

	#content nav form.show .form-input input {
		display: block;
		width: 100%;
	}
	#content nav form.show .form-input button {
		width: 36px;
		height: 100%;
		border-radius: 0 36px 36px 0;
		color: var(--light);
		background: var(--red);
	}

	#content nav form.show ~ .notification,
	#content nav form.show ~ .profile {
		display: none;
	}

	#content main .box-info {
		grid-template-columns: 1fr;
	}

	#content main .table-data .head {
		min-width: 420px;
	}
	#content main .table-data .order table {
		min-width: 420px;
	}
}

#sidebar.hide {
	width: 0;
	transition: width 0.3s ease;
  }
    </style>

	<title>Topic Categories</title>
</head>
<body>

<?php include 'admin_navbar.php'; ?>
	
	<!-- CONTENT -->
	<section id="content">
		
		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Topic Categories</h1>
				</div>

                <div class="icon-container">
                    <button class="create-category-btn" onclick="location.href='create_category.php'">Create New Category</button>
                </div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
                        <a>List of Topic Categories</a>
						
						<div class="icon-container">
                            <input type="text" id="searchInput" class="searchInput" placeholder=" Search" oninput="performSearch()">                           
                        </div>        
                        <div class="searchResults" id="searchResults"></div>               

					</div>
					<table>
						<thead>
							<tr>
								<th>#</th> 
								<th>Date Created</th>
								<th>Category</th>
								<th>Description</th>
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
                                    echo "<td>" . $row["date_created"] . "</td>";
                                    echo "<td>" . $row["blog_category"] . "</td>";
                                    echo "<td>" . $row["blog_description"] . "</td>";
                                    
									echo "<td>";
                                    echo "<select style='background: #CFE8FF; border-radius: 5px; padding: 5px; color: #000;' name='action' onchange='actionDropdown(this.value, " . $row["categoryId"] . ")'>";
                                    echo "<option value='' selected>Choose Action</option>";
                                    echo "<option value='edit'>Edit</option>";
                                    echo "<option value='delete'>Delete</option>";
                                    echo "</select>";
                                    echo "</td>";
                                    
									echo "</tr>";

                                    $counter++;
                                }
                            } else {
                                // No results
                                echo "<tr><td colspan='5'>No results</td></tr>";
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

	<form id="deleteForm" method="POST" style="display: none;">
		<input type="hidden" name="action" value="delete">
		<input type="hidden" name="id" value="">
	</form>


    <script>
        function actionDropdown(selectedAction, categoryId) {
            if (selectedAction === 'edit') {
                window.location.href = 'category_edit.php?id=' + categoryId;
            } else if (selectedAction === 'delete') {
                // Call the deleteCategory function with the category ID
                deleteCategory(categoryId);
            }
        }

        function deleteCategory(id) {
            if (confirm('Are you sure you want to delete this category?')) {
                // Set the form action dynamically
                document.getElementById('deleteForm').action = 'category_delete.php';
                // Set the category ID as a value in the form
                document.getElementById('deleteForm').elements['id'].value = id;
                // Submit the form
                document.getElementById('deleteForm').submit();
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