<?php
require_once '../../../vendor/autoload.php';
include "../../dbconnect.php";

use Dompdf\Dompdf;
use Dompdf\Options;

// Récupération des données
$sql = $pdo->query("SELECT Hcp,habitants,Taux_croiss,Superficie,Taux_chomage,Population,PIB_reg,Etablissements,Taux_emploi FROM gestion_donn_dem");
$donne = $sql->fetchAll(PDO::FETCH_ASSOC);

// Construction du HTML du PDF
$html = '
<html>
<head>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
    h1 { color: #6B123C; text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th { background-color: #F3E9EE; color: #6B123C; text-align: left; padding: 8px; border-bottom: 2px solid #6B123C; }
    td { padding: 8px; border-bottom: 1px solid #eee; }
    tr:nth-child(even) { background-color: #FAFAFA; }
</style>
</head>
<body>
    <h1>Données démographiques et sociales</h1>
    <table>
        <thead>
            <tr>
                <th>Hcp</th>
                <th>Habitants</th>
                <th>Taux de croissance</th>
                <th>Superficie</th>
                <th>Taux de chômage</th>
                <th>Population</th>
                <th>PIB régional</th>
                <th>Établissements</th>
                <th>Taux d\'emploi</th>
            </tr>
        </thead>
        <tbody>';

foreach ($donne as $row) {
    $html .= '<tr>
        <td>' . htmlspecialchars($row['Hcp']) . '</td>
        <td>' . htmlspecialchars($row['habitants']) . '</td>
        <td>' . htmlspecialchars($row['Taux_croiss']) . '</td>
        <td>' . htmlspecialchars($row['Superficie']) . '</td>
        <td>' . htmlspecialchars($row['Taux_chomage']) . '</td>
        <td>' . htmlspecialchars($row['Population']) . '</td>
        <td>' . htmlspecialchars($row['PIB_reg']) . '</td>
        <td>' . htmlspecialchars($row['Etablissements']) . '</td>
        <td>' . htmlspecialchars($row['Taux_emploi']) . '</td>
    </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Génération du PDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

// Téléchargement direct
$dompdf->stream("donnees_demographiques_" . date('Y-m-d') . ".pdf", ["Attachment" => true]);
exit();