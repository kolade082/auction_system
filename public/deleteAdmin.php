<?php
require 'as1csy2028.php';
if(isset($_GET['user_id'])){
    
    $pdo->prepare("DELETE FROM users WHERE user_id=?")->execute([$_GET['user_id']]);

    header('Location: manageUsers.php');
}
?>