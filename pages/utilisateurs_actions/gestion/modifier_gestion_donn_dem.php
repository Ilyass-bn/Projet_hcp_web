<?php
include "../../dbconnect.php";

$id = $_POST['id_dem'];
$Hcp = $_POST['Hcp'];
$habitants= $_POST['habitants'];
$Taux_croiss = $_POST['Taux_croiss'];
$Superficie = $_POST['Superficie'];
$Taux_chomage = $_POST['Taux_chomage'];
$Population = $_POST['Population_dem'];
$PIB_reg = $_POST['PIB_reg'];
$Etablissements = $_POST['Etablissements'];
$Taux_emploi = $_POST['Taux_emploi'];


$fields = [
    "id" => $id,
    "Hcp" => $Hcp,
    "habitants" => $habitants,
    "Taux_croiss" => $Taux_croiss,
    "Superficie" => $Superficie,
    "Taux_chomage" => $Taux_chomage,
    "Population" => $Population,
    "PIB_reg" => $PIB_reg,
    "Etablissements" => $Etablissements,
    "Taux_emploi" => $Taux_emploi
];



$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE gestion_donn_dem SET $setClause WHERE id = ?");
$stmt->execute($values);

header("Location: ../../statiques.php");
exit();
?>