<?php
header('Content-Type: application/json');
include "../dbconnect.php";

$apiKey = "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"; 

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';
$history = $input['history'] ?? [];

if (empty($userMessage)) {
    echo json_encode(['error' => 'Message vide']);
    exit;
}

//AI load the database
$stmt = $pdo->query("SELECT Titre_pub, Categorie, date_pub, description FROM publication ORDER BY date_pub DESC LIMIT 10");
$publications = $stmt->fetchAll(PDO::FETCH_ASSOC);

  //tableau enquete 
$stmt2 = $pdo->query("SELECT ID_enquete, Titre, Type, Direction, date_fin FROM enquete ORDER BY date_debut DESC LIMIT 10");
$enquetes = $stmt2->fetchAll(PDO::FETCH_ASSOC);

  //tableau statiques
$stmt3 = $pdo->query("SELECT ID_stat, Titre_stat, description_stat, Categorie_stat, date_stat_pub FROM statique ORDER BY date_stat_pub DESC LIMIT 10");
$statiques = $stmt3->fetchAll(PDO::FETCH_ASSOC); 

 //tableau gestion_donne_economique
$stmt4 = $pdo->query("SELECT PIB, Population, PIB_dp, Inflation FROM gestion_donne_economique");
$economique = $stmt4->fetchAll(PDO::FETCH_ASSOC);

 //tableau  gestion_donn_dem
$stmt5 = $pdo->query("SELECT ID_hcp, Hcp, habitants, Taux_croiss, Superficie, Taux_chomage, Population, PIB_reg, Etablissements, Taux_emploi FROM gestion_donn_dem");
$donneesDem = $stmt5->fetchAll(PDO::FETCH_ASSOC);

 //tableau reseau s
$stmt6 = $pdo->query("SELECT ID_res, Direction_reg, Bureaux_prov, Donnees_coll FROM gestion_reseau");
$reseau = $stmt6->fetchAll(PDO::FETCH_ASSOC);
 //tableau reseux sociaux 
$stmt7 = $pdo->query("SELECT facebook_link, x_link, linkedin_link, youtube_link, instagram_link FROM reseaux_link WHERE id = 0");
$reseauxLink = $stmt7->fetch(PDO::FETCH_ASSOC);

$contexte = "Tu es l'assistant du site du Haut-Commissariat au Plan (HCP). Voici la liste des publications disponibles dans la base de données :\n\n";
foreach ($publications as $pub) {
    $contexte .= "- Titre: {$pub['Titre_pub']} | Catégorie: {$pub['Categorie']} | Date: {$pub['date_pub']}\n";
    $contexte .= "  Description: {$pub['description']}\n\n";
}

$contexte .= "\n=== ENQUÊTES ===\n";
foreach ($enquetes as $enq) {
    $contexte .= "- ID: {$enq['ID_enquete']} | Titre: {$enq['Titre']} | Type: {$enq['Type']} | Direction: {$enq['Direction']}\n";
    $contexte .= "  Date publication:{$enq['date_fin']}\n\n";
}

$contexte .= "\n=== STATISTIQUES ===\n";
foreach ($statiques as $stat) {
    $contexte .= "- ID: {$stat['ID_stat']} | Titre: {$stat['Titre_stat']} | Catégorie: {$stat['Categorie_stat']} | Date: {$stat['date_stat_pub']}\n";
    $contexte .= "  Description: {$stat['description_stat']}\n\n";
}

$contexte .= "\n=== DONNÉES ÉCONOMIQUES (À propos) ===\n";
foreach ($economique as $eco) {
    $contexte .= "- PIB réel (milliers MAD): {$eco['PIB']} | Population (millions): {$eco['Population']} | PIB Dépenses publiques: {$eco['PIB_dp']} | Inflation: {$eco['Inflation']}%\n\n";
}

$contexte .= "\n=== DONNÉES DÉMOGRAPHIQUES ET SOCIALES PAR RÉGION ===\n";
foreach ($donneesDem as $dem) {
    $contexte .= "- Région/Direction: {$dem['Hcp']} (ID: {$dem['ID_hcp']})\n";
    $contexte .= "  Habitants: {$dem['habitants']} | Taux de croissance: {$dem['Taux_croiss']}% | Superficie: {$dem['Superficie']} km²\n";
    $contexte .= "  Taux de chômage: {$dem['Taux_chomage']}% | Population: {$dem['Population']} | PIB régional: {$dem['PIB_reg']}\n";
    $contexte .= "  Établissements: {$dem['Etablissements']} | Taux d'emploi: {$dem['Taux_emploi']}%\n\n";
}

$contexte .= "\n=== RÉSEAU STATISTIQUE (Découvrir) ===\n";
foreach ($reseau as $res) {
    $contexte .= "- Directions Régionales: {$res['Direction_reg']} | Bureaux Provinciaux: {$res['Bureaux_prov']} | Données collectées: {$res['Donnees_coll']}\n\n";
}

$contexte .= "\n=== LIENS RÉSEAUX SOCIAUX ===\n";
if ($reseauxLink) {
    $contexte .= "- Facebook: {$reseauxLink['facebook_link']}\n";
    $contexte .= "- X (Twitter): {$reseauxLink['x_link']}\n";
    $contexte .= "- LinkedIn: {$reseauxLink['linkedin_link']}\n";
    $contexte .= "- YouTube: {$reseauxLink['youtube_link']}\n";
    $contexte .= "- Instagram: {$reseauxLink['instagram_link']}\n\n";
}


$contexte .= "Réponds aux questions de l'utilisateur en te basant sur ces données. Si l'information demandée n'y figure pas, dis-le clairement.";


$messages = [
    ['role' => 'system', 'content' => $contexte]
];
$messages = array_merge($messages, $history);
$messages[] = ['role' => 'user', 'content' => $userMessage];

$data = [
    'model' => 'llama-3.3-70b-versatile',
    'max_tokens' => 1024,
    'messages' => $messages
];

$ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode !== 200) {
    echo json_encode(['error' => 'Erreur API', 'http_code' => $httpCode, 'details' => $response]);
    exit;
}

$result = json_decode($response, true);
$reply = $result['choices'][0]['message']['content'] ?? 'Erreur : pas de réponse';

echo json_encode(['reply' => $reply]);
?>