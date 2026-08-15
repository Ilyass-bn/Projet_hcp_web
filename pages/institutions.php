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
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="institutions.css">
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

    <div class="home-body-contact">
        <div class="para1">
            <p class="title">Le Haut-Commissariat <br>au Plan du Maroc</p>
            <h1 class="description">Des données fiables pour des décisions éclairées 
                au service d'un développement durable et inclusif..
            </h1>
            <button onclick="window.location.href='decouvert.php'">Découvrir le HCP </button>
        </div>
        <div class="image-body-contact"><img src="../src/img/hcp-img.png"></div>
    </div>


    <!--cards history-->
    <div class="cards-history">
        <div class="card-1">
            <div class="image-icon"><img src="../src/icons/societe.png"></div>
            <div class="card-content">
                <h1 class="title">1 279</h1>
                <p class="description">Collaborateurs<br><span>Au service du Royaume</span></p>
            </div>
        </div>
        <div class="card-2">
            <div class="image-icon"><img src="../src/icons/statique.png"></div>
            <div class="card-content">
                <h1 class="title">50+</h1>
                <p class="description">Années d'expertise<br><span>Depuis 1971</span></p>
            </div>
        </div>
        <div class="card-3">
            <div class="image-icon"><img src="../src/icons/document-blackred.png"></div>
            <div class="card-content">
                <h1 class="title">100+</h1>
                <p class="description">Enquêtes annuelles<br><span>Données pour demain</span></p>
            </div>
        </div>
        <div class="card-4">
            <div class="reseau">
                <div class="image-icon"><img src="../src/icons/world.png"></div>
                <div class="card-content">
                    <h1 class="title-4">10 000+</h1>
                    <p class="description">Données disponibles<br><span>Sur le Maroc</span></p>
                </div>                
            </div>
        </div>
        <div class="card-regional">
            <div class="reseau">
                <div class="image-icon"><img src="../src/icons/maroc-icon.png"></div>
                <div class="card-content">
                    <h1 class="title-regional">Régional National</h1>
                    <p class="description">Au service de tous</p>
                </div>                
            </div>
        </div>
    </div>

    <!--texte nos domaine--> 
    <div class="text-nosdomain">
        <h1>Nos domaines d'intervention</h1>
        <p>Le HCP produit des statistiques dans de nombreux domaines 
            pour mieux comprendre la société et accompagner le développement.
        </p>
    </div>

    <!--cards domaine--> 
    <div class="card-domain">
        <div class="card-domain-1">
            <div class="image-card"><img src="../src/img/Wind-turbines.png"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/people.png"></div>
                <div class="details">
                    <h1>Démographie</h1>
                    <p>Population et société</p>
                </div>
            </div>
        </div>
        <div class="card-domain-2">
            <div class="image-card"><img src="../src/img/economic.png"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/economic-icon.png"></div>
                <div class="details">
                    <h1>Économie</h1>
                    <p>Comptes et finances</p>
                </div>
            </div>
        </div>
        <div class="card-domain-3">
            <div class="image-card"><img src="../src/img/plant.png"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/plant-icon.png"></div>
                <div class="details">
                    <h1>Environnement</h1>
                    <p>Développement durable</p>
                </div>
            </div>
        </div>
        <div class="card-domain-4">
            <div class="image-card"><img src="../src/img/school.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/education-icon.png"></div>
                <div class="details">
                    <h1>Education</h1>
                    <p>Savoir et compétences</p>
                </div>
            </div>
        </div>
        <div class="card-domain-5">
            <div class="image-card"><img src="../src/img/company.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/company-icon.png"></div>
                <div class="details">
                    <h1>Social</h1>
                    <p>Conditions de vie</p>
                </div>
            </div>
        </div>
        <div class="card-domain-6">
            <div class="image-card"><img src="../src/img/terroire.jpeg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/terroire-icon.png"></div>
                <div class="details">
                    <h1>Territoires</h1>
                    <p>Régions et aménagement</p>
                </div>
            </div>
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
    </script>
</body>
</html>