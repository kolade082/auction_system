<?php
session_start();
require 'as1csy2028.php';
$title = 'Manage Auction';

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare the SQL query with a search condition
$sql = "SELECT a.auction_id, a.title, a.auction_description, a.startDate, a.endDate, a.image, c.category_name FROM auction a
        JOIN category c ON a.category_id = c.category_id";

if ($searchTerm) {
    $sql .= " WHERE a.title LIKE :searchTerm OR a.auction_description LIKE :searchTerm OR c.category_name LIKE :searchTerm";
}

$stmt = $pdo->prepare($sql);

if ($searchTerm) {
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bindParam(':searchTerm', $searchTerm);
}

$stmt->execute();
$data = $stmt->fetchAll();

// $data = $pdo->query("SELECT * FROM auction")->fetchAll();
// $data = $pdo->query("SELECT a.auction_id, a.title, a.auction_description, a.startDate, a.endDate, c.category_name FROM auction a
//                       JOIN category c ON a.category_id = c.category_id")->fetchAll();

$showDeleteModal = isset($_SESSION['auctionDeleted']) && $_SESSION['auctionDeleted'];
unset($_SESSION['auctionDeleted']);
$showUpdateModal = isset($_SESSION['auctionUpdated']) && $_SESSION['auctionUpdated'];
unset($_SESSION['auctionUpdated']);


?>

<head>
    <title>Manage Auctions - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <?php require "layouts/header.php"; ?>
    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <div class="main-content">
            <div class="header-with-button">
                <h1>Manage Auctions</h1>
                
                <a href="addAuction.php" class="add-button">
                    <button class="add-auction"><i class="fas fa-plus"></i> Add Auction</button>
                </a>
            </div>
            <div class="content">
                <table class="category-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Auction Name</th>
                            <th>Category </th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?php echo $row["auction_id"]; ?></td>
                                <td><img src="images/auctions/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" style="width:100px; height:auto;"></td>
                                <td><?php echo htmlspecialchars($row["title"]); ?></td>
                                <td><?php echo htmlspecialchars($row["category_name"]); ?></td>
                                <td><?php echo htmlspecialchars($row["startDate"]); ?></td>
                                <td><?php echo htmlspecialchars($row["endDate"]); ?></td>
                                <td>
                                    <a href='editAuction.php?auction_id=<?php echo $row["auction_id"]; ?>'><button class='edit'>EDIT</button></a>
                                    <a href='deleteAuction.php?auction_id=<?php echo $row["auction_id"]; ?>'><button class='delete'>DELETE</button></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="deleteAuctionModal" class="modal" style="<?php echo $showDeleteModal ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteAuctionModal')">&times;</span>
            <p>Auction deleted successfully!</p>
        </div>
    </div>
    <div id="auctionUpdatedModal" class="modal" style="<?php echo $showUpdateModal ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close" onclick="closeUpdateModal()">&times;</span>
            <p>Auction updated successfully!</p>
        </div>
    </div>

    <?php require 'layouts/footer.php'; ?>
    <script>
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
        }

        function closeUpdateModal() {
            var updateModal = document.getElementById("auctionUpdatedModal");
            if (updateModal) {
                updateModal.style.display = "none";
            }
        }

        // Close the modal when the user clicks anywhere outside of it
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>


</body>

</html>