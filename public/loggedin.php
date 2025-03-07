<?php
$title = 'Login';
require 'head.php';
require 'as1csy2028.php';

if (isset($_SESSION['loggedin'])){
    echo 'Hope you enjoying the auctioning';
}else{
    echo 'sorry, you must be logged in to view this';
}
