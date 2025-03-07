<?php
session_start();
require 'as1csy2028.php';
$title = 'Edit Admin';
// $message = "";
if ($_POST) {
        if (isset($_POST['submit'])) {
                if ($_POST['password'] != "") {
                        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                } else {
                        $stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');

                        $values = [
                                'user_id' => $_GET['user_id']
                        ];

                        // unset($_POST['submit']);
                        $stmt->execute($values);
                        $user = $stmt->fetch();
                        $password = $user['password'];
                }
                $stmt = $pdo->prepare('UPDATE users SET
firstName =:firstName,
lastName =:lastName,
password =:password,
email =:email
WHERE user_id =:user_id;

');
                $values = [
                        'firstName' => $_POST['firstName'],
                        'lastName' => $_POST['lastName'],
                        'password' => $password,
                        'email' => $_POST['email'],
                        'user_id' => $_GET['user_id']
                ];
                // unset($_POST['submit']);
                $stmt->execute($values);
                header('Location: manageAdmins.php');
                exit;
        }
}
$stmt = $pdo->prepare('SELECT * FROM users WHERE user_id = :user_id');

$values = [
        'user_id' => $_GET['user_id']
];

// unset($_POST['submit']);
$stmt->execute($values);
$user = $stmt->fetch();
?>
<head>
    <title>Edit Users - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>


<body>
        <?php require "layouts/header.php"; ?>
        <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <div class="main-content">
            <h1>Edit User</h1>
            <div class="content">
                <form action="" method="POST">
                <div class="form-group">
                        <label for="fistName">First Name:</label>
                        <input type="text" name="firstName" value="<?php echo $user['firstName']; ?>" class="form-control" placeholder="First Name" />
                </div>
                <div class="form-group">
                        <label for="lastName">Last Name:</label>
                        <input type="text" name="lastName" value="<?php echo $user['lastName']; ?>" class="form-control" placeholder="Last Name" />
                </div>
                <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type="mail" name="email" value="<?php echo $user['email']; ?>" class="form-control" placeholder="Email" />
                </div>
                <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" value="" class="form-control" placeholder="Password" />
                </div>
                        <button type="submit" value="Update" name="submit" class="btn-submit">Update</button>
                </form>
                <?php require "layouts/footer.php"; ?>
        </main>
</body>

</html>