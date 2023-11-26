<?php
include '../Users/config.php';

// Check if the 'id' and 'action' parameters are set
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    // Define the SQL query based on the action
    if ($action === 'approve') {
        $status = 'approved';
    } elseif ($action === 'deny') {
        $status = 'denied';
    } else {
        // For any other action, do nothing
        exit();
    }

    // Update the user status in the database
    $updateQuery = "UPDATE `user` SET `status` = ? WHERE `id` = ?";
    $updateStmt = mysqli_prepare($link, $updateQuery);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, 'si', $status, $id);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
    }
}

$sql = "SELECT `id`, `date_created`, `first_name`, `last_name`, `username`, `status`, `school_id_file` FROM `user`";
$result = mysqli_query($link, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($link));
}

$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($link, $_GET['search']) : '';
if (!empty($searchQuery)) {
    $sql .= " WHERE `first_name` LIKE '%$searchQuery%' OR `last_name` LIKE '%$searchQuery%' OR `username` LIKE '%$searchQuery%'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        die("Error in SQL query: " . mysqli_error($link));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS (add this line in the head section of your HTML) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    
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
            background-color: var(--grey);
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
            font-size: 15px;
            text-align: left;
            border-bottom: 1px solid var(--grey);
        }
        #content main .table-data .order table td {
            padding: 14px 0;
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
        #content main .table-data .order table tr td .status.approved {
            background: var(--blue);
        }
        #content main .table-data .order table tr td .status.denied {
            background: var(--yellow);
        }
        #content main .table-data .order table tr td .status.pending {
            background: var(--orange);
        }
    </style>

    <title>User List</title>
</head>
<body>

    <?php include 'admin_navbar.php'; ?>

    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <a>List of Registered Users</a>
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
                                <th>Name</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>School ID Proof</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="userListTableBody">
                            <?php
                            if(mysqli_num_rows($result) > 0){
                                $counter = 1;
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<tr>";
                                    echo "<td>" . $counter . "</td>";
                                    echo "<td>" . $row["date_created"] . "</td>";
                                    echo "<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>";
                                    echo "<td>" . $row["username"] . "</td>";
                                    echo "<td>" . $row["status"] . "</td>";
                                    echo "<td><a href='#' onclick='viewProof(\"../Users/uploads/" . $row["school_id_file"] . "\")'>View Proof</a></td>";
                                    echo "<td>";
                                    echo "<div class='dropdown'>";
                                    echo "<select style='background: #CFE8FF; border-radius: 5px; padding: 1px; color: #000;' name='action' onchange='performAction(" . $row["id"] . ", this.value)'>Select Action<i class='bx bxs-down-arrow'></i>";
                                    echo "<option value=''>Select Action</option>";
                                    echo "<option value='approve'>Approve</option>";
                                    echo "<option value='deny'>Deny</option>";
                                    echo "<option value='delete'>Delete</option>";
                                    echo "</select>";
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $counter++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>No results</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>            
            
            <!-- Modal --><center>
            <div class="modal fade" id="viewProofModal" tabindex="-1" role="dialog" aria-labelledby="viewProofModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewProofModalLabel">View School ID Proof</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <img id="schoolIdProofImage" src="" alt="School ID Proof" style="max-width: 100%;">
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </section>

    <!-- Bootstrap JS (add these lines at the end of your body section, before your custom JS) -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        function performAction(id, action) {
        if (action === 'approve' || action === 'deny') {
            if (confirm('Are you sure you want to ' + action + ' this user?')) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xmlhttp.open("GET", "userlist_action.php?id=" + id + "&action=" + action, true);
                xmlhttp.send();
            }
        } else if (action === 'delete') {
            if (confirm('Are you sure you want to delete this user?')) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        location.reload();
                    }
                };
                xmlhttp.open("GET", "userlist_delete.php?id=" + id, true);
                xmlhttp.send();
            }
        }
    }

    function performSearch() {
        var searchInputValue = document.getElementById('searchInput').value;
        // Perform your search logic and update the results on the same page
        updateSearchResults(searchInputValue);
    }

    function updateSearchResults(query) {
        // Replace this with your actual search logic using AJAX
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('userListTableBody').innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "userlist_search.php?search=" + encodeURIComponent(query), true);
        xmlhttp.send();
    }

    function viewProof(imagePath) {
        console.log('Image Path: ' + imagePath);

        // Log the natural width and height of the image
        var img = new Image();
        img.src = imagePath;
        img.onload = function() {
            console.log('Image Natural Size: ' + img.naturalWidth + ' x ' + img.naturalHeight);
        };

        document.getElementById('schoolIdProofImage').src = imagePath;
        $('#viewProofModal').modal('show');
    }

    </script>

</body>
</html>

<?php
// Close connection
mysqli_close($link);
?>