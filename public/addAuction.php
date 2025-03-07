<?php
session_start();
require 'as1csy2028.php';
$title = 'Add Auction';
$showModal = false;

$stmt = $pdo->prepare("SELECT * FROM category");
$stmt->execute();
$categories = $stmt->fetchAll();

if ($_POST) {
    if (isset($_POST['submit'])) {
        // REFERENCE = https://www.w3schools.com/php/php_file_upload.asp
        $target_dir = "images/auctions/";
        $target_file = $target_dir . basename($_FILES["auctionImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $stmt = $pdo->prepare('INSERT INTO auction(title, auction_description, category_id, startDate, endDate, image, user_id)
                                VALUES(:title, :auction_description, :category_id, :startDate, :endDate, :image, :user_id)
    ');
        $values = [
            'title' => $_POST['title'],
            'auction_description' => $_POST['auction_description'],
            'category_id' => $_POST['category_id'],
            'startDate' => $startDate,
            'endDate' => $endDate,
            'image' => $_FILES["auctionImage"]["name"],
            'user_id' => $_SESSION['userDetails']["user_id"]
        ];
        $stmt->execute($values);


        $check = getimagesize($_FILES["auctionImage"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

        if ($uploadOk) {
            move_uploaded_file($_FILES["auctionImage"]["tmp_name"], $target_file);
            $_SESSION['showModal'] = true;
            header("Location: addAuction.php"); // Redirect to avoid resubmission
            exit;
        }
        // echo '<script> alert("Auction Added") </script>';
        // header("Location: addAuction.php");
    }
}
if (isset($_SESSION['showModal']) && $_SESSION['showModal']) {
    $showModal = true;
    unset($_SESSION['showModal']);
}


?>

<head>
    <title>Add Auction - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <?php require "layouts/header.php"; ?>

    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <!-- Main Content -->
        <div class="main-content">
            <h1>Add Auction</h1>
            <div class="content">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Auction Title:</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="auctionDescription">Auction Description:</label>
                        <textarea id="auction_description" name="auction_description" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select id="category_id" name="category_id" class="form-control">
                            <?php foreach ($categories as $row) {
                                echo '<option value="' . $row['category_id'] . '">' . $row['category_name'] . '</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
    <label for="start">Start Date:</label>
    <input type="datetime-local" id="start" name="startDate" class="form-control" min="2024-01-13T00:00" required>
</div>
<div class="form-group">
    <label for="end">End Date:</label>
    <input type="datetime-local" id="end" name="endDate" class="form-control" min="2024-01-20T00:00" required>
</div>

                    <div class="form-group">
                        <label for="auctionImage">Auction Image:</label>
                        <input type="file" id="auctionImage" name="auctionImage" class="form-control-file">
                    </div>
                    <button type="submit" name="submit" class="btn-submit">Add Auction</button>
                </form>
            </div>
        </div>
    </div>
    <div id="auctionAddedModal" class="modal" style="<?php echo $showModal ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Auction added successfully!</p>
        </div>
    </div>
    <?php require "layouts/footer.php"; ?>
    <script>
        // JavaScript to close the modal
        var modal = document.getElementById("auctionAddedModal");
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