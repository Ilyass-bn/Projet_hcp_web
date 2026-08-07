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
                <h1 class="title">1 279</h1>
                <p class="description">milliers MAD<br>PIB réel (2026)</p>
                <p class="details">Le PIB du Maroc en 2026</p>
            </div>
            
        </div>
        <div class="card-statique">
            <div class="image-icon"><img src="../src/icons/statique.png"></div>
            <div class="card-content">
                <h1 class="title">36,8</h1>
                <p class="description">millions<br>Population (2026)</p>
                <p class="details">La population du Royaume</p>
            </div>
        </div>
        <div class="card-pib">
            <div class="image-icon"><img src="../src/icons/pourcentage.png"></div>
            <div class="card-content">
                <h1 class="title">13,6 %</h1>
                <p class="description">du PIB<br>Dépenses publiques (2026)</p>
                <p class="details-pourcentage">Poids des dépenses publiques</p>
            </div>
        </div>
        <div class="card-inflation">
            <div class="reseau">
                <div class="image-icon"><img src="../src/icons/augmentation.png"></div>
                <div class="card-content">
                    <h1 class="title">6,1 %</h1>
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