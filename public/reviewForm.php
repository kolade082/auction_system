<?php
if ($_POST) {
    $date = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare('INSERT INTO reviews(comments, lot_id, user_id, review_date)
                                VALUES (:comments, :lot_id, :user_id, :review_date)
    ');
    $values = [
        'comments' => $_POST['comments'],
        'lot_id' => $_GET['lot_id'], // Changed from auction_id to lot_id
        'user_id' => $_SESSION['userDetails']["user_id"],
        'review_date' => $date
    ];

    $stmt->execute($values);
    
}

$stmt = $pdo->prepare("SELECT r.user_id, u.firstName, u.lastName, u.user_id, r.comments, r.review_date FROM reviews r 
    JOIN users u ON r.user_id = u.user_id
    WHERE lot_id = :lot_id"); // Changed from auction_id to lot_id
$stmt->execute(['lot_id' => $_GET['lot_id']]); // Changed from auction_id to lot_id
$reviews = $stmt->fetchAll();
?>

<section class="reviews">
    <h2><strong>Bidders Chat</strong></h2>
    <?php foreach ($reviews as $row): ?>
        <ul>
            <li><strong><?php echo htmlspecialchars($row['firstName'] . " " . $row['lastName']); ?></strong> said <?php echo htmlspecialchars($row['comments']); ?> <em><strong><?php echo htmlspecialchars($row['review_date']); ?></strong></em></li>
        </ul>
    <?php endforeach; ?>
    <form action="" method="POST">
        <label>Add your comment</label>
        <textarea name="comments"></textarea>
        <input type="submit" name="submit" value="SEND" />
    </form>
</section>
</article>