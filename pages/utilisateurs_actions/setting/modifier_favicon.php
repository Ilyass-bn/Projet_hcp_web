<?php
include "../../dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['favicon']['name'])) {
    header("Location: ../../setting.php?error=aucun_fichier");
    exit;
}

$file = $_FILES['favicon'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    header("Location: ../../setting.php?error=echec_upload");
    exit;
}

// Formats acceptés : PNG, JPG, SVG
$allowed_ext  = ['png', 'jpg', 'jpeg', 'svg'];
$allowed_mime = ['image/png', 'image/jpeg', 'image/svg+xml'];

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime  = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($ext, $allowed_ext) || !in_array($mime, $allowed_mime)) {
    header("Location: ../../setting.php?error=format_invalide");
    exit;
}

// Limite : 2 Mo
if ($file['size'] > 2 * 1024 * 1024) {
    header("Location: ../../setting.php?error=fichier_trop_lourd");
    exit;
}

$upload_dir = __DIR__ . "/../../../src/img/";
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$new_filename = "favicon_" . time() . "." . $ext;
$destination  = $upload_dir . $new_filename;

// Récupérer l'ancien favicon pour le supprimer une fois le nouveau bien enregistré
$old_favicon = $pdo->query("SELECT logo_home FROM setting WHERE id = 0")->fetchColumn();

if (move_uploaded_file($file['tmp_name'], $destination)) {

    $stmt = $pdo->prepare("UPDATE setting SET logo_home = :path WHERE id = 0");
    $stmt->execute(['path' => $new_filename]);

    if (!empty($old_favicon) && file_exists($upload_dir . $old_favicon)) {
        unlink($upload_dir . $old_favicon);
    }

    header("Location: ../../setting.php?success=favicon_modifie");
} else {
    header("Location: ../../setting.php?error=echec_enregistrement");
}
exit;