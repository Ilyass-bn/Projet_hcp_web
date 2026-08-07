<?php
$json = file_get_contents('json/villes.json');
$regions = json_decode($json, true);

$id = $_GET['id'] ?? null;

$region = null;
foreach ($regions as $r) {
    if ($r['id'] === $id) {
        $region = $r;
        break;
    }
}
if (!$region) {
    die("Région non trouvée.");
}
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
    <link rel="stylesheet" href="decouvert.css">
    <link rel="stylesheet" href="ville.css">
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
            <a href="#" onclick="changeActive(this)">Enquêtes</a>
            <a href="#" onclick="changeActive(this)">Statistiques</a>
            <a href="contact.php" class="<?php echo ($current == 'contact.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Contactez-nous</a>
            <button onclick="window.location.href='login.php'">Login</button>
        </nav>
    </div>

    <!--wat-->
    <span class="breadcrumb">
        <a href="institutions.php">institutions</a><span class="separator">></span>
        <a href="decouvert.php">Découvrir</a><span class="separator">></span>
        <a href="ville.php?id=<?php echo htmlspecialchars($region['id']); ?>"><?php echo htmlspecialchars($region['nom']); ?></a>
    </span>    


    <div class="home-body-contact">
        <div class="para1">
            <p class="title"><?php echo htmlspecialchars($region['nom']); ?></p>
            <h1 class="description"><?php echo htmlspecialchars($region['description']); ?></h1>
            <button onclick="window.open('<?php echo htmlspecialchars($region['site']); ?>', '_blank')">Voir le site </button>
        </div>
        <div class="image-body-contact"><img src="../src/img/hcp-img.png"></div>
    </div>

    <!--card-info-hcp-->
    <div class="cards-history">
        <div class="card-1">
            <div class="image-icon"><img src="../src/icons/societe.png"></div>
            <div class="card-content">
                <h1 class="title"><?php echo htmlspecialchars($region['habitant']); ?></h1>
                <p class="description"><span>habitants</span></p>
            </div>
        </div>
        <div class="card-2">
            <div class="image-icon"><img src="../src/icons/augmentation.png"></div>
            <div class="card-content">
                <h1 class="title"><?php echo htmlspecialchars($region['taux_croissance']); ?></h1>
                <p class="description"><span>Taux de croissance</span></p>
            </div>
        </div>
        <div class="card-3">
            <div class="image-icon"><img src="../src/icons/icon_superficie.png"></div>
            <div class="card-content">
                <h1 class="title"><?php echo htmlspecialchars($region['superficie']); ?></h1>
                <p class="description"><span class="donne">Superficie</span></p>
            </div>
        </div>
        <div class="card-4">
            <div class="reseau">
                <div class="image-icon"><img src="../src/icons/icon_chomage.png"></div>
                <div class="card-content">
                    <h1 class="title"><?php echo htmlspecialchars($region['chomage']); ?></h1>
                    <p class="description"><span>Taux de chômage</span></p>
                </div>                
            </div>
        </div>
    </div>    

    <!--les informations de la ville-->
    <div class="card-villes">
        <div class="card-ville-1">
            <h2>Présentation</h2>
            <p class="paragraphe"><?php echo htmlspecialchars($region['presentation']); ?></p>
            <div class="info-texte">
                <div class="ligne-info">
                    <span class="info">Zone d'intervention :</span>
                    <span class="info-det"><?php echo htmlspecialchars($region['Zone']); ?></span>
                </div>
                <div class="ligne-info">
                    <span class="info">Créée en : </span>
                    <span class="info-det"><?php echo htmlspecialchars($region['creation']); ?></span>
                </div>
            </div>

            <div class="card-ville-1-mission">
                <h3>Nos missions</h3>
                <div class="mission">
                    <div class="icon"><img src="../src/icons/check.png"></div>
                    <p>Collecter des données statistiques fiables</p>
                </div>
                <div class="mission">
                    <div class="icon"><img src="../src/icons/check.png"></div>
                    <p>Analyser les phénomènes économiques et sociaux</p>
                </div>
                <div class="mission">
                    <div class="icon"><img src="../src/icons/check.png"></div>
                    <p>Appuyer la prise de décision des acteurs régionaux</p>
                </div>
                <div class="mission">
                    <div class="icon"><img src="../src/icons/check.png"></div>
                    <p>Contribuer au développement durable de la région</p>
                </div>
            </div>
        </div>
        <div class="card-ville-2">
            <div class="image-ville"><img src="<?php echo htmlspecialchars($region['image']); ?>"></div>
            <div class="statique">
                <h2>Chiffres clés de la région</h2>
                <div class="class-div">
                    <div class="classe">
                        <div class="image-icon"><img src="../src/icons/societe.png"></div>
                        <div class="texte">
                            <p>Population</p>
                            <h1><?php echo htmlspecialchars($region['population']); ?></h1>
                        </div>
                    </div>
                    <div class="classe">
                        <div class="image-icon"><img src="../src/icons/statique.png"></div>
                        <div class="texte">
                            <p>PIB régional</p>
                            <h1><?php echo htmlspecialchars($region['pib']); ?></h1>
                        </div>
                    </div>
                    <div class="classe">
                        <div class="image-icon"><img src="../src/icons/charika.png"></div>
                        <div class="texte">
                            <p>Établissements</p>
                            <h1><?php echo htmlspecialchars($region['etablissement']); ?></h1>
                        </div>
                    </div>
                    <div class="classe">
                        <div class="image-icon"><img src="../src/icons/icon_chomage.png"></div>
                        <div class="texte">
                            <p>Taux d'emploi</p>
                            <h1><?php echo htmlspecialchars($region['emploi']); ?></h1>
                        </div>
                    </div>                      
                </div>
            </div>
        </div>
        <div class="card-ville-3">
            <h2>Localisation</h2>
            <iframe src="<?php echo htmlspecialchars($region['gpc']); ?>" width="260" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
    </div>
   
    <!--card email enquete ...-->
    <div class="cards-ville-info">
        <a href="<?php echo htmlspecialchars($region['enquete']); ?>"  target="_blank"><div class="card-v">
            <div class="image-icon"><img src="../src/icons/document-blackred.png"></div>
            <p>Enquêtes en cours</p>
        </div></a>
        <a href="<?php echo htmlspecialchars($region['publication']); ?>"  target="_blank"><div class="card-v">
            <div class="image-icon"><img src="../src/icons/publication-icon.png"></div>
            <p>Publications</p>
        </div></a>
        <a href="<?php echo htmlspecialchars($region['donne']); ?>"  target="_blank"><div class="card-v">
            <div class="image-icon"><img src="../src/icons/pourcentage.png"></div>
            <p>Données régionales</p>
        </div></a>
        <a href="<?php echo htmlspecialchars($region['rapport']); ?>"  target="_blank"><div class="card-v">
            <div class="image-icon"><img src="../src/icons/icon_rapport.png""></div>
            <p>Rapports </p>
        </div></a>
        <a href="<?php echo htmlspecialchars($region['contact']); ?>"  target="_blank"><div class="card-v">
            <div class="image-icon"><img src="../src/icons/email.png""></div>
            <p>Contact</p>
        </div></a>
    </div>



    <div class="bar-bas">
        <div class="reseau">
            <p>Rejoignez-nous sur :</p>
            <nav class="logo-media">
                <a href="https://www.youtube.com/user/marochcp"><img src="../src/icons/youtube-icon1.png"></a>
                <a href="https://web.facebook.com/HCPMaroc/?_rdc=1&_rdr#"><img src="../src/icons/facebook-icon1.png"></a>
                <a href="https://www.instagram.com/hcp.maroc/"><img src="../src/icons/instagram-icon1.png"></a>
                <a href="http://twitter.com/@hcpmaroc"><img src="../src/icons/twitter-icon1.png"></a>
                <a href="https://www.linkedin.com/company/hcp-maroc"><img src="../src/icons/linkedin-icon1.png"></a>
            </nav>
        </div>
        <div class="logo-bar-bas"><img src="../src/img/logo-bar-bas1.png"></div>
    </div>
    <div class="copy-right">
        <p>Haut-Commissariat au Plan du Maroc © 2026<br>
        Centre National de Documentation<br>
        En poursuivant votre navigation, vous acceptez l'utilisation de cookies, afin de réaliser des statistiques d'audience.</p>
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