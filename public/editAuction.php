<?php
session_start();
require 'as1csy2028.php';
$title = 'Edit Auction';

function uploadImage($file)
{
    if (empty($file['name'])) {
        return false; // No file was selected for upload
    }

    $target_dir = "images/auctions/";
    $target_file = $target_dir . basename($file["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size and file type here...

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


if ($_POST) {
    $newImage = uploadImage($_FILES["auctionImage"]);

    $imageToUse = $newImage ? $newImage : $_POST['currentImage'];

    $stmt = $pdo->prepare('UPDATE auction SET title =:title,
        auction_description =:auction_description, category_id = :category_id, startDate =:startDate, endDate =:endDate, image = :image
        WHERE auction_id =:auction_id;

');
    $values = [
        'auction_id' => $_GET['auction_id'],
        'title' => $_POST['title'],
        'auction_description' => $_POST['auction_description'],
        'category_id' => $_POST['category_id'],
        'startDate' => $_POST['startDate'],
        'endDate' => $_POST['endDate'],
        'image' => $imageToUse
    ];
    // $stmt->execute($values);
    if ($stmt->execute($values)) {
        // Set session variable to indicate success
        $_SESSION['auctionUpdated'] = true;
    }
    header('Location: manageAuction.php');
    exit();
    // echo '<script> alert("Auction details updated") </script>';
}
$stmt = $pdo->prepare('SELECT * FROM auction WHERE auction_id = :auction_id');

$values = [
    'auction_id' => $_GET['auction_id']
];
$stmt->execute($values);
$auction = $stmt->fetch();

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
        <div class="main-content">
            <h1>Edit Auction</h1>
            <div class="content">
                <form action="" method="post" enctype="multipart/form-data" class="edit-auction-form">
                    <div class="form-group">
                        <!-- <p class="delete"> <a href='deleteAuction.php?auction_id=<?php echo $auction["auction_id"] ?>'>DELETE</a></p> -->
                        <label for="title">Auction Title:</label>
                        <input type="text" name="title" value="<?php echo $auction['title']; ?>" class="form-control" placeholder="title" />
                    </div>
                    <div class="form-group">
                        <label for="auctionDescription">Auction Description:</label>
                        <textarea name="auction_description" id="auction_description" name="auction_description" class="form-control" placeholder="Enter description here ...."><?php echo $auction['auction_description']; ?> </textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select name="category_id" class="form-control">
                            <?php
                            $stmt = $pdo->prepare("SELECT * FROM category");
                            $stmt->execute();
                            $categories = $stmt->fetchAll();
                            foreach ($categories as $row) {
                                if ($row['category_id'] == $auction['category_id']) {
                                    $cat = 'selected';
                                } else {
                                    $cat = '';
                                }
                                echo '<option ' . $cat . ' value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
    <label for="start">Start Date:</label>
    <input type="datetime-local" id="start" name="startDate" value="<?php echo date_create($auction['startDate'])->format("Y-m-d\TH:i"); ?>" class="form-control" min="2022-11-01T00:00" required>
</div>
<div class="form-group">
    <label for="end">End Date:</label>
    <input type="datetime-local" id="end" name="endDate" value="<?php echo date_create($auction['endDate'])->format("Y-m-d\TH:i"); ?>" class="form-control" min="2022-11-01T00:00" max="2024-02-01T23:59" required>
</div>

                    <div class="form-group image-preview">
                        <label>Current Image:</label>
                        <div class="image-container">
                            <img src="../images/auctions/<?php echo htmlspecialchars($auction['image']); ?>" alt="Current Auction Image">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="auctionImage">Change Auction Image:</label>
                        <input type="file" id="auctionImage" name="auctionImage" class="form-control-file">
                        <input type="hidden" name="currentImage" value="<?php echo htmlspecialchars($auction['image']); ?>">
                    </div>

                    <!-- <input type="submit" value="Update" name="submit" /> -->
                    <button type="submit" value="Update" name="submit" class="btn-submit">Update Auction</button>
                </form>
            </div>
        </div>
    </div>

    <?php require "layouts/footer.php"; ?>


</body>

</html>