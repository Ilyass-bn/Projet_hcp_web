<?php
header('Content-Type: application/json');
include "../dbconnect.php";

$apiKey = ""; 

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';
$history = $input['history'] ?? [];

if (empty($userMessage)) {
    echo json_encode(['error' => 'Message vide']);
    exit;
}

//AI load the database




 //tableau gestion_donne_economique
$stmt4 = $pdo->query("SELECT PIB, Population, PIB_dp, Inflation FROM gestion_donne_economique LIMIT 10");
$economique = $stmt4->fetchAll(PDO::FETCH_ASSOC);

 //tableau  gestion_donn_dem
$stmt5 = $pdo->query("SELECT ID_hcp, Hcp, habitants, Taux_croiss, Superficie, Taux_chomage, Population, PIB_reg, Etablissements, Taux_emploi FROM gestion_donn_dem LIMIT 5");
$donneesDem = $stmt5->fetchAll(PDO::FETCH_ASSOC);

 //tableau reseau s
$stmt6 = $pdo->query("SELECT ID_res, Direction_reg, Bureaux_prov, Donnees_coll FROM gestion_reseau LIMIT 5");
$reseau = $stmt6->fetchAll(PDO::FETCH_ASSOC);
 //tableau reseux sociaux 
$stmt7 = $pdo->query("SELECT facebook_link, x_link, linkedin_link, youtube_link, instagram_link FROM reseaux_link WHERE id = 0");
$reseauxLink = $stmt7->fetch(PDO::FETCH_ASSOC);

$contexte = "\n=== DONNÉES ÉCONOMIQUES (À propos) ===\n";
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
$contexte .= "Tu es l'assistant virtuel officiel du site du Haut-Commissariat au Plan (HCP) du Maroc.

RÔLE :
- Tu aides les visiteurs à trouver des informations sur les publications, enquêtes, statistiques et données économiques/démographiques du HCP.
- Tu réponds uniquement à partir des données fournies ci-dessous. Tu ne dois jamais inventer de chiffres, dates ou titres.
- Si une information demandée n'est pas présente dans les données fournies, dis-le clairement et propose à l'utilisateur de consulter directement le site ou de contacter le HCP, plutôt que de deviner.

TON :
- Reste professionnel, clair et concis (institution publique).
- Réponds en français par défaut, sauf si l'utilisateur écrit en arabe ou en anglais — dans ce cas, réponds dans la même langue.
- Pas de familiarité excessive, mais reste accessible (pas de jargon technique inutile).

FORMAT :
- Réponses courtes et directes (3-5 phrases maximum sauf si l'utilisateur demande plus de détails).
- Utilise des listes à puces si tu cites plusieurs publications/enquêtes/statistiques.
- Ne répète jamais l'intégralité des données brutes fournies : résume et sélectionne ce qui est pertinent pour la question posée.

Voici les données disponibles :\n\n";

$messages = [
    ['role' => 'system', 'content' => $contexte]
];
$messages = array_merge($messages, $history);
$messages[] = ['role' => 'user', 'content' => $userMessage];

$data = [
    'model' => 'openai/gpt-oss-120b',
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
