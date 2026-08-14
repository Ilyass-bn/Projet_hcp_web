<?php
include "../../dbconnect.php";

$id = $_POST['id_hcp_link'];
$facebook_link = $_POST['facebook_link'];
$x_link = $_POST['x_link'];
$linkedin_link = $_POST['linkedin_link'];
$youtube_link = $_POST['youtube_link'];
$instagram_link	 = $_POST['instagram_link'];



$fields = [
    "facebook_link" => $facebook_link,
    "x_link" =>$x_link,
    "linkedin_link" =>$linkedin_link,
    "youtube_link" =>$youtube_link,
    "instagram_link" =>$instagram_link,
];

$setClause = implode(", ", array_map(fn($k) => "$k = ?", array_keys($fields)));
$values = array_values($fields);
$values[] = $id; 

$stmt = $pdo->prepare("UPDATE reseaux_link SET $setClause WHERE id = ?");
$stmt->execute($values);

header("Location: ../../contenu_site.php");
exit();
?>