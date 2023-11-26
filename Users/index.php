<?php
session_start();

if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: homepage.php");
    exit;
}

require_once "config.php";

$email = $password = "";
$email_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($email_err) && empty($password_err)) {

        $sql = "SELECT id, role, email, password, status FROM user WHERE email = ?";

        if ($stmt = mysqli_prepare($link, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_email);

            $param_email = $email;

            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {

                    mysqli_stmt_bind_result($stmt, $id, $user_role, $email, $hashed_password, $user_status);

                    if (mysqli_stmt_fetch($stmt)) {

                        if ($user_status === 'approved') { // Check user status
                            if (password_verify($password, $hashed_password)) {
                                $_SESSION["loggedin"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["role"] = $user_role;
                                $_SESSION["email"] = $email;

                                if ($user_role === "admin") {
                                    header("location: ../Admin/dashboard.php");
                                } else {
                                    header("location: ../Users/homepage.php");
                                }
                            } else {
                                $login_err = "Invalid email or password.";
                            }
                        } else {
                            $login_err = "Your account is still pending approval. Please wait for admin approval.";
                        }
                    }
                } else {
                    $login_err = "Invalid email or password.";
                }
            } else {
                $login_err = "Oops! Something went wrong. Please try again later.";
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
            width: auto;
            max-width: 800px;
            background: transparent;
            border-radius: 20px;
            box-shadow: 3px 10px 12px #145DA0;
            backdrop-filter: blur(10px) brightness(85%);
            display: flex;
        }

        .left-column {
            width: 40%;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right-column {
            width: 60%;
            padding: 2rem;
            box-sizing: border-box;
        }

        .right-column h2 {
            font-size: 70px;
            font-weight: bold;
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

        .btn{
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
        input[type="password"] {
            width: 100%;
            font-size: 16px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .logologin {
            height: 21rem;
            width: 50rem;
            padding-right: -3rem;
            margin-left: 6rem;
            margin-right: 3rem;
        }

        .account-links {
            margin-top: 5px;
        }

        .account-links a {
            color: #fff;
            font-size: 16px;
        }

        .account-links p {
            color: #fff;
            text-decoration: none;
            font-size: 16px;

        }
        .account-links a:hover {
            color: aquamarine;
            text-decoration: underline;
        }
    </style>


</head>
<body>
<center>
        <div class="container">
            <div class="left-column">
                <img src="../image/lc.png" class="logologin" alt="Logo">
            </div>

            <div class="right-column">
                <h2>Login</h2>
                <p>Please fill in your credentials to login.</p>

                <?php
                if (!empty($login_err)) {
                    echo '<div class="alert alert-danger">' . $login_err . '</div>';
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $email; ?>">
                        <span class="invalid-feedback"><?php echo $email_err; ?></span>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                            value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                  
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>

                    <div class="account-links">
                        <p>Don't have an account? <a href="signup.php">Sign Up here.</a></p>
                    </div>
                </form>

                
            </div>    
        </div>
    </center>
</body>
</html>
