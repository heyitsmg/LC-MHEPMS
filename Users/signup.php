<?php

require_once "config.php";

$default_role = "user";
$first_name = $last_name = $username = $email = $password = $confirm_password = $school_id_file = "";
$first_name_err = $last_name_err = $username_err = $email_err = $password_err = $confirm_password_err = $school_id_err = "";

function handleSchoolIDUpload() {
    global $school_id_file, $school_id_err;

    if (!isset($_FILES['school_id'])) {
        $school_id_err = "School ID file is required.";
        return;
    }

    if ($_FILES['school_id']['error'] !== UPLOAD_ERR_OK) {
        $school_id_err = "Error uploading the school ID.";
        return;
    }

    $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
    $fileExtension = pathinfo($_FILES['school_id']['name'], PATHINFO_EXTENSION);

    if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
        $school_id_err = "Invalid file format. Please upload a valid school ID document.";
        return;
    }

    $uploadDir = __DIR__ . "/uploads/";
    $school_id_file = uniqid() . '_' . basename($_FILES['school_id']['name']);
    $uploadPath = $uploadDir . $school_id_file;

    if (!move_uploaded_file($_FILES['school_id']['tmp_name'], $uploadPath)) {
        $school_id_err = "Error moving the uploaded file.";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    handleSchoolIDUpload();

    if (!empty($school_id_err)) {
        
        echo "<div class='alert alert-danger' role='alert'>";
        echo $school_id_err;
        echo "</div>";

        exit(); // or header("location: signup.php");
    }

    if (empty(trim($_POST["first_name"]))) {
        $first_name_err = "Please enter your first name.";
    } else {
        $first_name = trim($_POST["first_name"]);
    }

    if (empty(trim($_POST["last_name"]))) {
        $last_name_err = "Please enter your last name.";
    } else {
        $last_name = trim($_POST["last_name"]);
    }

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter your username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        }
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);

        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    $role = $default_role;

    if (empty($first_name_err) && empty($last_name_err) && empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err) && empty($school_id_err)) {
        $sql = "INSERT INTO user (role, first_name, last_name, username, email, password, school_id_file, status, date_created) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', NOW())";

        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sssssss", $param_role, $param_first_name, $param_last_name, $param_username, $param_email, $param_password, $param_school_id_file);

            $param_role = $role;
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_school_id_file = $school_id_file;

            if (mysqli_stmt_execute($stmt)) {
                header("location: registration-pending.php");
                exit();
            } else {
                if (mysqli_errno($link) === 1062) {
                    $email_err = "This email is already in use.";
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            background: url("../image/background2.jpeg");
            background-repeat: no-repeat;
            background-size: cover;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 250rem;
            height: 30rem;
            background: transparent;
            border-radius: 20px;
            box-shadow: 3px 10px 12px #145DA0;
            backdrop-filter: blur(10px) brightness(75%);
            display: flex;
        }

        .left-column {
            width: 50%;
            padding: 2rem;
            box-sizing: border-box;
            justify-content: center;
        }


        .right-column {
            width: 50%;
            padding: 2rem;
            box-sizing: border-box;
            justify-content: center;
        }    

        label {
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: .5s ease-in-out;
        }

        .btn {
            background-color: #1a1740;
            color: #fff;
            width: 120px;
            height: 45px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #4FC0D0;
            color: #000;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            font-size: 16px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .logologin {
            height: 15rem;
            width: 16rem;
            
        }

        .side {
            margin-top: auto;
            margin-bottom: auto;
            width: 40rem;
        }

        .side h2 {
            font-size: 75px;
            font-weight: bold;
            justify-content: center;

        }

        .side p {
            font-size: 15px;
        }

        .side a {
            color: aquamarine;
        }

        .account-links {
            margin-top: 5px;
        }

        .account-links a {
            color: #fff;
            text-decoration: underline;
            font-size: 16px;
        }

        .account-links p {
            color: #fff;
            text-decoration: none;
            font-size: 16px;

        }
        .account-links a:hover {
            color: aquamarine;
        }
    </style>
</head>

<body>
<center>
    <div class="container">

            <div class="side">
                
                <h2>Sign Up</h2>
                <p>Please fill this form to create an account.</p>
                <img src="../image/lc.png" class="logologin" alt="Logo">

            </div>

            <div class="left-column">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                    <span class="invalid-feedback"><?php echo $first_name_err; ?></span>
                </div>

                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                        <span class="invalid-feedback"><?php echo $last_name_err; ?></span>
                    </div>

                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>

            </div>
        
            <div class="right-column">

                    <div class="form-group">
                    <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>

                    <div class="form-group">
                    <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>School ID (Upload)</label>
                        <input type="hidden" name="MAX_FILE_SIZE" value="2097152"> <!-- 2 MB limit -->
                        <input type="file" name="school_id" class="form-control <?php echo (!empty($school_id_err)) ? 'is-invalid' : ''; ?>">
                        <span class="invalid-feedback"><?php echo $school_id_err; ?></span>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Signup">
                        <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                    </div>

                    <div class="account-links">
                        <p>Already have an account? <a href="index.php">Login here.</a></p>
                    </div>
            </div>
        </form>
    </div>
</center>
</body>
</html>