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
            <a href="#" onclick="changeActive(this)">Enquêtes</a>
            <a href="#" onclick="changeActive(this)">Statistiques</a>
            <a href="contact.php" class="<?php echo ($current == 'contact.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Contactez-nous</a>
            <button onclick="window.location.href='login.php'">Login</button>
        </nav>
    </div>
    <div class="home-body">
        <div class="para1">
            <p class="title">Bienvenue au <span>Haut-Commissariat au Plan</span></p>
            <h1 class="description">Nous œuvrons à la collecte et à l'analyse des données statistiques afin de 
            soutenir la prise de décision et le développement durable au Royaume du Maroc.
            </h1>
            <div class="buttons">
                <button class="button-primary">Participer à<pre>un sondage</pre></button>
                <button class="button-secondary">Afficher <pre>les statistiques</pre></button>
            </div>
        </div>
        
        <div class="image-body"><img src="../src/img/home_img1.png"></div>
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