<?php
require '../../../vendor/autoload.php'; // ajuste le chemin si besoin
use Dompdf\Dompdf;
use Dompdf\Options;

include "../../dbconnect.php";

$sql = $pdo->query("SELECT id,ID_pub,Images,Titre_pub,Categorie,Statut,date_pub,description,link_pub,nbre_tel FROM publication ORDER BY id DESC");
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
    .Notes_et_analyses { background: #568be033; color: #3B82F6; }
    .Bulletins_et_revues { background: rgba(230, 151, 82, 0.27); color: rgb(247, 115, 0); }
    .Rapports_et_etudes { background: #E7F9EF; color: #22C55E; }
    .Autres_documents { background: :rgba(153, 86, 235, 0.3); color: :rgba(111, 0, 247, 0.87); }
</style>
</head>
<body>
    <h1>Liste des publications</h1>
    <p class="sub">Généré le ' . date("d/m/Y à H:i") . '</p>
    <table>
        <thead>
            <tr>
                <th>Photo</th>
                <th>ID</th>
                <th>Titre de la publication</th>
                <th>Description</th>
                <th>Categorie</th>
                <th>Statut</th>
                <th>date de publication</th>
                <th>Telechargement</th>
            </tr>
        </thead>
        <tbody>';

foreach ($enquetes as $e) {
    $img = !empty($e['Images'])
        ? '<img class="photo" src="data:image/png;base64,' . base64_encode($e['Images']) . '">'
        : '—';

    $statutClass = match($e['Statut']) {
        'Publié' => 'terminee',
        'Brouillons' => 'brouillon',
        default => ''
    };
    $categorieClass = match($e['Categorie']) {
        'Notes et analyses' => 'Notes_et_analyses',
        'Bulletins et revues' => 'Bulletins_et_revues',
        'Rapports et études' => 'Rapports_et_etudes',
        'Autres documents' => 'Autres_documents',
        default => ''
    };

    $html .= '
            <tr>
                <td>' . $img . '</td> 
                <td>' . htmlspecialchars($e['ID_pub']) . '</td>
                <td>' . htmlspecialchars($e['Titre_pub']) . '</td>
                <td>' . htmlspecialchars($e['description']) . '</td>
                <td><span class="badge ' . $categorieClass . '">' . htmlspecialchars($e['Categorie']) . '</span></td>
                <td><span class="badge ' . $statutClass . '">' . htmlspecialchars($e['Statut']) . '</span></td>
                <td>' . htmlspecialchars($e['date_pub']) . '</td>
                <td>' . htmlspecialchars($e['nbre_tel']) . '</td>
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