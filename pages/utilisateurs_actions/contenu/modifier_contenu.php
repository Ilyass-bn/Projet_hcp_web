<?php
include "../../dbconnect.php";

$id = $_POST['id'];
$description_hcp = $_POST['description_hcp'];
$presentation_hcp = $_POST['presentation_hcp'];
$creation_hcp = $_POST['creation_hcp'];
$enquete_link = $_POST['enquete_link'];
$publication_link = $_POST['publication_link'];
$donne_reg_link = $_POST['donne_reg_link'];
$rapp_hcp_link = $_POST['rapp_hcp_link'];
$contact_hcp_link = $_POST['contact_hcp_link'];
$gps_link = $_POST['gps_link'];
$site_link = $_POST['site_link'];

$uploadDir = __DIR__ . "/../../../uploads/";
if(!is_dir($uploadDir)){
    mkdir($uploadDir, 0755, true);
}

$imageData = null;
if(isset($_FILES['Image_hcp']) && $_FILES['Image_hcp']['error'] === UPLOAD_ERR_OK){
    $imageData = file_get_contents($_FILES['Image_hcp']['tmp_name']);
}



$fields = [
    "description_hcp" => $description_hcp,
    "presentation_hcp" => $presentation_hcp,
    "creation_hcp" => $creation_hcp,
    "enquete_link" => $enquete_link,
    "publication_link" => $publication_link,
    "donne_reg_link" => $donne_reg_link,
    "rapp_hcp_link" => $rapp_hcp_link,
    "contact_hcp_link" => $contact_hcp_link,
    "gps_link" => $gps_link,
    "site_link" => $site_link
];

if($imageData !== null) $fields["Image_hcp"] = $imageData;

$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE gestion_hcp SET $setClause WHERE id = ?");
$stmt->execute($values);

header("Location: ../../contenu_site.php");
exit();
?>