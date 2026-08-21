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


$sql = $pdo->query("SELECT id,site,email,telephone,logo_site,logo_home FROM setting ORDER BY id DESC");
$setting = $sql->fetchAll(PDO::FETCH_ASSOC);
$logo_site = $pdo->query("Select logo_site from setting where id=0")->fetchColumn();
$logo_home = $pdo->query("Select logo_home from setting where id=0")->fetchColumn();
$site = $pdo->query("Select site from setting where id=0")->fetchColumn();
?>
<?php
include "dbconnect.php";
$par_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$debut = ($page - 1) * $par_page;
$statut = "Publié";

$stmt = $pdo->prepare("SELECT * FROM statique WHERE Statut_stat = :statut LIMIT :debut, :par_page");
$stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
$stmt->bindValue(':debut', $debut, PDO::PARAM_INT);
$stmt->bindValue(':par_page', $par_page, PDO::PARAM_INT);
$stmt->execute();
$statiques = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM statique WHERE Statut_stat = :statut");
$stmtCount->execute(['statut' => $statut]);
$total = $stmtCount->fetchColumn();

$total_pages = ceil($total / $par_page);
?>


<?php
//search
include "dbconnect.php";

$par_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$debut = ($page - 1) * $par_page;

$statut = "Publié";
$search = $_GET['searchInput'] ?? '';
$date = $_GET['searchcalendrier'] ?? '';
$Categorie = $_GET['Categorie'] ?? '';


$sql = "SELECT * FROM statique 
        WHERE Statut_stat = :statut
        AND (Titre_stat LIKE :search OR description_stat LIKE :search)
        AND date_stat_pub LIKE :date
        AND Categorie_stat LIKE :Categorie_stat
        LIMIT :debut, :par_page";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':date', "%$date%", PDO::PARAM_STR);
$stmt->bindValue(':debut', $debut, PDO::PARAM_INT);
$stmt->bindValue(':par_page', $par_page, PDO::PARAM_INT);
$stmt->bindValue(':Categorie_stat', "%$Categorie%", PDO::PARAM_STR);
$stmt->execute();
$statiques = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlCount = "SELECT COUNT(*) FROM statique  
             WHERE Statut_stat = :statut
             AND (Titre_stat LIKE :search OR description_stat LIKE :search)
             AND Categorie_stat LIKE :Categorie_stat
             AND date_stat_pub LIKE :date";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->bindValue(':statut', $statut, PDO::PARAM_STR);
$stmtCount->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmtCount->bindValue(':date', "%$date%", PDO::PARAM_STR);
$stmtCount->bindValue(':Categorie_stat', $Categorie, PDO::PARAM_INT);
$stmtCount->execute();
$total = $stmtCount->fetchColumn();
$total_pages = ceil($total / $par_page);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="enquete_hcp.css">
    <link rel="stylesheet" href="statique_hcp.css">
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

<div class="enquetes-container" style="background-color:rgba(255, 255, 255, 0.5);padding:50px;border-radius:10px;">

    <div class="header">
        <h1>Nos Statistiques</h1>
        <p>Accédez à toutes les statistiques menées par le HCP</p>
    </div>

    <div class="filters">
        <form method="GET">
            <input type="text" placeholder="Rechercher une statique..." id="searchInput" name="searchInput">
            <input id="searchcalendrier" name="searchcalendrier" class="input-date" type="date" style="cursor:pointer;">
            <select id="Categorie" name="Categorie" style="width:210px;">
                <option value="">Tous les Categories</option>
                <option value="Economie">Economie</option>
                <option value="Marché du travail">Marché du travail</option>
                <option value="Revenu & conditions de vie">Revenu & conditions de vie</option>
                <option value="Population & démographie">Population & démographie</option>
                <option value="Développement durable">Développement durable</option>
                <option value="Autres...">Autres...</option>
            </select>
            <button type="submit" style="cursor:pointer;">Rechercher</button>
        </form>
        
    </div>

    <div class="cards">
        <?php foreach($statiques as $statique){ ?>

        <div class="card">
            <img src="data:image/jpeg;base64,<?= base64_encode($statique['Image_stat']) ?>">
            <h3><?= $statique['Titre_stat'] ?></h3>
            <div class="description"><p>
                <?= $statique['description_stat'] ?>
            </p></div>

            <div class="details">
                <span class="<?= getCategorieClass($statique['Categorie_stat']) ?>"><?= $statique['Categorie_stat'] ?></span>
                <span style="color:rgb(51, 51, 51);background-color: rgba(202, 202, 202, 0.04);padding:4px 15px;border-radius: 5px;border:1px solid rgb(92, 92, 92);"><?= $statique['date_stat_pub'] == '0000-00-00' ? 'Date non disponible' : $statique['date_stat_pub'] ?></span>
            </div>

            <div class="buttons">
                <a href="statique_detail.php?id=<?= urlencode($statique['id']) ?>">Voir détails</a>
                <?php if(!empty($statique['link_files'])): ?>
                    <a href="../<?= $statique['link_files'] ?>" download="<?= $statique['link_files'] ?>" onclick="incrementerTelechargement(<?= $statique['id'] ?>, this)">Télécharger</a>
                <?php else: ?>
                    <a href="#" class="disabled" onclick="return false;">Télécharger</a>
                <?php endif; ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php
        $par_page = 12;
        $total_st = $pdo->query("SELECT COUNT(*) FROM statique")->fetchColumn();
        $total_pages = ceil($total_st / $par_page);
    ?>      
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href="?page=<?= $i ?>">
                <button><?= $i ?></button>
            </a>
        <?php } ?>
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