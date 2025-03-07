<?php
session_start();
require 'as1csy2028.php';
$message = "";

if ($_POST) {
    if (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email =:email LIMIT 1');
        $values = [
            'email' => $_POST['email']
        ];
        $stmt->execute($values);
        $user = $stmt->fetch();
        if ($user) {
            $chkPassword = password_verify($_POST['password'], $user["password"]);
            if ($chkPassword) {
                //  valid
                $_SESSION['loggedin'] = $user['user_id'];
                $_SESSION['userDetails'] = $user;

                header("Location: index.php");
            } else {
                // invalid cred - 
                $message = "Invalid Cred"; // password
            }
        } else {
            $message = "Invalid Cred"; // email
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Fotheby's - Login</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <?php require "layouts/header.php"; ?>

    <main>
        <?php echo $message; ?>
        <form action="" method="POST" id="login-form">
            <h2 class="sub-menus">Log in to your account</h2>
            <input type="text" name="email" class="myinput" required placeholder="Email address" />
            <input type="password" name="password" class="myinput" required placeholder="Password" />
            <!-- <input type="submit" value="Log in" name="submit" /> -->
            <div class="form-footer">
                <a href="#" class="forgot-password">Forgot your password?</a>
                <input type="submit" value="Log in" name="submit" />
            </div>
            <div class="sign-up">
                Don't have an account? <a href="register.php">Sign up</a>
            </div>
        </form>

    </main>


</body>

</html>