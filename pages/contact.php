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
$telephone = $pdo->query("Select telephone from setting where id=0")->fetchColumn();
$email = $pdo->query("Select email from setting where id=0")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="contact.css">
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

    <div class="home-body-contact">
        <div class="para1">
            <p class="title">Contactez-nous</p>
            <h1 class="description">Nous sommes à votre écoute pour toute question, demande d'information ou collaboration. N'hésitez pas à nous contacter.</h1>
        </div>
        <div class="image-body-contact"><img src="../src/img/hcp-img.png"></div>
    </div>

    <div class="cards-contact">
        <div class="card-tel">
            <div class="image-icon"><img src="../src/icons/phone-call.png"></div>
            <div class="card-content">
                <h1 class="title">Téléphone</h1>
                <p class="description"><?= $telephone ?><br>Du lundi au vendredi<br>8h30 – 16h30</p>
            </div>
            
        </div>
        <div class="card-email">
            <div class="image-icon"><img src="../src/icons/email.png"></div>
            <div class="card-content">
                <h1 class="title">Email</h1>
                <a href="contact@hcp.ma" class="description" target="_blank"><p><?= $email ?></p></a>
                <p class="description-email">Reponse sous 48h</p>
            </div>
        </div>
        <div class="card-adresse">
            <div class="image-icon"><img src="../src/icons/gps.png"></div>
            <div class="card-content">
                <h1 class="title">Adresse</h1>
                <p class="description">101, Rue Abou Alâa Zahar<br>Agdal, Rabat<br>Maroc</p>
            </div>
        </div>
        <div class="card-media">
            <div class="reseau">
                <div class="image-icon"><img src="../src/icons/social-media-management.png"></div>
                <div class="card-content">
                    <h1 class="title-reseau">Réseaux sociaux</h1>
                </div>                
            </div>
            <nav class="logo-media-card">
                <a href="https://www.instagram.com/hcp.maroc/" target="_blank"><img src="../src/icons/instagram-icon1.png"></a>
                <a href="http://twitter.com/@hcpmaroc" target="_blank"><img src="../src/icons/twitter-icon1.png"></a>
                <a href="https://www.linkedin.com/company/hcp-maroc" target="_blank"><img src="../src/icons/linkedin-icon1.png"></a>
            </nav>
        </div>
    </div>
    <!--cards information-->
    <div class="cards-information" style="z-index:100;">
        <div class="card-envoyer">
            <form action="send_mail.php" method="POST">
                <h1 class="text-info">Envoyer-nous un message</h1>
                <input class="input-nom" type="text" placeholder="Nom complet" name="nom" required>
                <input class="input-email" type="email" placeholder="Email" name="email" required><br>
                <input class="input-select" type="select" placeholder="Objet" name="objet" required><br>
                <textarea class="input-textarea" placeholder="Votre message" rows="5" name="message" required></textarea><br>
                <input class="input-submit" type="submit" value="Envoyer">
                <p>Nous vous répondrons dans les meilleurs délais.</p>
            </form>
            
        </div>
        <div class="card-location">
            <h1 class="text-info">Nous trouver</h1>
            <div class="map-image"><img src="../src/img/map.PNG"></div>
            <a href="https://maps.app.goo.gl/FVpDRq33VH1SC774A" class="map" target="_blank">Voir sur Google Maps</a>    
        </div>
        <div class="card-houres">
            <h1 class="text-info">Horaires d'ouverture</h1>
            <div class="horaires">
                <div class="ligne">
                    <span class="jour">Lundi - Vendredi</span>
                    <span class="horaire">08:30 - 16:30</span>
                </div>
                <div class="ligne">
                    <span class="jour-samedi">Samedi</span>
                    <span class="horaire">Fermé</span>
                </div>
                <div class="ligne">
                    <span class="jour-dimanche">Dimanche</span>
                    <span class="horaire">Fermé</span>
                </div>
            </div>
            <div class="details">
                <div class="description">
                    <h1>Besoin d'informations ?</h1>
                    <p>Notre équipe est à votre disposition pour vous accompagner.</p>
                </div>
                <div class="image-icon"><img src="../src/img/horaire-img.png"></div>
            </div>
        </div>
    </div>





    <div class="btn-ai">
        <button onclick="window.location.href='chat_ai.php'">
            <img src="../src/icons/ai.png">
        </button>
    </div>

    <div class="bottom" style="z-index:0;">
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
</body>
</html>