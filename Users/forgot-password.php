<?php
session_start();
require_once "config.php";

$email = $email_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (empty($email)) {
        $email_err = "Please enter your email.";
    } else {
        // Check if the email exists in the database
        $sql = "SELECT id, email FROM user WHERE email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            $param_email = $email;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Generate a unique token
                    $token = bin2hex(random_bytes(32));

                    // Store the token and timestamp in the database
                    $sql = "UPDATE user SET reset_token = ?, reset_timestamp = CURRENT_TIMESTAMP WHERE email = ?";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        mysqli_stmt_bind_param($stmt, "ss", $param_token, $param_email);
                        $param_token = $token;
                        if (mysqli_stmt_execute($stmt)) {
                            echo '<div class="alert alert-success">Token generated. <a href="reset-password.php?token=' . $token . '">Reset Password</a></div>';
                        } else {
                            echo '<div class="alert alert-danger">Oops! Something went wrong. Please try again later.</div>';
                        }

                        // Close the statement
                        mysqli_stmt_close($stmt);
                    } else {
                        // Handle the case where prepare fails
                        echo '<div class="alert alert-danger">Oops! Something went wrong: ' . mysqli_error($link) . '</div>';
                    }
                } else {
                    $email_err = "No account found with that email.";
                }
            } else {
                echo '<div class="alert alert-danger">Oops! Something went wrong: ' . mysqli_error($link) . '</div>';
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close the connection outside of the else block
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Login</title>
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

        .btn btn-primary{
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

        input[type="text"],
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
            <img src="../image/logo.png" class="logologin" alt="Logo">
            </div>
            <div class="right-column">
                <h2>Forgot Password</h2>
                <p>Enter your email address to reset your password.</p>

                <?php
                if (!empty($email_err)) {
                    echo '<div class="alert alert-danger">' . $email_err . '</div>';
                }
                ?>

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Reset Password">

                </form>
            </div>
        </div>
    </center>
</body>
</html>
