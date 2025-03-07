<?php
session_start();
require 'as1csy2028.php';
$title = 'Add Category';


if ($_POST) {
    if (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('INSERT INTO category (category_name, category_description)
        VALUES (:category_name, :category_description)');

        // Bind the form values to your SQL statement
        $values = [
            'category_name' => $_POST['category_name'],
            'category_description' => $_POST['category_description']
        ];
        if ($stmt->execute($values)) {
            $_SESSION['showModal'] = true; // Set the session variable
            header("Location: addCategory.php"); // Redirect to the same page
            exit();
        }
    }
}
$showModal = isset($_SESSION['showModal']) && $_SESSION['showModal'];
?>

<head>
    <title>Add Category - Fotheby's</title>
    <link rel="stylesheet" href="ibuy.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
</head>

<body>
    <?php require "layouts/header.php"; ?>
    <div class="dashboard-container">
        <?php require 'adminBar.php'; ?>
        <!-- Main Content -->
        <div class="main-content">
            <h1>Add Category</h1>
            <div class="content">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <input type="text" id="category_name" name="category_name" required class="form-control" placeholder="Category name" />
                    </div>
                    <div class="form-group">
                        <label for="category_description">Category Description:</label>
                        <textarea id="category_description" name="category_description" class="form-control" placeholder="Describe the category"></textarea>
                    </div>
                    <button type="submit" name="submit" class="btn-submit">Add Category</button>
                </form>
            </div>
        </div>
    </div>
    <div id="categoryAddedModal" class="modal" style="<?php echo $showModal ? 'display:block;' : 'display:none;'; ?>">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Category added successfully!</p>
        </div>
    </div>

    <?php require "layouts/footer.php"; ?>
    <script>
        // JavaScript to close the modal
        var modal = document.getElementById("categoryAddedModal");
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
    <?php
    if ($showModal) {
        unset($_SESSION['showModal']); // Unset the session variable
    } ?>

</body>

</html>