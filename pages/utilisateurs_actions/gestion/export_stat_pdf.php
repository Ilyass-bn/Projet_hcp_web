<?php
require_once '../../../vendor/autoload.php'; // ajuste le chemin selon ton arborescence
include "../../dbconnect.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$sql = $pdo->query("SELECT ID_stat,Image_stat,Titre_stat,description_stat,Categorie_stat,Statut_stat,date_stat_pub,link_files,nbre_stat FROM statique ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);


$categorieColors = [
    "Economie" => "#C9880E",
    "Marché du travail" => "#1E8A4C",
    "Revenu & conditions de vie" => "#E8B71D",
    "Population & démographie" => "#0026FF",
    "Développement durable" => "#D62928",
    "Autres..." => "#7E7E7E"
];

$statutColors = [
    "Publié" => "#1E8A4C",
    "Brouillons" => "#7E7E7E"
];

$html = '
<html>
<head>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
    h1 { color: #6B123C; text-align: center; margin-bottom: 4px; }
    p.subtitle { text-align: center; color: #888; margin-top: 0; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th { background-color: #F3E9EE; color: #6B123C; text-align: left; padding: 6px; border-bottom: 2px solid #6B123C; font-size: 10px; }
    td { padding: 6px; border-bottom: 1px solid #eee; vertical-align: middle; }
    tr:nth-child(even) { background-color: #FAFAFA; }
    img.thumb { width: 40px; height: 40px; object-fit: cover; border-radius: 4px; }
    span.badge { padding: 3px 8px; border-radius: 10px; font-size: 9px; display: inline-block; }
</style>
</head>
<body>
    <h1>Gestion des statistiques</h1>
    <p class="subtitle">Export généré le ' . date('d/m/Y à H:i') . '</p>
    <table>
        <thead>
            <tr>
                <th>ID statique</th>
                <th>Image</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Catégorie</th>
                <th>Statut</th>
                <th>Date publication</th>
                <th>Téléchargements</th>
            </tr>
        </thead>
        <tbody>';

foreach ($users as $user) {
    $catColor = $categorieColors[$user['Categorie_stat']] ?? "#7E7E7E";
    $statColor = $statutColors[$user['Statut_stat']] ?? "#7E7E7E";

    $imgHtml = '—';
    if (!empty($user['Image_stat'])) {
        $imgHtml = '<img class="thumb" src="data:image/png;base64,' . base64_encode($user['Image_stat']) . '">';
    }

    $html .= '<tr>
        <td>' . htmlspecialchars($user['ID_stat']) . '</td>
        <td>' . $imgHtml . '</td>
        <td>' . htmlspecialchars($user['Titre_stat']) . '</td>
        <td>' . htmlspecialchars(mb_strimwidth($user['description_stat'], 0, 60, '...')) . '</td>
        <td><span class="badge" style="background-color:' . $catColor . '20; color:' . $catColor . ';">' . htmlspecialchars($user['Categorie_stat']) . '</span></td>
        <td><span class="badge" style="background-color:' . $statColor . '20; color:' . $statColor . ';">' . htmlspecialchars($user['Statut_stat']) . '</span></td>
        <td>' . htmlspecialchars($user['date_stat_pub']) . '</td>
        <td>' . htmlspecialchars($user['nbre_stat']) . '</td>
    </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("gestion_statistiques_" . date('Y-m-d') . ".pdf", ["Attachment" => true]);
exit();