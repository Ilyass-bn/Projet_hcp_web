<?php
include "../../dbconnect.php";

$id = $_POST['id'];
$ID_pub = $_POST['ID_stat'];
$Titre_pub = $_POST['Titre_stat'];
$Categorie = $_POST['Categorie_stat'];
$Statut = $_POST['Statut_stat'];
$date_pub = $_POST['date_stat_pub'];
$description = $_POST['Description'];

$uploadDir = __DIR__ . "/../../../uploads/";
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0755, true);
}

$imageData = null;
if(isset($_FILES['Image_stat']) && $_FILES['Image_stat']['error'] === UPLOAD_ERR_OK){
    $imageData = file_get_contents($_FILES['Image_stat']['tmp_name']);
}

$linkPath = null;
if(isset($_FILES['link_files']) && $_FILES['link_files']['error'] === UPLOAD_ERR_OK){
    $originalName = basename($_FILES['link_files']['name']);
    $safeName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
    $targetPath = $uploadDir . $safeName;

    if(move_uploaded_file($_FILES['link_files']['tmp_name'], $targetPath)){
        $linkPath = "uploads/" . $safeName;
    }
}


$fields = [
    "ID_stat" => $ID_pub,
    "Titre_stat" => $Titre_pub,
    "Categorie_stat" => $Categorie,
    "Statut_stat" => $Statut,
    "date_stat_pub" => $date_pub,
    "description_stat" => $description,
    "Statut_stat" => $Statut,
];

if($imageData !== null) $fields["Image_stat"] = $imageData;
if($linkPath !== null) $fields["link_files"] = $linkPath;

$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE statique SET $setClause WHERE id = ?");
$stmt->execute($values);

header("Location: ../../statiques.php");
exit();
?>