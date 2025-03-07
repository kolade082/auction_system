<?php
session_start();
require 'as1csy2028.php';
$title = 'Manage Admin';
?>

<head>
    <title>ibuy Auctions</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<body>
    <?php require "layouts/header.php"; ?>
    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <main class="main-content">
        <div class="header-with-button">
                <h1>Dashboard</h1>
</div>
            <section class="dashboard-summary">
                <!-- Recent Auctions -->
                <article class="summary-item">
                    <h2>Recent Auctions</h2>
                    <div class="item-content">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Added By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $recentAuctions = $pdo->query("SELECT a.title, a.startDate, a.endDate, c.category_name, u.firstName, u.lastName FROM auction a 
                                                            JOIN category c ON a.category_id = c.category_id 
                                                            JOIN users u ON a.user_id = u.user_id 
                                                            ORDER BY a.startDate DESC LIMIT 5")->fetchAll();
                                foreach ($recentAuctions as $auction) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($auction['title']) . "</td>
                                            <td>" . htmlspecialchars($auction['category_name']) . "</td>
                                            <td>" . htmlspecialchars($auction['startDate']) . "</td>
                                            <td>" . htmlspecialchars($auction['endDate']) . "</td>
                                            <td>" . htmlspecialchars($auction['firstName']) . " " . htmlspecialchars($auction['lastName']) . "</td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </article>

                <!-- Recent Bids -->
                <article class="summary-item">
                    <h2>Recent Bids</h2>
                    <div class="item-content">
                    <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Lot Title</th>
                    <th>Bid Amount</th>
                    <th>Bidder</th>
                    <th>Bid Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query to fetch recent bids
                $recentBids = $pdo->query("SELECT l.lot_name, b.amount_bidded, u.firstName, u.lastName, b.bid_time FROM bids b
                                            JOIN lots l ON b.lot_id = l.lot_id
                                            JOIN users u ON b.user_id = u.user_id
                                            ORDER BY b.bid_time DESC LIMIT 10")->fetchAll();
                foreach ($recentBids as $bid) {
                    echo "<tr>
                            <td>" . htmlspecialchars($bid['lot_name']) . "</td>
                            <td>£" . htmlspecialchars($bid['amount_bidded']) . "</td>
                            <td>" . htmlspecialchars($bid['firstName']) . " " . htmlspecialchars($bid['lastName']) . "</td>
                            <td>" . htmlspecialchars($bid['bid_time']) . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
                    </div>
                </article>
                <!-- Manage Users -->
                <article class="summary-item">
                    <h2>Manage Users</h2>
                    <div class="item-content">
                        <?php
                        $totalUsers = $pdo->query("SELECT COUNT(*) AS total FROM users")->fetch();
                        echo "<p>Total Users: " . htmlspecialchars($totalUsers['total']) . "</p>";
                        ?>
                        <a href="manageUsers.php" class="manage-link">Go to User Management</a>
                    </div>
                </article>
                <!-- Additional Summary Item Example -->
                <article class="summary-item">
                    <h2>Upcoming Auctions</h2>
                    <div class="item-content">
                        <?php
                        $upcomingAuctions = $pdo->query("SELECT title, startDate FROM auction WHERE startDate > NOW() ORDER BY startDate ASC LIMIT 5")->fetchAll();
                        foreach ($upcomingAuctions as $auction) {
                            echo "<p>Starting soon: " . htmlspecialchars($auction['title']) . " (Starts on: " . htmlspecialchars($auction['startDate']) . ")</p>";
                        }
                        ?>
                    </div>
                </article>
                <!-- Recent User Registrations -->
                <article class="summary-item">
                    <h2>Recent User Registrations</h2>
                    <div class="item-content">
                        <table class="dashboard-table">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $recentUsers = $pdo->query("SELECT user_id, firstName, lastName, email FROM users ORDER BY user_id DESC LIMIT 5")->fetchAll();
                                foreach ($recentUsers as $user) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($user['user_id']) . "</td>
                                            <td>" . htmlspecialchars($user['firstName']) . "</td>
                                            <td>" . htmlspecialchars($user['lastName']) . "</td>
                                            <td>" . htmlspecialchars($user['email']) . "</td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </article>



            </section>
        </main>
    </div>
    <?php require 'layouts/footer.php'; ?>
</body>
</html>
