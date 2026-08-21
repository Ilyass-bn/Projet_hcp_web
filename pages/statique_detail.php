<?php
include "dbconnect.php";

$current = basename($_SERVER['PHP_SELF']);

$sql = $pdo->query("SELECT id,description,title FROM hcp_des ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);

$description= $pdo->query("Select description from hcp_des where id=0")->fetchColumn();
$title = $pdo->query("Select title from hcp_des where id=0")->fetchColumn();

//reseaux sociaux 
$sql = $pdo->query("SELECT id,facebook_link,x_link,linkedin_link,youtube_link,instagram_link from reseaux_link ORDER BY id DESC");
$facebook_link = $pdo->query("Select facebook_link from reseaux_link where id=0")->fetchColumn();
$x_link = $pdo->query("Select x_link from reseaux_link where id=0")->fetchColumn();
$linkedin_link = $pdo->query("Select linkedin_link from reseaux_link where id=0")->fetchColumn();
$youtube_link = $pdo->query("Select youtube_link from reseaux_link where id=0")->fetchColumn();
$instagram_link = $pdo->query("Select instagram_link from reseaux_link where id=0")->fetchColumn();

?>
<?php
    if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM statique WHERE id = ?");
    $stmt->execute([$id]);
    $statique = $stmt->fetch(); 
    }
?>


<?php
//color backgoround
function getCategorieClass($categorie) {
    $map = [
        'Economie' => 'status-economie',
        'Marché du travail' => 'status-travail',
        'Revenu & conditions de vie' => 'status-condition',
        'Population & démographie' => 'status-pop',
        'Développement durable' => 'status-dev',
        'Autres...' => 'status-autres',
    ];
    return $map[$categorie] ?? 'cat-default';
}



$sql = $pdo->query("SELECT id,site,email,telephone,logo_site,logo_home FROM setting ORDER BY id DESC");
$setting = $sql->fetchAll(PDO::FETCH_ASSOC);
$logo_site = $pdo->query("Select logo_site from setting where id=0")->fetchColumn();
$logo_home = $pdo->query("Select logo_home from setting where id=0")->fetchColumn();
$site = $pdo->query("Select site from setting where id=0")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="enquete_hcp.css">
    <link rel="stylesheet" href="statique_hcp.css">
    <link rel="stylesheet" href="publication_hcp.css">
    <link rel="stylesheet" href="publication_detail.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title><?= $site ?></title>
</head>
<body>
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <div class="bar-haut">
        <div class="logo-hpc"><img src="../src/img/<?= htmlspecialchars($logo_site) ?>"></div>
        <nav>
            <a href="home.php" class="<?php echo ($current == 'home.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Accueil</a>
            <a href="about.php" class="<?php echo ($current == 'about.php') ? 'active' : ''; ?>" onclick="changeActive(this)">À propos</a>
            <a href="institutions.php" class="<?php echo ($current == 'institutions.php') ? 'active' : ''; ?>" onclick="changeActive(this)">institutions</a>
            <a href="publication_hcp.php" class="<?php echo ($current == 'publication_hcp.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Publications</a>
            <a href="enquete_hcp.php" class="<?php echo ($current == 'enquete_hcp.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)">Enquêtes</a>
            <a href="statique_hcp.php" class="<?php echo ($current == 'statique_hcp.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Statistiques</a>
            <a href="contact.php" class="<?php echo ($current == 'contact.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Contactez-nous</a>
            <button onclick="window.location.href='login.php'">Login</button>
        </nav>
    </div>

<div class="enquetes-container" style="padding:50px;border-radius:10px;">
    <div class="header" style="margin-left:220px;">
        <a href="statique_hcp.php" style="text-decoration: none;color:#7b1e54;"><h1 style="font-size:20px;">&larr;  Retour à la liste des statistiques</h1></a>
    </div>
    <div class="page">
    
    <section class="publication-header">

        <div class="cover">
            <img src="data:image/jpeg;base64,<?= base64_encode($statique['Image_stat']) ?>">
        </div>

        
        <div class="main-info">

            <h1><?= htmlspecialchars($statique['Titre_stat']) ?></h1>

            <div class="meta-buttons">
                <span class="<?= getCategorieClass($statique['Categorie_stat']) ?>"><?= htmlspecialchars($statique['Categorie_stat']) ?></span>
                <span class="date"><?= $statique['date_stat_pub'] == '0000-00-00' ? 'Date non disponible' : $statique['date_stat_pub'] ?></span>

                <div class="download">
                <?php if(!empty($statique['link_files'])): ?>
                    <a href="../<?= $statique['link_files'] ?>" download="<?= $statique['link_files'] ?>" onclick="incrementerTelechargement(<?= $statique['id'] ?>, this)">Télécharger</a>
                <?php else: ?>
                    <a href="#" class="disabled" onclick="return false;" style="display:none;">Télécharger</a>
                <?php endif; ?>
                </div>
            </div>

        </div>

    </section>


    <section class="section">
        <h2>Description</h2>

        <p class="description"><?= htmlspecialchars($statique['description_stat']) ?></p>
    </section>


    <div class="separator"></div>

    <section class="section details-section">

        <h2>Détails</h2>

        <div class="details">

            <div class="details-column">

                <div class="detail">
                    <strong>Type de publication :</strong>
                    <span><?= htmlspecialchars($statique['Categorie_stat']) ?></span>
                </div>

                <div class="detail">
                    <strong>Date de publication :</strong>
                    <span><?= htmlspecialchars($statique['date_stat_pub']) ?></span>
                </div>


            </div>


            <div class="details-column">

                <div class="detail">
                    <strong>Éditeur :</strong>
                    <span>Haut-Commissariat au Plan</span>
                </div>

            </div>

        </div>

    </section>

    
</div>
    
</div>

    <div class="btn-ai">
        <button onclick="window.location.href='chat_ai.php'">
            <img src="../src/icons/ai.png">
        </button>
    </div>
    <div class="bottom">
        <div class="bar-bas">
            <div class="reseau">
                <p>Rejoignez-nous sur :</p>
                <nav class="logo-media">
                    <a href="<?= $youtube_link ?>"><img src="../src/icons/youtube-icon1.png"></a>
                    <a href="<?= $facebook_link ?>"><img src="../src/icons/facebook-icon1.png"></a>
                    <a href="<?= $instagram_link ?>"><img src="../src/icons/instagram-icon1.png"></a>
                    <a href="<?= $x_link ?>"><img src="../src/icons/twitter-icon1.png"></a>
                    <a href="<?= $linkedin_link ?>"><img src="../src/icons/linkedin-icon1.png"></a>
                </nav>
            </div>
            <div class="logo-bar-bas"><img src="../src/img/<?= htmlspecialchars($logo_home) ?>"></div>
        </div>
        <div class="copy-right">
            <p>Haut-Commissariat au Plan du Maroc © 2026<br>
            Centre National de Documentation<br>
            En poursuivant votre navigation, vous acceptez l'utilisation de cookies, afin de réaliser des statistiques d'audience.</p>
        </div>
    </div>
    

<!--javascript-->
<script>
    function changeActive(element){
        const links = document.querySelectorAll('.bar-haut nav a');
        links.forEach(link => { link.classList.remove('active') });
        element.classList.add('active');
    }
</script>

<script>
//telechargement 
function incrementerTelechargement(id, linkElement) {
    fetch('utilisateurs_actions/statique/incrementer_telechargement_statique.php?id=' + id)
        .then(response => response.json())
        .catch(error => console.error('Erreur incrementation telechargement:', error));
    // pas de tableau ici (cartes publiques) donc pas de mise a jour visuelle,
    // le compteur nbre_tel est juste incremente en base
}

</script>
</body>
</html>
<!-- <select>
            <option>Tous les types</option>
        </select>-->