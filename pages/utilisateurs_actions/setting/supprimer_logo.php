<?php
include "../../dbconnect.php";

$upload_dir = __DIR__ . "/../../../src/img/";

$logo = $pdo->query("SELECT logo_site FROM setting WHERE id = 0")->fetchColumn();

if (!empty($logo) && file_exists($upload_dir . $logo)) {
    unlink($upload_dir . $logo);
}

$stmt = $pdo->prepare("UPDATE setting SET logo_site = NULL WHERE id = 0");
$stmt->execute();

header("Location: ../../setting.php?success=logo_supprime");
exit;