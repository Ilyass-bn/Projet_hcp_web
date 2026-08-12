<?php
include "../../dbconnect.php";

$id = $_POST['ID_eco'];
$PIB_rel = $_POST['PIB_rel'];
$Population = $_POST['Population'];
$PIB_dep = $_POST['PIB_dep'];
$Inflation = $_POST['Inflation'];


$fields = [
    "ID_eco" => $id,
    "PIB" => $PIB_rel,
    "Population" => $Population,
    "PIB_dp" => $PIB_dep,
    "Inflation" => $Inflation,
];



$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE gestion_donne_economique SET $setClause WHERE ID_eco = ?");
$stmt->execute($values);

header("Location: ../../statiques.php");
exit();
?>