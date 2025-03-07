<?php
session_start();
require 'as1csy2028.php';
$title = 'Add Admin';



if ($_POST) {
        if (isset($_POST['submit'])) {
                $password =  password_hash($_POST['password'], PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users(firstName, lastName, email, password, usertype)
                                        VALUES(:firstName, :lastName, :email, :password, :usertype)
        ');
                $values = [
                        'firstName' => $_POST['firstName'],
                        'lastName' => $_POST['lastName'],
                        'email' => $_POST['email'],
                        'password' => $password,
                        'usertype' => $_POST['usertype'],
                ];
                // unset($_POST['submit']);
                $stmt->execute($values);
                header("Location: manageUsers.php");
                echo '<script>alert("New admin added")</script>';
        }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Admin - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
        <?php require "layouts/header.php"; ?>

        <main>
                <form action="addAdmin.php" method="POST" id="login-form">
                        <h2 class="sub-menus">Add Seller/Admin</h2>
                        <input type="text" name="firstName" class="myinput" required placeholder="First Name" />
                        <input type="text" name="lastName" class="myinput" required placeholder="Last Name" />
                        <input type="text" name="email" class="myinput" required placeholder="Email address" />
                        <input type="password" name="password" class="myinput" required placeholder="Password" />
                        <select name="usertype" class="myinput" required>
                <option value="ADMIN">Admin</option>
                <option value="SELLER">Seller</option>
            </select>
                        <input type="submit" value="Sign Up" name="submit" />
                </form>
                <?php require "layouts/footer.php"; ?>
        </main>
</body>

</html>