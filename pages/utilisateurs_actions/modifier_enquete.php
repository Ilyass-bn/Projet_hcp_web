<?php
include "../dbconnect.php";

$id = $_POST['id'];
$ID_enquete = $_POST['ID_enquete'];
$Titre = $_POST['Titre'];
$Type = $_POST['Type'];
$Direction = $_POST['Direction'];
$date_debut = $_POST['date_debut'];
$date_fin = $_POST['date_fin'];
$Statut = $_POST['Statut'];

$uploadDir = __DIR__ . "/../../uploads/";
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0755, true);
}

$imageData = null;
if(isset($_FILES['Image_enquete']) && $_FILES['Image_enquete']['error'] === UPLOAD_ERR_OK){
    $imageData = file_get_contents($_FILES['Image_enquete']['tmp_name']);
}

$linkPath = null;
if(isset($_FILES['link_file']) && $_FILES['link_file']['error'] === UPLOAD_ERR_OK){
    $originalName = basename($_FILES['link_file']['name']);
    $safeName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
    $targetPath = $uploadDir . $safeName;

    if(move_uploaded_file($_FILES['link_file']['tmp_name'], $targetPath)){
        $linkPath = "uploads/" . $safeName;
    }
}


$fields = [
    "ID_enquete" => $ID_enquete,
    "Titre" => $Titre,
    "Type" => $Type,
    "Direction" => $Direction,
    "date_debut" => $date_debut,
    "date_fin" => $date_fin,
    "Statut" => $Statut,
];

if($imageData !== null) $fields["Image_enquete"] = $imageData;
if($linkPath !== null) $fields["link"] = $linkPath;

$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE enquete SET $setClause WHERE id = ?");
$stmt->execute($values);

header("Location: ../enquete.php");
exit();
?>