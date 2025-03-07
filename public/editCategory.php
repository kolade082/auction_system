<?php
session_start();
require 'as1csy2028.php';
$title = 'Edit Category';

if ($_POST) {
    if (isset($_POST['submit'])) {
        $stmt = $pdo->prepare('UPDATE category SET category_name =:category_name,
                                    category_description = :category_description 
                                WHERE category_id =:category_id;

');
        $values = [
            'category_name' => $_POST['category_name'],
            'category_description' => $_POST['category_description'],
            'category_id' => $_GET['category_id']
        ];
        if ($stmt->execute($values)) {
            $_SESSION['categoryUpdated'] = true; // Set a flag for successful update
        }
        header('Location: adminCategories.php');
        exit();
    }
}
$stmt = $pdo->prepare('SELECT * FROM category WHERE category_id = :category_id');

$values = [
    'category_id' => $_GET['category_id']
];
$stmt->execute($values);
$user = $stmt->fetch();

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
        <!-- Main Content -->
        <div class="main-content">
            <h1>Edit Auction</h1>
            <div class="content">
                <form action="" method="POST">
                    <h2 class="sub-menus">Edit Categories</h2>
                    <div class="form-group">
                        <label for="category_name">Category Name:</label>
                        <input type="text" name="category_name" value="<?php echo $user['category_name']; ?>" class="form-control" placeholder="category name" />
                    </div>
                    <div class="form-group">
                        <label for="category_description">Category Description:</label>
                        <textarea id="category_description" name="category_description" class="form-control">
                        <?php echo htmlspecialchars($user['category_description']); ?>
                        </textarea>
                    </div>
                    <input type="submit" value="Update" class="btn-submit" name="submit" />

                </form>
            </div>
        </div>
    </div>
    <?php require "layouts/footer.php"; ?>

</body>

</html>