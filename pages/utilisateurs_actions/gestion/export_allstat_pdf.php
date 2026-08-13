<?php
require_once '../../../vendor/autoload.php';
include "../../dbconnect.php";

use Dompdf\Dompdf;
use Dompdf\Options;

// ---- Données ----
$sql = $pdo->query("SELECT ID_stat,Image_stat,Titre_stat,description_stat,Categorie_stat,Statut_stat,date_stat_pub,nbre_stat FROM statique ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);

$totalstat   = $pdo->query("Select count(*) from statique")->fetchColumn();
$totaleco    = $pdo->query("Select count(*) from statique where Categorie_stat='Economie'")->fetchColumn();
$totaltrav   = $pdo->query("Select count(*) from statique where Categorie_stat='Marché du travail'")->fetchColumn();
$totaldev    = $pdo->query("Select count(*) from statique where Categorie_stat='Développement durable'")->fetchColumn();
$totalrev    = $pdo->query("Select count(*) from statique where Categorie_stat='Revenu & conditions de vie'")->fetchColumn();
$totalautres = $pdo->query("Select count(*) from statique where Categorie_stat='Autres...'")->fetchColumn();
$totalpop    = $pdo->query("Select count(*) from statique where Categorie_stat='Population & démographie'")->fetchColumn();
$totaltelech = $pdo->query("Select SUM(nbre_stat) from statique")->fetchColumn();
$totalpublie = $pdo->query("Select count(*) from statique where Statut_stat='Publié'")->fetchColumn();
$progress = $totalstat > 0 ? round(($totalpublie / $totalstat) * 100) : 0;

$economique = $pdo->query("SELECT PIB,Population,PIB_dp,Inflation FROM gestion_donne_economique")->fetchAll(PDO::FETCH_ASSOC);
$reseau     = $pdo->query("SELECT Direction_reg,Bureaux_prov,Donnees_coll FROM gestion_reseau")->fetchAll(PDO::FETCH_ASSOC);
$donne      = $pdo->query("SELECT Hcp,habitants,Taux_croiss,Superficie,Taux_chomage,Population,PIB_reg,Etablissements,Taux_emploi FROM gestion_donn_dem")->fetchAll(PDO::FETCH_ASSOC);

$categorieColors = [
    "Economie" => "#C9880E", "Marché du travail" => "#1E8A4C",
    "Revenu & conditions de vie" => "#E8B71D", "Population & démographie" => "#0026FF",
    "Développement durable" => "#D62928", "Autres..." => "#7E7E7E"
];
$statutColors = ["Publié" => "#1E8A4C", "Brouillons" => "#7E7E7E"];

// ---- HTML ----
$html = '
<html>
<head>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #333; }
    h1 { color: #6B123C; text-align: center; margin-bottom: 4px; }
    p.subtitle { text-align: center; color: #888; margin-top: 0; margin-bottom: 20px; }
    h2.section { color: #6B123C; border-bottom: 2px solid #6B123C; padding-bottom: 4px; margin-top: 28px; page-break-before: auto; }
    table.cards { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
    table.cards td { width: 25%; padding: 10px; text-align: center; border: 1px solid #eee; background-color: #FAF7F9; }
    table.cards .value { font-size: 18px; font-weight: bold; color: #6B123C; display: block; }
    table.cards .label { font-size: 9px; color: #555; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data th { background-color: #F3E9EE; color: #6B123C; text-align: left; padding: 6px; border-bottom: 2px solid #6B123C; font-size: 9px; }
    table.data td { padding: 6px; border-bottom: 1px solid #eee; font-size: 9px; }
    table.data tr:nth-child(even) { background-color: #FAFAFA; }
    span.badge { padding: 3px 7px; border-radius: 10px; font-size: 8px; display: inline-block; }
</style>
</head>
<body>
    <h1>Rapport complet des Statistiques - HCP</h1>
    <p class="subtitle">Export généré le ' . date('d/m/Y à H:i') . '</p>

    <h2 class="section">Résumé général</h2>
    <table class="cards">
        <tr>
            <td><span class="value">' . $totalstat . '</span><span class="label">Statiques totales</span></td>
            <td><span class="value">' . $totaleco . '</span><span class="label">Economie</span></td>
            <td><span class="value">' . $totaltrav . '</span><span class="label">Marché du travail</span></td>
            <td><span class="value">' . $totaldev . '</span><span class="label">Développement durable</span></td>
        </tr>
        <tr>
            <td><span class="value">' . $totalrev . '</span><span class="label">Revenu & conditions de vie</span></td>
            <td><span class="value">' . $totalautres . '</span><span class="label">Autres statiques</span></td>
            <td><span class="value">' . $totaltelech . '</span><span class="label">Téléchargements</span></td>
            <td><span class="value">' . $progress . '%</span><span class="label">Taux de publication</span></td>
        </tr>
    </table>';

// ---- Tableau statistiques ----
$html .= '<h2 class="section">Gestion des statistiques</h2>
    <table class="data"><thead><tr>
        <th>ID</th><th>Titre</th><th>Description</th><th>Catégorie</th><th>Statut</th><th>Date pub.</th><th>Téléch.</th>
    </tr></thead><tbody>';
foreach ($users as $user) {
    $catColor = $categorieColors[$user['Categorie_stat']] ?? "#7E7E7E";
    $statColor = $statutColors[$user['Statut_stat']] ?? "#7E7E7E";
    $html .= '<tr>
        <td>' . htmlspecialchars($user['ID_stat']) . '</td>
        <td>' . htmlspecialchars($user['Titre_stat']) . '</td>
        <td>' . htmlspecialchars(mb_strimwidth($user['description_stat'], 0, 50, '...')) . '</td>
        <td><span class="badge" style="background-color:' . $catColor . '20; color:' . $catColor . ';">' . htmlspecialchars($user['Categorie_stat']) . '</span></td>
        <td><span class="badge" style="background-color:' . $statColor . '20; color:' . $statColor . ';">' . htmlspecialchars($user['Statut_stat']) . '</span></td>
        <td>' . htmlspecialchars($user['date_stat_pub']) . '</td>
        <td>' . htmlspecialchars($user['nbre_stat']) . '</td>
    </tr>';
}
$html .= '</tbody></table>';

// ---- Tableau économique ----
$html .= '<h2 class="section">Données économiques (À propos)</h2>
    <table class="data"><thead><tr>
        <th>PIB réel (milliers MAD)</th><th>Population (millions)</th><th>PIB Dépenses publiques</th><th>Inflation</th>
    </tr></thead><tbody>';
foreach ($economique as $e) {
    $html .= '<tr>
        <td>' . htmlspecialchars($e['PIB']) . '</td>
        <td>' . htmlspecialchars($e['Population']) . '</td>
        <td>' . htmlspecialchars($e['PIB_dp']) . '</td>
        <td>' . htmlspecialchars($e['Inflation']) . '</td>
    </tr>';
}
$html .= '</tbody></table>';

// ---- Tableau réseau ----
$html .= '<h2 class="section">Réseau statistique (Découvrir)</h2>
    <table class="data"><thead><tr>
        <th>Directions Régionales</th><th>Bureaux Provinciaux</th><th>Données collectées</th>
    </tr></thead><tbody>';
foreach ($reseau as $r) {
    $html .= '<tr>
        <td>' . htmlspecialchars($r['Direction_reg']) . '</td>
        <td>' . htmlspecialchars($r['Bureaux_prov']) . '</td>
        <td>' . htmlspecialchars($r['Donnees_coll']) . '</td>
    </tr>';
}
$html .= '</tbody></table>';

// ---- Tableau démographique ----
$html .= '<h2 class="section">Données démographiques et sociales</h2>
    <table class="data"><thead><tr>
        <th>Hcp</th><th>Habitants</th><th>Taux croiss.</th><th>Superficie</th><th>Taux chômage</th><th>Population</th><th>PIB régional</th><th>Établissements</th><th>Taux emploi</th>
    </tr></thead><tbody>';
foreach ($donne as $d) {
    $html .= '<tr>
        <td>' . htmlspecialchars($d['Hcp']) . '</td>
        <td>' . htmlspecialchars($d['habitants']) . '</td>
        <td>' . htmlspecialchars($d['Taux_croiss']) . '</td>
        <td>' . htmlspecialchars($d['Superficie']) . '</td>
        <td>' . htmlspecialchars($d['Taux_chomage']) . '</td>
        <td>' . htmlspecialchars($d['Population']) . '</td>
        <td>' . htmlspecialchars($d['PIB_reg']) . '</td>
        <td>' . htmlspecialchars($d['Etablissements']) . '</td>
        <td>' . htmlspecialchars($d['Taux_emploi']) . '</td>
    </tr>';
}
$html .= '</tbody></table>';

$html .= '</body></html>';

// ---- Génération PDF ----
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();

$dompdf->stream("rapport_complet_HCP_" . date('Y-m-d') . ".pdf", ["Attachment" => true]);
exit();