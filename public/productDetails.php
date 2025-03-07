<?php
session_start();
require 'as1csy2028.php';
$title = "Lot Details";

// Error message handling
$errorMessage = '';
if (isset($_GET['error']) && $_GET['error'] === 'low_bid') {
    $errorMessage = 'Your bid must be higher than the current highest bid.';
}

// Adjust the query to fetch details from the 'lot' table
$stmt = $pdo->prepare("SELECT l.lot_id, l.lot_name, l.lot_description, l.image as lot_image, a.auction_id, a.title as auction_title, a.endDate, a.category_id, c.category_name AS catName, u.firstName, u.lastName, MAX(b.amount_bidded) AS amount_bidded FROM lots l
    JOIN auction a ON l.auction_id = a.auction_id
    JOIN category c ON a.category_id = c.category_id
    JOIN users u ON a.user_id = u.user_id
    LEFT JOIN bids b ON l.lot_id = b.lot_id
    WHERE l.lot_id = :lot_id GROUP BY l.lot_id");
$stmt->execute(['lot_id' => $_GET['lot_id']]);
$lot = $stmt->fetch();


$endDate = new DateTime($lot['endDate']);
$now = new DateTime();
$auctionExpired = $endDate <= $now;



if (!$auctionExpired) {
    $interval = $now->diff($endDate);
    $days = $interval->days;
    $hours = $interval->h;
    $minutes = $interval->i;
    $timeDisplay = "$days days, $hours hours, and $minutes minutes";
} else {
    $timeDisplay = "Auction Expired";
}
?>

<head>
    <title>Lot Details</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <style>
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php require "layouts/header.php"; ?>

    <main>
        <article class="product">
            <img src="images/lots/<?php echo htmlspecialchars($lot['lot_image']); ?>">
            <section class="details">
                <h2>Lot Name: <?php echo htmlspecialchars($lot['lot_name']); ?></h2>
                <h3>Category: <?php echo htmlspecialchars($lot['catName']); ?></h3>
                <p>Auction Title: <?php echo htmlspecialchars($lot['auction_title']); ?></p>
                <p class="price">Current bid: £<?php echo htmlspecialchars($lot['amount_bidded'] ?? '0'); ?></p>
                <time>Time left: <?php echo $timeDisplay; ?></time>
                <?php if (!$auctionExpired) : ?>
                    <?php if ($errorMessage): ?>
                        <p class="error-message"><?php echo $errorMessage; ?></p>
                    <?php endif; ?>
                    <form action="bid.php" class="bid" method="post">
                        <input type="text" name="amount_bidded" placeholder="Enter bid amount" />
                        <input class="placeBid" type="submit" value="Place bid" />
                        <input hidden name="lot_id" value="<?php echo $lot['lot_id']; ?>" />
                    </form>
                <?php else : ?>
                    <p>This auction has expired and is no longer accepting bids.</p>
                <?php endif; ?>
            </section>
            <section class="productDescription">
                <p><?php echo htmlspecialchars($lot['lot_description']); ?></p>
            </section>
        </article>
        <?php require "reviewForm.php"; ?>
    </main>

    <?php require "layouts/footer.php"; ?>
</body>

</html>
