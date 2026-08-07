<?php
require '../../vendor/autoload.php'; // ajuste le chemin si besoin
use Dompdf\Dompdf;
use Dompdf\Options;

include "../dbconnect.php";

$sql = $pdo->query("SELECT ID_enquete, Image_enquete, Titre, Type, Direction, Statut, date_debut, date_fin FROM enquete ORDER BY id DESC");
$enquetes = $sql->fetchAll(PDO::FETCH_ASSOC);

// Construction du HTML
$html = '
<html>
<head>
<style>
    body { font-family: sans-serif; font-size: 11px; }
    h1 { color: #6B123C; font-size: 18px; margin-bottom: 4px; }
    p.sub { color: #666; margin-top: 0; margin-bottom: 16px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #FCEAF1; color: #6B123C; text-align: left; padding: 6px 8px; border-bottom: 2px solid #6B123C; }
    td { padding: 6px 8px; border-bottom: 1px solid #eee; vertical-align: middle; }
    img.photo { width: 40px; height: 40px; object-fit: cover; border-radius: 4px; }
    .badge { padding: 3px 8px; border-radius: 10px; font-size: 10px; }
    .en-cours { background: #E8F0FE; color: #3B82F6; }
    .terminee { background: #E7F9EF; color: #22C55E; }
    .brouillon { background: #FCE7F3; color: #EC4899; }
</style>
</head>
<body>
    <h1>Liste des enquêtes</h1>
    <p class="sub">Généré le ' . date("d/m/Y à H:i") . '</p>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>ID</th>
                <th>Titre</th>
                <th>Type</th>
                <th>Direction</th>
                <th>Statut</th>
                <th>Date début</th>
                <th>Date fin</th>
            </tr>
        </thead>
        <tbody>';

foreach ($enquetes as $e) {
    $img = !empty($e['Image_enquete'])
        ? '<img class="photo" src="data:image/png;base64,' . base64_encode($e['Image_enquete']) . '">'
        : '—';

    $statutClass = match($e['Statut']) {
        'En cours' => 'en-cours',
        'Terminée' => 'terminee',
        'Brouillons' => 'brouillon',
        default => ''
    };

    $html .= '
            <tr>
                <td>' . $img . '</td>
                <td>' . htmlspecialchars($e['ID_enquete']) . '</td>
                <td>' . htmlspecialchars($e['Titre']) . '</td>
                <td>' . htmlspecialchars($e['Type']) . '</td>
                <td>' . htmlspecialchars($e['Direction']) . '</td>
                <td><span class="badge ' . $statutClass . '">' . htmlspecialchars($e['Statut']) . '</span></td>
                <td>' . htmlspecialchars($e['date_debut']) . '</td>
                <td>' . htmlspecialchars($e['date_fin']) . '</td>
            </tr>';
}

$html .= '
        </tbody>
    </table>
</body>
</html>';

// Génération PDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape'); // paysage car beaucoup de colonnes
$dompdf->render();

$dompdf->stream("enquetes_" . date("Y-m-d") . ".pdf", ["Attachment" => true]);
exit;