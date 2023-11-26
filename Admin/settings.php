<?php
session_start();

include '../Users/config.php';

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

// Fetch user ID from the session
$user_id = $_SESSION['id'];

// Fetch user data from the database
$sql = "SELECT `id`, `role`, `date_created`, `first_name`, `last_name`, `username`, `email`, `password` FROM `user` WHERE `id` = $user_id";
$result = mysqli_query($link, $sql);

// Check for query execution success
if (!$result) {
    die("Error in SQL query: " . mysqli_error($link));
}

// Check if there is a user with the given ID
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    die("User not found");
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

        body {
            background: var(--grey);
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

        .form-group {
            margin-bottom: 10px;
        }

        .form-label {
            display: block;
            font-size: 17px;
            font-family: var(--poppins);
        }

        .form-control {
            width: 100%;
            height: 35px;
            border: none;
            border-radius: 5px;
            padding: 10px;
        }

        .text-right {
            text-align: right;
        }

        .btn-primary,
        .btn-default {
            cursor: pointer;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .btn-default {
            background-color: #ccc;
            color: #333;
        }

        .btn-default:hover {
            background-color: #999;
            color: #fff;
        }

        h5{
            font-family: var(--poppins);
            font-size: 30px;
        }
    </style>

    <title>Admin Profile</title>
</head>
<body>
<?php include 'admin_navbar.php'; ?>

    <!-- CONTENT -->
    <section id="content">
        <!-- MAIN -->
        <main>
            <div class="card-body">
                <form action="settings_update.php" method="post">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" value="<?php echo $user['username']; ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="<?php echo $user['first_name']; ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="<?php echo $user['last_name']; ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">E-mail</label>
                        <input type="text" class="form-control" name="email" value="<?php echo $user['email']; ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Current password</label>
                        <input type="password" class="form-control" name="current_password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">New password</label>
                        <input type="password" class="form-control" name="new_password">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Repeat new password</label>
                        <input type="password" class="form-control" name="repeat_password">
                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary" name="save_changes">Save changes</button>&nbsp;
                        <button type="button" class="btn btn-default">Cancel</button>
                    </div>
                </form>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

</body>
</html>
