<?php
session_start();
require_once "config.php";

// Check if the token is present in the URL
if (!isset($_GET["token"])) {
    header("location: forgot-password.php");
    exit;
}

$token = $_GET["token"];
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Validate password
    if (empty($password)) {
        $password_err = "Please enter a new password.";
    } elseif (strlen($password) < 6) {
        $password_err = "Password must have at least 6 characters.";
    }

    // Validate confirm password
    if (empty($confirm_password)) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        if ($password != $confirm_password) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check for errors before updating the password
    if (empty($password_err) && empty($confirm_password_err)) {
        // Update the user's password in the database
        $sql = "UPDATE user SET password = ? WHERE reset_token = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $token);

            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully, remove the reset_token
                $sql = "UPDATE user SET reset_token = NULL, reset_timestamp = NULL WHERE reset_token = ?";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    mysqli_stmt_bind_param($stmt, "s", $token);
                    mysqli_stmt_execute($stmt);
                }

                echo '<div class="alert alert-success">Password reset successfully. <a href="index.php">Login</a></div>';
            } else {
                echo '<div class="alert alert-danger">Oops! Something went wrong. Please try again later.</div>';
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
    <title>Reset Password</title>
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
            max-width: 800px;
            background: transparent;
            border-radius: 20px;
            box-shadow: 3px 10px 12px #145DA0;
            backdrop-filter: blur(10px) brightness(85%);
            display: flex;
        }

        .left-column {
            width: 35%;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right-column {
            width: 65%;
            padding: 2rem;
            box-sizing: border-box;
        }

        .right-column h2 {
            font-size: 60px;
            font-weight: bold;
            white-space: nowrap;
        }

        .right-column p {
            font-size: 15px;
        }

        .right-column a {
            color: aquamarine;
        }

        label {
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            transition: .5s ease-in-out;
        }

        .btn.btn-primary {
            background-color: #1a1740;
            color: #fff;
            width: 120px;
            height: 45px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #4FC0D0;
            color: #000;
        }

        input[type="password"] {
            width: 100%;
            font-size: 16px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .logologin {
            height: 18rem;
            width: 47rem;
            padding-right: -3rem;
            margin-left: 6rem;
            margin-right: 3rem;
        }
    </style>
</head>
<body>
    <center>
        <div class="container">
            <div class="left-column">
                <!-- Add your logo or relevant content for the left column -->
            </div>
            <div class="right-column">
                <h2>Reset Password</h2>
                <p>Enter your new password below.</p>

                <?php
                if (!empty($password_err) || !empty($confirm_password_err)) {
                    echo '<div class="alert alert-danger">' . $password_err . ' ' . $confirm_password_err . '</div>';
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?token=' . $token; ?>" method="post">
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Reset Password">
                    </div>
                </form>
            </div>
        </div>
    </center>
</body>
</html>