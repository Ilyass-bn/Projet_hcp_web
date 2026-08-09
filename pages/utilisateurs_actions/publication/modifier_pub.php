<?php
include "../../dbconnect.php";

$id = $_POST['id'];
$ID_pub = $_POST['ID_pub'];
$Titre_pub = $_POST['Titre_pub'];
$Categorie = $_POST['Categorie'];
$Statut = $_POST['Statut'];
$date_pub = $_POST['date_pub'];
$description = $_POST['Description'];

$uploadDir = __DIR__ . "/../../../uploads/";
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0755, true);
}

$imageData = null;
if(isset($_FILES['Image_pub']) && $_FILES['Image_pub']['error'] === UPLOAD_ERR_OK){
    $imageData = file_get_contents($_FILES['Image_pub']['tmp_name']);
}

$linkPath = null;
if(isset($_FILES['link_pub']) && $_FILES['link_pub']['error'] === UPLOAD_ERR_OK){
    $originalName = basename($_FILES['link_pub']['name']);
    $safeName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
    $targetPath = $uploadDir . $safeName;

    if(move_uploaded_file($_FILES['link_pub']['tmp_name'], $targetPath)){
        $linkPath = "uploads/" . $safeName;
    }
}


$fields = [
    "ID_pub" => $ID_pub,
    "Titre_pub" => $Titre_pub,
    "Categorie" => $Categorie,
    "Statut" => $Statut,
    "date_pub" => $date_pub,
    "description" => $description,
    "Statut" => $Statut,
];

if($imageData !== null) $fields["Images"] = $imageData;
if($linkPath !== null) $fields["link_pub"] = $linkPath;

$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE publication SET $setClause WHERE id = ?");
$stmt->execute($values);

header("Location: ../../publication.php");
exit();
?>