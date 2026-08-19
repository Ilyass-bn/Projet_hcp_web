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

//gestion_donne_economique 
$sql = $pdo->query("SELECT ID_eco,PIB,Population,PIB_dp,Inflation from gestion_donne_economique");
$PIB = $pdo->query("Select PIB from gestion_donne_economique where ID_eco=0")->fetchColumn();
$Population = $pdo->query("Select Population from gestion_donne_economique where ID_eco=0")->fetchColumn();
$PIB_dp = $pdo->query("Select PIB_dp from gestion_donne_economique where ID_eco=0")->fetchColumn();
$Inflation = $pdo->query("Select Inflation from gestion_donne_economique where ID_eco=0")->fetchColumn();


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
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="about.css">
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
            <p class="title">À propos</p>
            <h1 class="description">Le Haut-Commissariat au Plan est l'institution nationale chargée de 
                la production, de l'analyse et de la diffusion des statistiques officielles pour éclairer 
                la décision publique et accompagner le développement durable du Royaume du Maroc.</h1>
        </div>
        <div class="image-body-contact"><img src="../src/img/hcp-img.png"></div>
    </div>

    <!--card statistiques-->
    <div class="cards-info">
        <div class="card-people">
            <div class="image-icon"><img src="../src/icons/societe.png"></div>
            <div class="card-content">
                <h1 class="title"><?= $PIB ?></h1>
                <p class="description">milliers MAD<br>PIB réel (2026)</p>
                <p class="details">Le PIB du Maroc en 2026</p>
            </div>
            
        </div>
        <div class="card-statique">
            <div class="image-icon"><img src="../src/icons/statique.png"></div>
            <div class="card-content">
                <h1 class="title"><?= $Population ?></h1>
                <p class="description">millions<br>Population (2026)</p>
                <p class="details">La population du Royaume</p>
            </div>
        </div>
        <div class="card-pib">
            <div class="image-icon"><img src="../src/icons/pourcentage.png"></div>
            <div class="card-content">
                <h1 class="title"><?= $PIB_dp ?> %</h1>
                <p class="description">du PIB<br>Dépenses publiques (2026)</p>
                <p class="details-pourcentage">Poids des dépenses publiques</p>
            </div>
        </div>
        <div class="card-inflation">
            <div class="reseau">
                <div class="image-icon"><img src="../src/icons/augmentation.png"></div>
                <div class="card-content">
                    <h1 class="title"><?= $Inflation ?> %</h1>
                    <p class="description">Inflation (2026)</p>
                    <p class="details-inflation">Taux d'inflation annuel</p>
                </div>                
            </div>
        </div>
    </div>


    <!--mission-->
    <div class="cards-mission">
        <div class="card-notre-mession">
            <h1 class="text">Notre mission</h1>
            <div class="notre-mission">
                <div class="text-para">
                    <p>Produire des statistiques fiables et pertinentes, analyser les phénomènes économiques, sociaux 
                        et démographiques et contribuer à
                        l'évaluation des politiques publiques pour un Maroc prospère et durable..
                    </p>
                    <button>En savoir plus</button>
                </div>
                <div class="image"><img src="../src/icons/mission-chart.png"></div>                
            </div>            
        </div>
        <div class="card-valeurs">
            <h1 class="text">Nos valeurs</h1>
            <div class="caracteristique">
                <div class="ligne">
                    <div class="image"><img src="../src/icons/approve.png"></div>
                    <p class="cara-text">Impartialité</p>
                </div>
                <div class="ligne">
                    <div class="image"><img src="../src/icons/approve.png"></div>
                    <p class="cara-text">Crédibilité</p>
                </div>
                <div class="ligne">
                    <div class="image"><img src="../src/icons/approve.png"></div>
                    <p class="cara-text">Transparence</p>
                </div>
                <div class="ligne">
                    <div class="image"><img src="../src/icons/approve.png"></div>
                    <p class="cara-text">Excellence</p>
                </div>
                <div class="ligne">
                    <div class="image"><img src="../src/icons/approve.png"></div>
                    <p class="cara-text">Service public</p>
                </div>
            </div>      
        </div>
        <div class="card-chiffre">
            <h1 class="text">En chiffres depuis 2026</h1>
            <div class="chiffre">
                <div class="chiffre1">
                    <div class="image"><img src="../src/icons/requete-icon.png"></div>
                    <div class="paragraphe">
                        <h1 class="text-info">250+</h1>
                        <p>Enquêtes réalisées<br><span>Annuellement</span></p>                          
                    </div>

                </div>
                <div class="chiffre2">
                    <div class="image"><img src="../src/icons/document-icon.png"></div>  
                    <div class="paragraphe">
                        <h1 class="text-info">100+</h1>
                        <p>Publications diffusées<br><span>Chaque année</span></p>                          
                    </div>
                
                </div>
            </div>
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
</body>
</html>