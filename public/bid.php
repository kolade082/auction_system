<?php
session_start();
require 'as1csy2028.php';
$title = 'Bid';

if ($_POST) {
    if (!isset($_SESSION['userDetails'])) {
        header("Location: login.php");
        exit; // Always call exit after headers redirect
    } 
    $bidAmount = $_POST['amount_bidded'];
    $lotId = $_POST['lot_id'];

    // Fetch the highest bid for the lot
    $stmt = $pdo->prepare("SELECT MAX(amount_bidded) as highest_bid FROM bids WHERE lot_id = ?");
    $stmt->execute([$lotId]);
    $highestBid = $stmt->fetch();

    if ($bidAmount <= (int)$highestBid['highest_bid']) {
        // Redirect back with an error message if the bid is too low
        header("Location: productDetails.php?lot_id=$lotId&error=low_bid");
        exit;
    }

    
        $stmt = $pdo->prepare('INSERT INTO bids (amount_bidded, user_id, lot_id, bid_time) VALUES (:amount_bidded, :user_id, :lot_id, :bid_time)');
        $values = [
            'amount_bidded' => $_POST['amount_bidded'],
            'user_id' => $_SESSION['userDetails']["user_id"], // Corrected here
            'lot_id' => $_POST['lot_id'],
            'bid_time' => date('Y-m-d H:i:s') // Current date and time
        ];

        $stmt->execute($values);
        header('Location: productDetails.php?lot_id=' . $_POST['lot_id']);
        exit; // It's a good practice to call exit after redirection
    
}
