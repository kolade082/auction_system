<?php
require 'as1csy2028.php';

if (isset($_GET['category_id'])) {
    $stmt = $pdo->prepare("SELECT a.auction_id, a.user_id, a.title, a.auction_description, a.image, c.category_name AS catName, u.firstName, u.lastName FROM auction a 
    JOIN category c ON a.category_id = c.category_id
    JOIN users u ON a.user_id = u.user_id
    WHERE a.category_id = :category_id");
    $stmt->execute(['category_id' => $_GET['category_id']]);
    $auctions = $stmt->fetchAll();
} elseif (isset($_GET['search'])) {
    $s = "%" . $_GET['search'] . "%";
    $stmt = $pdo->prepare("SELECT a.auction_id, a.user_id, a.title, a.auction_description, a.image, c.category_name AS catName, u.firstName, u.lastName FROM auction a 
    JOIN category c ON a.category_id = c.category_id 
    JOIN users u ON a.user_id = u.user_id
    WHERE a.title LIKE ? OR a.auction_description LIKE ?");
    $stmt->execute([$s, $s]);
    $auctions = $stmt->fetchAll();
} else {
    $stmt = $pdo->prepare("SELECT a.auction_id, a.user_id, a.title, a.auction_description, a.image, c.category_name AS catName, u.firstName, u.lastName FROM auction a 
    JOIN category c ON a.category_id = c.category_id
    JOIN users u ON a.user_id = u.user_id
    LIMIT 10");
    $stmt->execute();
    $auctions = $stmt->fetchAll();
}

echo '<div class="carousel-container">';

echo '<div class="productList">';
foreach ($auctions as $row) {
    echo '<div class="productItem">';
    echo '<img src="images/auctions/' . htmlspecialchars($row['image']) . '">';
    echo '<article class="productDetails">';
    echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
    echo '<h3>' . 'Category Name: ' . htmlspecialchars($row['catName']) . '</h3>';
    echo '<p>' . htmlspecialchars($row['auction_description']) . '</p>';
    echo '<a href="lots.php?auction_id=' . htmlspecialchars($row['auction_id']) . '" class="more auctionLink">More &gt;&gt;</a>';
    echo '</article>';
    echo '</div>';
}
echo '</div>';

echo '<button id="slideLeft" onclick="moveCarousel(-1)">&#10094;</button>';
echo '<button id="slideRight" onclick="moveCarousel(1)">&#10095;</button>';

echo '</div>';
?>
