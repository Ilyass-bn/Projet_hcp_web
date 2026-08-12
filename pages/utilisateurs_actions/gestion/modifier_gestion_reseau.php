<?php
include "../../dbconnect.php";

$id = $_POST['ID_res'];
$Direction_reg = $_POST['Direction_reg'];
$Bureaux_prov = $_POST['Bureaux_prov'];
$Donnees_coll = $_POST['Donnees_coll'];


$fields = [
    "ID_res" => $id,
    "Direction_reg" => $Direction_reg,
    "Bureaux_prov" => $Bureaux_prov,
    "Donnees_coll" => $Donnees_coll
];



$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE gestion_reseau SET $setClause WHERE ID_res = ?");
$stmt->execute($values);

header("Location: ../../statiques.php");
exit();
?>