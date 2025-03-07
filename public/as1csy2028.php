<?php
$server = 'db';
$db_Username = 'v.je';
$db_Password = 'v.je';


$schema = 'as1csy2028';

try {
    $pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $db_Username, $db_Password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>