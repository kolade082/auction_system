<?php
session_start();
require 'as1csy2028.php';
$title = 'Manage Categories';


$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare the SQL query with a search condition
$sql = "SELECT * FROM category";

if ($searchTerm) {
    $sql .= " WHERE category_name LIKE :searchTerm OR category_description LIKE :searchTerm";
}

$stmt = $pdo->prepare($sql);

if ($searchTerm) {
    $searchTerm = '%' . $searchTerm . '%';
    $stmt->bindParam(':searchTerm', $searchTerm);
}

$stmt->execute();
$data = $stmt->fetchAll();

$showDeleteModal = isset($_SESSION['categoryDeleted']) && $_SESSION['categoryDeleted'];
$showUpdateModal = isset($_SESSION['categoryUpdated']) && $_SESSION['categoryUpdated'];
?>

<head>
    <title>Manage Categories</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>

    <?php require "layouts/header.php"; ?>

    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <div class="main-content">
            <div class="header-with-button">
                <h1>Manage Categories</h1>
                <a href="addCategory.php" class="add-button">
                    <button class="add-auction"><i class="fas fa-plus"></i> Add Category</button>
                </a>
            </div>
            <div class="content">
                <table class="category-table">
                    <thead>
                        <tr>
                            <th>Categories</th>
                            <th>Category Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $row) {
                            echo "<tr>
                                <td>" . $row["category_name"] . "</td>
                                <td>" . $row["category_description"] . "</td>
                                <td>
                                
                                    <a href='editCategory.php?category_id=" . $row["category_id"] . "'><button class='edit'>EDIT</button></a>
                                    <a href='deleteCategory.php?category_id=" . $row["category_id"] . "'><button class='delete'>DELETE</button></a>
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="deleteCategoryModal" class="modal" style="<?php echo $showDeleteModal ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close" onclick="closeModal('deleteCategoryModal')">&times;</span>
            <p>Category deleted successfully!</p>
        </div>
    </div>
    <div id="updateCategoryModal" class="modal" style="<?php echo $showUpdateModal ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close" onclick="closeModal('updateCategoryModal')">&times;</span>
            <p>Category updated successfully!</p>
        </div>
    </div>

    <?php unset($_SESSION['categoryUpdated']);
    require 'layouts/footer.php'; ?>
    <script>
        function closeModal(modalId) {
            var modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = "none";
            }
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>
    <?php
    // Unset the session variable after displaying the modal
    if ($showDeleteModal) {
        unset($_SESSION['categoryDeleted']);
    }
    ?>
</body>

</html>