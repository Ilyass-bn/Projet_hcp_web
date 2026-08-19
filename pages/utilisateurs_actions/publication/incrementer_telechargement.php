<?php
include "../../dbconnect.php";

header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(["success" => false, "error" => "id manquant"]);
    exit;
}

try {
    // 1. Incremente le total (lifetime) de la publication
    $stmt = $pdo->prepare("UPDATE publication SET nbre_tel = COALESCE(nbre_tel, 0) + 1 WHERE id = ?");
    $stmt->execute([$id]);

    $stmt2 = $pdo->prepare("SELECT nbre_tel FROM publication WHERE id = ?");
    $stmt2->execute([$id]);
    $nbre_tel = $stmt2->fetchColumn();

    // 2. Incremente le compteur du jour (site global)
    $stmt3 = $pdo->prepare("
        INSERT INTO telechargement_jour_publication (date_jour, nbre_tel)
        VALUES (CURDATE(), 1)
        ON DUPLICATE KEY UPDATE nbre_tel = nbre_tel + 1
    ");
    $stmt3->execute();

    $stmt4 = $pdo->prepare("SELECT nbre_tel FROM telechargement_jour_publication WHERE date_jour = CURDATE()");
    $stmt4->execute();
    $nbre_tel_jour = $stmt4->fetchColumn();

    echo json_encode([
        "success" => true,
        "nbre_tel" => $nbre_tel,
        "nbre_tel_jour" => $nbre_tel_jour
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}