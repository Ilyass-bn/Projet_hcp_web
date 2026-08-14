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
include "dbconnect.php";
$par_page = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$debut = ($page - 1) * $par_page;
$statut = "Terminée";

$stmt = $pdo->prepare("SELECT * FROM enquete WHERE Statut = :statut LIMIT :debut, :par_page");
$stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
$stmt->bindValue(':debut', $debut, PDO::PARAM_INT);
$stmt->bindValue(':par_page', $par_page, PDO::PARAM_INT);
$stmt->execute();
$enquetes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtCount = $pdo->prepare("SELECT COUNT(*) FROM enquete WHERE Statut = :statut");
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

$statut = "Terminée";
$search = $_GET['searchInput'] ?? '';
$date = $_GET['searchcalendrier'] ?? '';


$sql = "SELECT * FROM enquete 
        WHERE Statut = :statut
        AND Titre LIKE :search
        AND date_fin LIKE :date
        LIMIT :debut, :par_page";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmt->bindValue(':date', "%$date%", PDO::PARAM_STR);
$stmt->bindValue(':debut', $debut, PDO::PARAM_INT);
$stmt->bindValue(':par_page', $par_page, PDO::PARAM_INT);
$stmt->execute();
$enquetes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sqlCount = "SELECT COUNT(*) FROM enquete 
             WHERE Statut = :statut
             AND Titre LIKE :search
             AND date_fin LIKE :date";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->bindValue(':statut', $statut, PDO::PARAM_STR);
$stmtCount->bindValue(':search', "%$search%", PDO::PARAM_STR);
$stmtCount->bindValue(':date', "%$date%", PDO::PARAM_STR);
$stmtCount->execute();
$total = $stmtCount->fetchColumn();
$total_pages = ceil($total / $par_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="enquete_hcp.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <div class="bar-haut">
        <div class="logo-hpc"><img src="../src/img/hcp_logo.png"></div>
        <nav>
            <a href="home.php" class="<?php echo ($current == 'home.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Accueil</a>
            <a href="about.php" class="<?php echo ($current == 'about.php') ? 'active' : ''; ?>" onclick="changeActive(this)">À propos</a>
            <a href="institutions.php" class="<?php echo ($current == 'institutions.php') ? 'active' : ''; ?>" onclick="changeActive(this)">institutions</a>
            <a href="enquete_hcp.php" class="<?php echo ($current == 'enquete_hcp.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)">Enquêtes</a>
            <a href="#" onclick="changeActive(this)">Statistiques</a>
            <a href="contact.php" class="<?php echo ($current == 'contact.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Contactez-nous</a>
            <button onclick="window.location.href='login.php'">Login</button>
        </nav>
    </div>

<div class="enquetes-container">

    <div class="header">
        <h1>Nos enquêtes</h1>
        <p>Accédez à toutes les enquêtes menées par le HCP</p>
    </div>

    <div class="filters">
        <form method="GET">
            <input type="text" placeholder="Rechercher une enquête..." id="searchInput" name="searchInput">
            <input id="searchcalendrier" name="searchcalendrier" class="input-date" type="date" style="cursor:pointer;">
            <button type="submit" style="cursor:pointer;">Rechercher</button>
        </form>
        
    </div>

    <div class="cards">
        <?php foreach($enquetes as $enquete){ ?>

        <div class="card">
            <img src="data:image/jpeg;base64,<?= base64_encode($enquete['Image_enquete']) ?>">
            <span class="status">En cours</span>
            <h3><?= $enquete['Titre'] ?></h3>
            <p>
                Fournir des indicateurs conjoncturels sur l'emploi.
            </p>

            <div class="details">
                <span><?= $enquete['Type'] ?></span>
                <span><?= $enquete['Direction'] ?></span>
                <span><?= $enquete['date_fin'] ?></span>
            </div>

            <div class="buttons">
                <a href="#">Voir détails</a>
                <a href="../<?= $enquete['link'] ?>" download="<?= $enquete['link'] ?>">Télécharger</a>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php
        $par_page = 12;
        $total_enquetes = $pdo->query("SELECT COUNT(*) FROM enquete")->fetchColumn();
        $total_pages = ceil($total_enquetes / $par_page);
    ?>      
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href="?page=<?= $i ?>">
                <button><?= $i ?></button>
            </a>
        <?php } ?>
    </div>
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
            <div class="logo-bar-bas"><img src="../src/img/logo-bar-bas1.png"></div>
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

    //search
    function filterUsers() {
        const input = document.getElementById("searchInput").value.toLowerCase().trim();
        const calendrier = document.getElementById("searchcalendrier").value;

        rows.forEach(row => {
            const ID = row.children[0]?.textContent.toLowerCase() || "";
            const Titre = row.children[2]?.textContent.toLowerCase() || "";
            const Type = row.children[3]?.textContent.toLowerCase() || "";
            const Direction = row.children[4]?.textContent.trim() || "";
            const Statut = row.children[5]?.textContent.trim() || "";
            const calendrier_1 = row.children[6]?.textContent.trim() || "";
            const calendrier_2 = row.children[7]?.textContent.trim() || "";

            const matchesText = ID.includes(input) || Titre.includes(input) || Direction.includes(input) || Type.includes(input);
            const matchesStatus = !statusFilter || Statut === statusFilter;
            const matchescalendrier = !calendrier || calendrier_1===calendrier || calendrier_2===calendrier;

            if (matchesText && matchesStatus && matchescalendrier) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
    });
    }

</script>
</body>
</html>
<!-- <select>
            <option>Tous les types</option>
        </select>-->