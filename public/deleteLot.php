<?php
session_start();
require 'as1csy2028.php';

if (isset($_GET['lot_id'])) {
    $isDeleted = $pdo->prepare("DELETE FROM lots WHERE lot_id=?")->execute([$_GET['lot_id']]);


    if ($isDeleted) {
        $_SESSION['lotDeleted'] = true;
    }

    header("Location: manageLots.php");
    exit();
}

