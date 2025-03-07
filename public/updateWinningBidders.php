<?php
session_start();
require 'as1csy2028.php'; // Your PDO database connection script

// Fetch all auctions that have ended without a winning bidder
$expiredAuctions = $pdo->query("SELECT auction_id FROM auction WHERE endDate <= NOW() AND winning_bidder_id IS NULL")->fetchAll();

foreach ($expiredAuctions as $auction) {
    // Find the highest bid for each expired auction
    $stmt = $pdo->prepare("SELECT user_id, MAX(amount_bidded) AS max_bid FROM bids WHERE auction_id = :auction_id GROUP BY user_id ORDER BY max_bid DESC LIMIT 1");
    $stmt->execute(['auction_id' => $auction['auction_id']]);
    $winningBid = $stmt->fetch();

    if ($winningBid) {
        // Update the auction with the winning bidder's ID
        $updateStmt = $pdo->prepare("UPDATE auction SET winning_bidder_id = :user_id WHERE auction_id = :auction_id");
        $updateStmt->execute(['user_id' => $winningBid['user_id'], 'auction_id' => $auction['auction_id']]);
    }
}

echo "Updated winning bidders for expired auctions.";
?>
