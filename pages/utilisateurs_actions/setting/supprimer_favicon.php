<?php
include "../../dbconnect.php";

$upload_dir = __DIR__ . "/../../../src/img/";

$favicon = $pdo->query("SELECT logo_home FROM setting WHERE id = 0")->fetchColumn();

if (!empty($favicon) && file_exists($upload_dir . $favicon)) {
    unlink($upload_dir . $favicon);
}

$stmt = $pdo->prepare("UPDATE setting SET logo_home = NULL WHERE id = 0");
$stmt->execute();

header("Location: ../../setting.php?success=favicon_supprime");
exit;