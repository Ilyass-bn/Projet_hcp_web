<?php
require __DIR__ . '/../../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

include "../dbconnect.php";

try {
    $sql = $pdo->query("SELECT nom_complet, Email, Role, Region, Status FROM login ORDER BY id DESC");
    $users = $sql->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de l'exportation : " . $e->getMessage());
}

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
    .badge { padding: 3px 10px; border-radius: 10px; font-size: 10px; }
    .actif { background: #E7F9EF; color: #22C55E; }
    .bloque { background: #FDEAEA; color: #E05252; }
</style>
</head>
<body>
    <h1>Liste des utilisateurs</h1>
    <p class="sub">Généré le ' . date("d/m/Y à H:i") . '</p>
    <table>
        <thead>
            <tr>
                <th>Nom complet</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Direction/Region</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>';

foreach ($users as $user) {
    $isActif = ($user['Status'] == 1);
    $statusText = $isActif ? 'Actif' : 'Bloqué';
    $statusClass = $isActif ? 'actif' : 'bloque';

    $html .= '
            <tr>
                <td>' . htmlspecialchars($user['nom_complet']) . '</td>
                <td>' . htmlspecialchars($user['Email']) . '</td>
                <td>' . htmlspecialchars($user['Role']) . '</td>
                <td>' . htmlspecialchars($user['Region']) . '</td>
                <td><span class="badge ' . $statusClass . '">' . $statusText . '</span></td>
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
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream("utilisateurs_" . date("Y-m-d") . ".pdf", ["Attachment" => true]);
exit;