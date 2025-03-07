<?php
session_start();
require 'as1csy2028.php';
if (isset($_GET['category_id'])) {

    $isDeleted = $pdo->prepare("DELETE FROM category WHERE category_id=?")->execute([$_GET['category_id']]);

    if ($isDeleted) {
        $_SESSION['categoryDeleted'] = true;
    }

    header('Location: adminCategories.php');
    exit();
}
