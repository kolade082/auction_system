<?php
session_start();
require 'as1csy2028.php';
$title = 'Manage Lots';

$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare the SQL query with a search condition
$sql = "SELECT l.lot_id, l.lot_name, l.lot_description, l.image, l.estimated_price, a.title as auction_name, u.firstName, u.lastName FROM lots l
        JOIN auction a ON l.auction_id = a.auction_id
        JOIN users u ON l.user_id = u.user_id";

if ($searchTerm) {
    $sql .= " WHERE l.lot_name LIKE :searchTerm OR l.lot_description LIKE :searchTerm OR a.title LIKE :searchTerm OR u.firstName LIKE :searchTerm OR u.lastName LIKE :searchTerm";
}

$stmt = $pdo->prepare($sql);

if ($searchTerm) {
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bindParam(':searchTerm', $searchTerm);
}

$stmt->execute();
$data = $stmt->fetchAll();
$showDeleteModal = isset($_SESSION['lotDeleted']) && $_SESSION['lotDeleted'];
unset($_SESSION['lotDeleted']);
$showUpdateModal = isset($_SESSION['lotUpdated']) && $_SESSION['lotUpdated'];
unset($_SESSION['lotUpdated']);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Lots - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>
<body>
    <?php require "layouts/header.php"; ?>
    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <div class="main-content">
            <div class="header-with-button">
                <h1>Manage Lots</h1>
                <a href="addLot.php" class="add-button">
                    <button class="add-auction"><i class="fas fa-plus"></i> Add Lot</button>
                </a>
            </div>
            <div class="content">
                <table class="category-table">
                    <thead>
                        <tr>
                            <th>Lot Number</th>
                            <th>Image</th>
                            <th>Lot Name</th>
                            <th>Description</th>
                            <th>Estimated Price(£)</th>
                            <th>Auction</th>
                            <th>Auctioneer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo str_pad($row['lot_id'], 8, '0', STR_PAD_LEFT); ?></td>
                <td><img src="images/lots/<?php echo htmlspecialchars($row['image']); ?>" alt="Lot Image" style="width:100px; height:auto;"></td>
                <td><?php echo htmlspecialchars($row['lot_name']); ?></td>
                <td><?php echo htmlspecialchars($row['lot_description']); ?></td>
                <td>£<?php echo htmlspecialchars($row['estimated_price']); ?></td>
                <td><?php echo htmlspecialchars($row['auction_name']); ?></td>
                <td><?php echo htmlspecialchars($row['firstName'] . " " . $row['lastName']); ?></td>
                <td>
                    <a href='editLot.php?lot_id=<?php echo $row["lot_id"]; ?>'><button class='edit'>EDIT</button></a>
                    <a href='deleteLot.php?lot_id=<?php echo $row["lot_id"]; ?>'><button class='delete'>DELETE</button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
                </table>
            </div>
        </div>
    </div>

        <!-- Modals for Notifications -->
        <div id="deleteLotModal" class="modal" style="<?php echo $showDeleteModal ? 'display:block;' : 'display:none;'; ?>">
            <div class="modal-content">
                <span class="close" onclick="closeModal('deleteLotModal')">&times;</span>
                <p>Lot deleted successfully!</p>
            </div>
        </div>
        <div id="lotUpdatedModal" class="modal" style="<?php echo $showUpdateModal ? 'display:block;' : 'display:none;'; ?>">
    <div class="modal-content">
        <span class="close" onclick="closeModal('lotUpdatedModal')">&times;</span>
        <p>Lot updated successfully!</p>
    </div>
</div>

        

<?php require 'layouts/footer.php'; ?>

<script>
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            modal.style.display = "none";
        }

        function closeUpdateModal() {
            var updateModal = document.getElementById("lotUpdatedModal");
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
