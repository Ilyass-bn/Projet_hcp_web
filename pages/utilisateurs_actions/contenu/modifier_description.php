<?php
include "../../dbconnect.php";

$id = $_POST['id_hcp'];
$description = $_POST['description'];
$title = $_POST['title'];



$fields = [
    "description" => $description,
    "title" =>$title
];

$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE hcp_des SET $setClause WHERE id = ?");
$stmt->execute($values);

header("Location: ../../contenu_site.php");
exit();
?>