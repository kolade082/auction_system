<?php
session_start();
require 'as1csy2028.php';

if (isset($_GET['auction_id'])) {
    $isDeleted = $pdo->prepare("DELETE FROM auction WHERE auction_id=?")->execute([$_GET['auction_id']]);


    if ($isDeleted) {
        $_SESSION['auctionDeleted'] = true;
    }

    header("Location: manageAuction.php");
    exit();
}
