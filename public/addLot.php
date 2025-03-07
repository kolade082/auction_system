<?php
session_start();
require 'as1csy2028.php';
$title = 'Add Lot';
$showModal = false;

// Fetch available auctions for the dropdown
$stmt = $pdo->prepare("SELECT auction_id, title FROM auction");
$stmt->execute();
$auctions = $stmt->fetchAll();

if ($_POST) {
    if (isset($_POST['submit'])) {
        // File upload logic
        $target_dir = "images/lots/";
        $target_file = $target_dir . basename($_FILES["lotImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Insert lot into the database
        $stmt = $pdo->prepare('INSERT INTO lots(lot_name, lot_description, estimated_price, auction_id, image, user_id)
                                VALUES(:lot_name, :lot_description, :estimated_price, :auction_id, :image, :user_id)
    ');
        $values = [
            'lot_name' => $_POST['lot_name'],
            'lot_description' => $_POST['lot_description'],
            'estimated_price' => $_POST['estimated_price'],
            'auction_id' => $_POST['auction_id'],
            'image' => $_FILES["lotImage"]["name"],
            'user_id' => $_SESSION['userDetails']["user_id"] // assuming you store user details in session
        ];
        $stmt->execute($values);

        // Image upload checks
        $check = getimagesize($_FILES["lotImage"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
            if ($uploadOk) {
                move_uploaded_file($_FILES["lotImage"]["tmp_name"], $target_file);
                $_SESSION['showModal'] = true;
                header("Location: addLot.php"); // Redirect to avoid resubmission
                exit;
            }
        } else {
            $uploadOk = 0;
        }
    }
}

if (isset($_SESSION['showModal']) && $_SESSION['showModal']) {
    $showModal = true;
    unset($_SESSION['showModal']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Lot - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<body>
    <?php require "layouts/header.php"; ?>

    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <div class="main-content">
            <h1>Add Lot</h1>
            <div class="content">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="lotName">Lot Name:</label>
                        <input type="text" id="lotName" name="lot_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lotDescription">Lot Description:</label>
                        <textarea id="lotDescription" name="lot_description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="estimatedPrice">Estimated Price:</label>
                        <input type="number" id="estimatedPrice" name="estimated_price" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="auction_id">Auction Event:</label>
                        <select id="auction_id" name="auction_id" class="form-control" required>
                            <?php foreach ($auctions as $auction) {
echo '<option value="' . $auction['auction_id'] . '">' . htmlspecialchars($auction['title']) . '</option>';
} ?>
</select>
</div>
<div class="form-group">
<label for="lotImage">Lot Image:</label>
<input type="file" id="lotImage" name="lotImage" class="form-control-file">
</div>
<button type="submit" name="submit" class="btn-submit">Add Lot</button>
</form>
</div>
</div>
</div>
<div id="lotAddedModal" class="modal" style="<?php echo $showModal ? 'display:block;' : 'display:none;'; ?>">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p>Lot added successfully!</p>
    </div>
</div>

<?php require "layouts/footer.php"; ?>
<script>
    // JavaScript to handle the modal
    var modal = document.getElementById("lotAddedModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
</body>
</html>

