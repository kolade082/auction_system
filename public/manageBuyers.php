<?php
session_start();
require 'as1csy2028.php';
$title = 'Manage Buyers';

// Query to find the highest bid for each lot
$sql = "SELECT u.user_id, u.firstName, u.lastName, u.email, l.lot_name, 
        MAX(b.amount_bidded) AS highest_bid, a.endDate, 
        CASE WHEN a.endDate > NOW() THEN 'In Progress' ELSE 'Ended' END AS auction_status
        FROM bids b
        JOIN lots l ON b.lot_id = l.lot_id
        JOIN users u ON b.user_id = u.user_id
        JOIN auction a ON l.auction_id = a.auction_id
        GROUP BY l.lot_id
        ORDER BY highest_bid DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();

?>


<head>
    <title>Manage Buyers - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
<?php require "layouts/header.php"; ?>
    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <div class="main-content">
        <div class="header-with-button">
            <h1>Manage Buyers</h1>
        </div>
            <div class="content">
                    <table class="category-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Won Lot</th>
                            <th>Highest Bid</th>
                            <th>Auction Status</th> <!-- New column for auction status -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['firstName']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastName']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['lot_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['highest_bid']); ?></td>
                                <td><?php echo htmlspecialchars($row['auction_status']); ?></td> <!-- Display auction status -->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>

               </div>
        </div>
    </div>
</body>

</html>