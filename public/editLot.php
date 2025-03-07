<?php
session_start();
require 'as1csy2028.php';
$title = 'Edit Lot';

// Fetch available auctions for the dropdown
$auctionStmt = $pdo->prepare("SELECT auction_id, title FROM auction");
$auctionStmt->execute();
$auctions = $auctionStmt->fetchAll();

// Check if lot_id is set in the query string
if (!isset($_GET['lot_id'])) {
    header('Location: manageLots.php'); // Redirect to the manage lots page if lot_id is not set
    exit();
}

$lot_id = $_GET['lot_id'];

// Fetch the existing lot details from the database
$stmt = $pdo->prepare("SELECT * FROM lots WHERE lot_id = :lot_id");
$stmt->execute(['lot_id' => $lot_id]);
$lot = $stmt->fetch();

if (!$lot) {
    header('Location: manageLots.php'); // Redirect if the lot doesn't exist
    exit();
}

function uploadLotImage($file) {
    if (empty($file['name'])) {
        return false;
    }

    $target_dir = "images/lots/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Add your own checks for file size, type, etc. here...

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        return false;
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return basename($file["name"]);
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }
}
if ($_POST && isset($_POST['submit'])) {
    $newImage = false;
    if (isset($_FILES["lotImage"]) && $_FILES["lotImage"]["error"] == UPLOAD_ERR_OK) {
        $newImage = uploadLotImage($_FILES["lotImage"]);
    }
    $imageToUse = $newImage ? $newImage : $_POST['currentImage'];
    // Update logic here
      // Update logic
      $updateStmt = $pdo->prepare("UPDATE lots SET lot_name = :lot_name, lot_description = :lot_description, 
      estimated_price = :estimated_price, auction_id = :auction_id, image = :image
      WHERE lot_id = :lot_id");

    // Assuming you are handling the image update separately
    $values = [
        'lot_name' => $_POST['lot_name'],
        'lot_description' => $_POST['lot_description'],
        'estimated_price' => $_POST['estimated_price'],
        'auction_id' => $_POST['auction_id'],
        'image' => $imageToUse,
        'lot_id' => $lot_id
    ];

    $updateSuccessful = $updateStmt->execute($values);

    if ($updateSuccessful) {
        $_SESSION['lotUpdated'] = true; // Set a flag for successful update
        header("Location: manageLots.php"); // Redirect to the manage lots page
        exit();
    }
    // Optionally, you might want to handle the case where the update is not successful
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Lot</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<body>
    <?php require "layouts/header.php"; ?>

    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <div class="main-content">
            <h1>Edit Lot</h1>
            <div class="content">
            <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="lotName">Lot Name:</label>
                        <input type="text" id="lotName" name="lot_name" value="<?php echo htmlspecialchars($lot['lot_name']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lotDescription">Lot Description:</label>
                        <textarea id="lotDescription" name="lot_description" class="form-control" required><?php echo htmlspecialchars($lot['lot_description']); ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="estimatedPrice">Estimated Price:</label>
                        <input type="number" id="estimatedPrice" name="estimated_price" value="<?php echo htmlspecialchars($lot['estimated_price']); ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="auction_id">Auction Event:</label>
                        <select id="auction_id" name="auction_id" class="form-control" required>
                            <?php foreach ($auctions as $auction): ?>
                                <option value="<?php echo $auction['auction_id']; ?>" <?php echo $auction['auction_id'] == $lot['auction_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($auction['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group image-preview">
                    <label>Current Image:</label>
                    <div class="image-container">
                        <img src="images/lots/<?php echo htmlspecialchars($lot['image']); ?>" alt="Current Lot Image">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lotImage">Change Lot Image:</label>
                    <input type="file" id="lotImage" name="lotImage" class="form-control-file">
                    <input type="hidden" name="currentImage" value="<?php echo htmlspecialchars($lot['image']); ?>">
                </div>
                    <button type="submit" name="submit" class="btn-submit">Update Lot</button>
                </form>
            </div>
        </div>
    </div>

    <?php require "layouts/footer.php"; ?>
</body>
</html>
