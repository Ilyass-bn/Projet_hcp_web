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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
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
            <a href="publication_hcp.php" class="<?php echo ($current == 'publication_hcp.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Publications</a>
            <a href="enquete_hcp.php" class="<?php echo ($current == 'enquete_hcp.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)">Enquêtes</a>
            <a href="statique_hcp.php" class="<?php echo ($current == 'statique_hcp.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Statistiques</a>
            <a href="contact.php" class="<?php echo ($current == 'contact.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Contactez-nous</a>
            <button onclick="window.location.href='login.php'">Login</button>
        </nav>
    </div>
    <div class="home-body">
        <div class="para1">
            <p class="title">Bienvenue au <span><?= $title ?></span></p>
            <h1 class="description"><?= $description ?></h1>
            <div class="buttons">
                <button class="button-primary">Participer à<pre>un sondage</pre></button>
                <button class="button-secondary">Afficher <pre>les statistiques</pre></button>
            </div>
        </div>
        
        <div class="image-body"><img src="../src/img/home_img1.png"></div>
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
</script>
</body>
</html>