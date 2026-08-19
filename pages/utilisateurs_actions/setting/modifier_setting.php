<?php
include "../../dbconnect.php";

$id = $_POST['id'];
$site = $_POST['site'];
$email = $_POST['email'];
$telephone	 = $_POST['tel'];



$fields = [
    "site" => $site,
    "email" =>$email,
    "telephone" =>$telephone,
];

$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE setting SET $setClause WHERE id = ?");
$stmt->execute($values);

header("Location: ../../setting.php");
exit();
?>