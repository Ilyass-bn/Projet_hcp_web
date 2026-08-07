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
    <span class="breadcrumb">
        <a href="institutions.php">institutions</a><span class="separator">></span>
        <a href="decouvert.php">Découvrir</a>
    </span>    
    <div class="home-body-contact">

        <div class="para1">
            <p class="title">Le Haut-Commissariat <br>au Plan du Maroc à travers le Royaume</p>
            <h1 class="description">Le Haut-Commissariat au Plan dispose d'un 
                réseau de directions régionales et provinciales réparties dans l'ensemble du Royaume. Elles 
                assurent la collecte, l'analyse 
                et la diffusion des données statistiques au plus près des réalités territoriales.
            </h1>
        </div>
        <div class="image-body-contact"><img src="../src/img/maroc-map.png"></div>
    </div>

    <!--card-info-hcp-->
    <div class="cards-history">
        <div class="card-1">
            <div class="image-icon"><img src="../src/icons/gps.png"></div>
            <div class="card-content">
                <h1 class="title">12</h1>
                <p class="description"><span>Directions Régionales</span></p>
            </div>
        </div>
        <div class="card-2">
            <div class="image-icon"><img src="../src/icons/societe.png"></div>
            <div class="card-content">
                <h1 class="title">38</h1>
                <p class="description"><span>Bureaux Provinciaux</span></p>
            </div>
        </div>
        <div class="card-3">
            <div class="image-icon"><img src="../src/icons/augmentation.png"></div>
            <div class="card-content">
                <h1 class="title">100+</h1>
                <p class="description"><span class="donne">Données collectées</span></p>
            </div>
        </div>
        <div class="card-4">
            <div class="reseau">
                <div class="image-icon"><img src="../src/icons/document-blackred.png"></div>
                <div class="card-content">
                    <p class="description"><span>Des données pour un Maroc qui avance</span></p>
                </div>                
            </div>
        </div>
    </div>    

    <!--texte nos direction--> 
    <div class="text-nosdomain">
        <h1>Nos Directions Régionales</h1>
        <p>Un réseau de proximité pour des données fiables au service du développement territorial.</p>
    </div>

    <!--les hcp des villes-->
    <div class="card-domain">
        <div class="card-domain-1">
            <div class="image-card"><img src="../src/img/hcp-tetouan.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Tanger-Tétouan</h1>
                    <p>Tanger</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=tanger'">Découvrir</button>
        </div>
        <div class="card-domain-2">
            <div class="image-card"><img src="../src/img/hcp-alhoceima.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Al Hoceima</h1>
                    <p>Al Hoceima</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=alhoceima'">Découvrir</button>
        </div>
        <div class="card-domain-3">
            <div class="image-card"><img src="../src/img/hcp-rabat.png"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Rabat-Salé-Kénitra</h1>
                    <p>Rabat</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=rabat'">Découvrir</button>
        </div>
        <div class="card-domain-4">
            <div class="image-card"><img src="../src/img/hcp-meknes.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Fès-Meknès</h1>
                    <p>Fès</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=fes'">Découvrir</button>
        </div>
        <div class="card-domain-5">
            <div class="image-card"><img src="../src/img/hcp-casablanca.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Casablanca-Settat</h1>
                    <p>Casablanca</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=casablanca'">Découvrir</button>
        </div>
        <div class="card-domain-6">
            <div class="image-card"><img src="../src/img/hcp-marakech.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Marrakech-Safi</h1>
                    <p>Marrakech</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=marrakech'">Découvrir</button>
        </div>
        <div class="card-domain-7">
            <div class="image-card"><img src="../src/img/hcp-benni-mellal.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Béni Mellal-Khénifra</h1>
                    <p>Béni Mellal</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=beni-mellal'">Découvrir</button>
        </div>
        <div class="card-domain-8">
            <div class="image-card"><img src="../src/img/hcp-errachidia.png"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Drâa-Tafilalet</h1>
                    <p>Errachidia</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=draa'">Découvrir</button>
        </div>
        <div class="card-domain-9">
            <div class="image-card"><img src="../src/img/hcp-agadir.jpg"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Souss-Massa</h1>
                    <p>Agadir</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=souss'">Découvrir</button>
        </div>
        <div class="card-domain-10">
            <div class="image-card"><img src="../src/img/hcp-guelmim.png"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Guelmim-Oued Noun</h1>
                    <p>Guelmim</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=guelmim'">Découvrir</button>
        </div>
        <div class="card-domain-11">
            <div class="image-card"><img src="../src/img/hcp-laayoun.png"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Laâyoune-Sakia El Hamra</h1>
                    <p>Laâyoune</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=laayoune'">Découvrir</button>
        </div>
        <div class="card-domain-12">
            <div class="image-card"><img src="../src/img/hcp-dakhla.png"></div>
            <div class="description">
                <div class="image-icon"><img src="../src/icons/gps.png"></div>
                <div class="details">
                    <h1>HCP Dakhla-Oued Ed-Dahab</h1>
                    <p>Dakhla</p>
                </div>
            </div>
            <button onclick="window.location.href='ville.php?id=dakhla'">Découvrir</button>
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