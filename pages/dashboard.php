<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <div class="bar-haut" id="sidebar">
        <div class="logo-hpc"><img src="../src/img/hcp_logo.png"></div>
        <nav>
            <a href="dashboard.php" class="<?php echo ($current == 'dashboard.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Accueil</a>
            <p>GESTION DE CONTENU</p>
            <a href="utilisateurs.php" class="<?php echo ($current == 'utilisateurs.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/people-admin.png" data-default="../src/icons/people-admin.png" data-active="../src/icons/people-admin-active.png">Utilisateurs</a>
            <a href="enquete.php" class="<?php echo ($current == 'enquete.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/document-blackred.png" data-default="../src/icons/document-blackred.png" data-active="../src/icons/document-blackred-active.png">Enquêtes</a>
            <a href="statiques.php" class="<?php echo ($current == 'statiques.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)"><img src="../src/icons/statique-admin.png" data-default="../src/icons/statique-admin.png" data-active="../src/icons/statique-admin-active.png">Statistiques</a>
            <a href="publication.php" class="<?php echo ($current == 'publication.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)"><img src="../src/icons/publication-admin.png" data-default="../src/icons/publication-admin.png" data-active="../src/icons/publication-admin-active.png">Publications</a>
            <a href="contenu_site.php" class="<?php echo ($current == 'contenu_site.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/icon-media.png" data-default="../src/icons/icon-media.png" data-active="../src/icons/icon-media-active.png">Contenu du site</a>
            <p>SYSTÈME</p>
            <a href="#" onclick="changeActive(this)"><img src="../src/icons/icon-settings.png" data-default="../src/icons/icon-settings.png" data-active="../src/icons/icon-settings-active.png">Paramètres</a>
            <a href="#" onclick="changeActive(this)">Support</a>
            <a href="contact.php" class="<?php echo ($current == 'contact.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Contactez-nous</a>
            <button class="btn-site" onclick="window.location.href='home.php'">Voir le site</button>
            <button class="btn-deconnextion" onclick="window.location.href='login.php'">Déconnexion</button>
        </nav>
    </div>

    <!--bar top -->
    <div class="bar-top">
        <nav>
            <a href="#" class="menu-a" id="bartop" onclick="toggleSidebar()"><img src="../src/icons/menu-icon.png"></a>
            <a href="#" class="not-a" onclick="changeActive(this)"><img src="../src/icons/notification-icon.png"></a>
            <a href="#" class="mail-a" onclick="changeActive(this)"><img src="../src/icons/email-icon.png"></a>
            <a href="#" class="account-a" onclick="changeActive(this)"><img src="../src/icons/account-icon.png"></a>
        </nav>
    </div>
    
    <!--content-->
    <div class="content" id="content">

    </div>

   
    <div class="bar-bottom">
        <p class="text-haut">Haut-Commissariat au Plan du Maroc © 2026</p>
        <p class="text-cara">Aide <span class="bar">|</span> Confidentialité <span class="bar">|</span> Conditions d'utilisation</p>
    </div>

    <!--javascript-->
    <script>
    function changeActive(element){
        const links = document.querySelectorAll('.bar-haut nav a');
        links.forEach(link => { link.classList.remove('active');
            const img = link.querySelector('img');
            if (img && img.dataset.default) {
                img.src = img.dataset.default; 
            }
         });
        element.classList.add('active');
        const activeImg = element.querySelector('img');
        if (activeImg && activeImg.dataset.active) {
            activeImg.src = activeImg.dataset.active; 
        }
    }
    function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('hidden');
    document.getElementById('content').classList.toggle('full');
    document.getElementById('bartop').classList.toggle('full');
}
</script>
</body>
</html>