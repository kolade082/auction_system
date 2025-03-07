<?php
session_start();
require 'as1csy2028.php';

$auction_id = isset($_GET['auction_id']) ? $_GET['auction_id'] : null;
$auction = null;
$lots = [];

if ($auction_id) {
    // Fetch the auction name
    $stmt = $pdo->prepare("SELECT title FROM auction WHERE auction_id = ?");
    $stmt->execute([$auction_id]);
    $auction = $stmt->fetch();

    // Prepare the SQL query for fetching lots
    $sql = "SELECT l.*, u.firstName, u.lastName FROM lots l 
            JOIN users u ON l.user_id = u.user_id 
            WHERE l.auction_id = ?";
    $params = [$auction_id];

// Check if price filter is set and modify the SQL and parameters accordingly
if (isset($_GET['price']) && is_array($_GET['price'])) {
    $priceConditions = [];
    foreach ($_GET['price'] as $priceRange) {
        if ($priceRange == '50000+') {
            $priceConditions[] = "l.estimated_price >= 50000";
        } else {
            list($minPrice, $maxPrice) = explode('-', $priceRange);
            $priceConditions[] = "(l.estimated_price BETWEEN ? AND ?)";
            $params[] = $minPrice;
            $params[] = $maxPrice;
        }
    }
    if (count($priceConditions) > 0) {
        $sql .= " AND (" . implode(' OR ', $priceConditions) . ")";
    }
}

    $lotsStmt = $pdo->prepare($sql);
    $lotsStmt->execute($params);
    $lots = $lotsStmt->fetchAll();

    // Prepare a statement to get the highest bid for a lot
    $bidStmt = $pdo->prepare("SELECT MAX(amount_bidded) as highest_bid FROM bids WHERE lot_id = ? GROUP BY lot_id");
} else {
    // Handle the case where auction_id is not set
    // Redirect, show error, or handle as needed
    echo "No auction selected.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Lots</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<body>
    <?php require "layouts/header.php"; ?>
    <div class="content-container">
    <aside class="sidebar-filter">
            <!-- Sidebar content -->
            <h2>Filter By</h2>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
    <!-- Hidden field for retaining auction_id -->
    <input type="hidden" name="auction_id" value="<?php echo htmlspecialchars($auction_id); ?>">
                <!-- Filter for Price -->
                <div class="filter-group">
                    <h4 class="filter-title"><i class="fas fa-dollar-sign"></i>  Price</h4>
                    <ul class="filter-options">
                        <li><input type="checkbox" id="price1-1000" name="price[]" value="1-1000"><label for="price1-1000">£1 - £1,000</label></li>
                        <li><input type="checkbox" id="price1001-5000" name="price[]" value="1001-5000"><label for="price1001-5000">£1,001 - £5,000</label></li>
                        <li><input type="checkbox" id="price5001-10000" name="price[]" value="5001-10000"><label for="price5001-10000">£5,001 - £10,000</label></li>
                        <li><input type="checkbox" id="price10001-49000" name="price[]" value="10001-49000"><label for="price10001-49000">£10,001 - £49,000</label></li>
                        <li><input type="checkbox" id="price50000+" name="price[]" value="50000+"><label for="price50000+">£50,000+</label></li>
                    </ul>
                </div>
                <div class="filter-button">
                    <input type="submit" value="Filter" />
                </div>
            </form>
        </aside>
        <div class="=lots-container">
            <!-- <div class="lots-header"> -->
                <h1>Lots for Auction: <?php echo htmlspecialchars($auction['title']); ?></h1>
            <!-- </div> -->
            <div class="lots-wrapper">
                <?php foreach ($lots as $lot): 
                    // Execute the statement for each lot
                    $bidStmt->execute([$lot['lot_id']]);
                    $bid = $bidStmt->fetch();
                    $currentBid = $bid && $bid['highest_bid'] ? '£' . htmlspecialchars($bid['highest_bid']) : 'No bids yet';
                ?>
                    <div class="lot-item">
                        <img src="images/lots/<?php echo htmlspecialchars($lot['image']); ?>" alt="Lot Image">
                        <div class="lot-info">
                            <h2><?php echo htmlspecialchars($lot['lot_name']); ?></h2>
                            <p><?php echo htmlspecialchars($lot['lot_description']); ?></p>
                            <p>Auctioneer: <?php echo htmlspecialchars($lot['firstName']) . " " . htmlspecialchars($lot['lastName']); ?></p>
                            <p class="price">Estimated Price: £<?php echo htmlspecialchars($lot['estimated_price']); ?></p>
                            <p class="current-bid">Current Bid: <?php echo $currentBid; ?></p>
                            <a href="productDetails.php?lot_id=<?php echo htmlspecialchars($lot['lot_id']); ?>">
                                <button>Place Bid</button>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php require "layouts/footer.php"; ?>
</body>
</html>
