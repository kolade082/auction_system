<?php
session_start();
require 'as1csy2028.php';
$title = 'Manage Sellers';
// $message = "";

$data = $pdo->query("SELECT * FROM users")->fetchAll();
// print_r($data);
?>

<head>
    <title>Manage Users - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
<?php require "layouts/header.php"; ?>
    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <div class="main-content">
        <div class="header-with-button">
                <h1>Manage All Users</h1>
                <!-- Button to Add Auction -->
                <a href="addAdmin.php" class="add-button">
                    <button class="add-auction"><i class="fas fa-plus"></i> Add User</button>
                </a>
        </div>
            <div class="content">
                <table class="category-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Usertype</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <?php foreach ($data as $row) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['firstName']); ?></td>
                            <td><?php echo htmlspecialchars($row['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['usertype']); ?></td>
                            <td>
                                <a href='editAdmin.php?user_id=<?php echo htmlspecialchars($row['user_id']); ?>'>
                                    <button class='edit'>EDIT</button>
                                </a>
                                <a href='deleteAdmin.php?user_id=<?php echo htmlspecialchars($row['user_id']); ?>'>
                                    <button class='delete'>DELETE</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
               </div>
        </div>
    </div>
</body>

</html>