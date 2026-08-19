<?php
session_start();
include "dbconnect.php";

$current = basename($_SERVER['PHP_SELF']);


//hcp_description 
$sql = $pdo->query("SELECT id,site,email,telephone,logo_site,logo_home from setting ORDER BY id DESC");
$hcp_des = $sql->fetchAll(PDO::FETCH_ASSOC);
$site = $pdo->query("Select site from setting where id=0")->fetchColumn();
$email = $pdo->query("Select email from setting where id=0")->fetchColumn();
$telephone = $pdo->query("Select telephone from setting where id=0")->fetchColumn();
$logo_site = $pdo->query("Select logo_site from setting where id=0")->fetchColumn();
$logo_home = $pdo->query("Select logo_home from setting where id=0")->fetchColumn();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="utilisateurs.css">
    <link rel="stylesheet" href="enquete.css">
    <link rel="stylesheet" href="contenu_site.css">
    <link rel="stylesheet" href="setting.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>







<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<body>
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <div class="bar-haut" id="sidebar">
        <div class="logo-hpc"><img src="../src/img/hcp_logo.png"></div>
        <nav>
            <a href="dashboard.php" class="<?php echo ($current == 'dashboard.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/home-icon.png" data-default="../src/icons/home-icon.png" data-active="../src/icons/home-icon-active.png">Accueil</a>
            <p>GESTION DE CONTENU</p>
            <a href="utilisateurs.php" class="<?php echo ($current == 'utilisateurs.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/people-admin.png" data-default="../src/icons/people-admin.png" data-active="../src/icons/people-admin-active.png">Utilisateurs</a>
            <a href="enquete.php" class="<?php echo ($current == 'enquete.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/document-blackred.png" data-default="../src/icons/document-blackred.png" data-active="../src/icons/document-blackred-active.png">Enquêtes</a>
            <a href="statiques.php" class="<?php echo ($current == 'statiques.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)"><img src="../src/icons/statique-admin.png" data-default="../src/icons/statique-admin.png" data-active="../src/icons/statique-admin-active.png">Statistiques</a>
            <a href="publication.php" class="<?php echo ($current == 'publication.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)"><img src="../src/icons/publication-admin.png" data-default="../src/icons/publication-admin.png" data-active="../src/icons/publication-admin-active.png">Publications</a>
            <a href="contenu_site.php" class="<?php echo ($current == 'contenu_site.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/icon-media.png" data-default="../src/icons/icon-media.png" data-active="../src/icons/icon-media-active.png">Contenu du site</a>
            <p>SYSTÈME</p>
            <a href="setting.php" class="<?php echo ($current == 'setting.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/icon-settings.png" data-default="../src/icons/icon-settings.png" data-active="../src/icons/icon-settings-active.png">Paramètres</a>
            <button class="btn-site" onclick="window.location.href='home.php'">Voir le site</button>
            <button class="btn-deconnextion" onclick="window.location.href='login.php'">Déconnexion</button>
        </nav>
    </div>

    <!--bar top -->
    <div class="bar-top" style="height:60px;">
        <nav>
            <a href="#" class="menu-a" id="bartop" onclick="toggleSidebar()"><img src="../src/icons/menu-icon.png"></a>
            <div class="account" style="margin-right:30px;">
               <a href="#" class="account-a" onclick="changeActive(this)"><img src="../src/icons/account-icon.png"></a> 
               <div class="account-title">
                    <h5>Admin</h5>
                    <span><?= htmlspecialchars($_SESSION["nom"] ?? '') ?></span>
               </div>
            </div>
            
        </nav>
    </div>
    
    <!--content-->
    <div class="content" id="content">
        <div class="title-page">
            <div class="description">
                <h1>Paramètres du site</h1>
                <p>Gérez les paramètres généraux et les préférences du site</p>
            </div>
        </div>

        


        <!--card statique-->
        <div class="card-statique">
            <div class="card-st">
                <div class="title">
                   <h1 class="card-title">Modifier la description du site</h1> 
                   <p>Cette description apparaît dans le pied de page et sur les moteurs de recherche.</p>
                </div>
                <form action="utilisateurs_actions/setting/modifier_setting.php" method="POST">
                    <input type="hidden" id="id" name="id">

                    <div class="form-group" style="margin-bottom:-5px;">
                        <label>Nom du site</label>
                        <input style="margin-left:0px;width:960px;" id="site" name="site" value="<?= htmlspecialchars($site) ?>" required>
                    </div>

                    <div class="form-group" style="margin-bottom:-5px;">
                        <label>Email de contact</label>
                        <input type="email" style="margin-left:0px;width:960px;" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                    </div>

                    <div class="form-group" style="margin-bottom:-5px;">
                        <label>Téléphone</label>
                        <input style="margin-left:0px;width:960px;" id="tel" name="tel" value="<?= htmlspecialchars($telephone) ?>" required>
                    </div>

                    <div class="modal-buttons">
                        <button type="submit" class="btn-enregistre">
                            Enregistrer la description
                        </button>
                    </div>
                </form>
                
            </div>



            <div class="settings-card">
    <div class="card-header"  style="font-size:25px;color:#5e1d3e;"><b>Logo et favicon</b></div>
 
    <!-- Logo du site -->
    <!-- Logo du site -->
    <div class="field-block">
        <label class="field-label">Logo du site</label>
        <div class="logo-row">
            <div class="logo-preview">
                <img src="../src/img/<?= htmlspecialchars($logo_site) ?>" alt="Logo du site">
            </div>
            <div class="logo-actions">
                <form action="utilisateurs_actions/setting/modifier_logo.php" method="POST" enctype="multipart/form-data">
                    <button type="button" class="btn-outline" onclick="document.getElementById('logo-input').click()">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        Changer le logo
                    </button>
                     <input type="file"name="logo" id="logo-input" accept=".png,.jpg,.jpeg,.svg" style="display:none" onchange="this.form.submit()">
                </form>
                <form action="utilisateurs_actions/setting/supprimer_logo.php" method="POST">
                    <button type="submit" class="btn-outline btn-danger">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        Supprimer
                    </button>
                </form>
            </div>
            
        </div>
    </div>
 
    <!-- Favicon -->
    <div class="field-block">
        <label class="field-label">Favicon</label>
        <div class="logo-row">
            <div class="logo-preview favicon-preview" style="width:150px;height:150px;">
                <img src="../src/img/<?= htmlspecialchars($logo_home) ?>" alt="Favicon">
            </div>
            <div class="logo-actions">
                <form action="utilisateurs_actions/setting/modifier_favicon.php" method="POST" enctype="multipart/form-data">
                    <button type="button" class="btn-outline" onclick="document.getElementById('favicon-input').click()">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                        Changer le favicon
                    </button>
                    <input type="file" name="favicon" id="favicon-input" accept=".png,.jpg,.jpeg,.svg" style="display:none" onchange="this.form.submit()">
                </form>    
                <form action="utilisateurs_actions/setting/supprimer_favicon.php" method="POST">
                    <button class="btn-outline btn-danger" onclick="supprimerFavicon()">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        Supprimer
                    </button>
                </form>
            </div>
            
        </div>
    </div>
 
    <div class="info-note" style="margin-top:50px;"><span>Formats acceptés : PNG, JPG, SVG, Taille recommandée du logo : 300x60px</span></div>
</div>




            
        </div>
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
        
    document.addEventListener('DOMContentLoaded', () => {
    const activeLink = document.querySelector('.bar-haut nav a.active');
    if (activeLink) {
        const img = activeLink.querySelector('img');
        if (img && img.dataset.active) {
            img.src = img.dataset.active;
        }
    }
    });   


    
</script>

<script>

</script>
</body>
</html>