<?php
include "dbconnect.php";

$current = basename($_SERVER['PHP_SELF']);

$sql = $pdo->query("SELECT id,ID_hcp,description_hcp,presentation_hcp,creation_hcp,Image_hcp,enquete_link,publication_link,donne_reg_link,rapp_hcp_link,contact_hcp_link,gps_link,site_link,Zone FROM gestion_hcp ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);
$totalenquete = $pdo->query("Select count(*) from enquete")->fetchColumn();

//hcp_description 
$sql = $pdo->query("SELECT id,description from hcp_des ORDER BY id DESC");
$hcp_des = $sql->fetchAll(PDO::FETCH_ASSOC);
$description_hcp = $pdo->query("Select description from hcp_des where id=0")->fetchColumn();
$title_hcp = $pdo->query("Select title from hcp_des where id=0")->fetchColumn();
//hcp link 
$sql = $pdo->query("SELECT id,facebook_link,x_link,linkedin_link,youtube_link,instagram_link from reseaux_link ORDER BY id DESC");
$facebook_link = $pdo->query("Select facebook_link from reseaux_link where id=0")->fetchColumn();
$x_link = $pdo->query("Select x_link from reseaux_link where id=0")->fetchColumn();
$linkedin_link = $pdo->query("Select linkedin_link from reseaux_link where id=0")->fetchColumn();
$youtube_link = $pdo->query("Select youtube_link from reseaux_link where id=0")->fetchColumn();
$instagram_link = $pdo->query("Select instagram_link from reseaux_link where id=0")->fetchColumn();

?>
<?php
$sql_mois = $pdo->query("
    SELECT MONTH(date_fin) AS mois, COUNT(*) AS total
    FROM enquete
    WHERE YEAR(date_debut) = YEAR(CURDATE())
    GROUP BY MONTH(date_fin)
    ORDER BY MONTH(date_fin)
");

$mois = array_fill(1, 12, 0);
while ($row = $sql_mois->fetch(PDO::FETCH_ASSOC)) {
    $mois[(int)$row['mois']] = (int)$row['total'];
}
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>



<!--modifier affiche-->
<div id="editModal_hcp" class="modal" style="padding-top:30px;">
    <div class="modal-content modal-edit">

        <h2>Modifier les informations HCP</h2>

        <form action="utilisateurs_actions/contenu/modifier_contenu.php" method="POST" enctype="multipart/form-data" style="height:846px;">

            <input type="hidden" id="id" name="id">

            <div class="form-group">
                <label>Description</label>
                <textarea id="description_hcp" name="description_hcp" required></textarea>
            </div>

            <div class="form-group">
                <label>Presentation Hcp</label>
                <textarea id="presentation_hcp" name="presentation_hcp" required>></textarea>
            </div>

             <div class="form-group">
                <label>Image hcp</label>
                <img id="preview_image" src="" alt="" style="max-width:120px; display:none; margin-bottom:8px; border-radius:6px;">
                <input type="file" id="Image_hcp" name="Image_hcp" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="form-group">
                <label>Zone</label>
                <input type="text" id="Zone" name="Zone" required>
            </div>
            
            <div class="form-group">
                <label>Date de creation</label>
                <input type="text" id="creation_hcp" name="creation_hcp" required>
            </div>

            <div class="form-group">
                <label>Enquete link</label>
                <input type="text" id="enquete_link" name="enquete_link">
            </div>

            <div class="form-group">
                <label>Publication link</label>
                <input type="text" id="publication_link" name="publication_link">
            </div>

            <div class="form-group">
                <label>Donne regional link</label>
                <input type="text" id="donne_reg_link" name="donne_reg_link">
            </div>

            <div class="form-group">
                <label>Rapport link</label>
                <input type="text" id="rapp_hcp_link" name="rapp_hcp_link">
            </div>

            <div class="form-group">
                <label>Contact link</label>
                <input type="text" id="contact_hcp_link" name="contact_hcp_link">
            </div>

            <div class="form-group">
                <label>GPS link</label>
                <textarea id="gps_link" name="gps_link" required>></textarea>
            </div>

            <div class="form-group">
                <label>Site link</label>
                <input type="text" id="site_link" name="site_link">
            </div>

            

            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">
                    Annuler
                </button>

                <button type="submit" class="btn-enregistre">
                    Enregistrer
                </button>
            </div>

        </form>

    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<body>
    <?php $current = basename($_SERVER['PHP_SELF']); ?>
    <div class="bar-haut" id="sidebar">
        <div class="logo-hpc"><img src="../src/img/hcp_logo.png"></div>
        <nav>
            <a href="home.php" class="<?php echo ($current == 'home.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Accueil</a>
            <p>GESTION DE CONTENU</p>
            <a href="utilisateurs.php" class="<?php echo ($current == 'utilisateurs.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/people-admin.png" data-default="../src/icons/people-admin.png" data-active="../src/icons/people-admin-active.png">Utilisateurs</a>
            <a href="enquete.php" class="<?php echo ($current == 'enquete.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/document-blackred.png" data-default="../src/icons/document-blackred.png" data-active="../src/icons/document-blackred-active.png">Enquêtes</a>
            <a href="statiques.php" class="<?php echo ($current == 'statiques.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)"><img src="../src/icons/statique-admin.png" data-default="../src/icons/statique-admin.png" data-active="../src/icons/statique-admin-active.png">Statistiques</a>
            <a href="publication.php" class="<?php echo ($current == 'publication.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)"><img src="../src/icons/publication-admin.png" data-default="../src/icons/publication-admin.png" data-active="../src/icons/publication-admin-active.png">Publications</a>
            <a href="#" onclick="changeActive(this)"><img src="../src/icons/icon-actualite.png" data-default="../src/icons/icon-actualite.png" data-active="../src/icons/icon-actualite-active.png">Actualités</a>
            <a href="contenu_site.php" class="<?php echo ($current == 'contenu_site.php') ? 'active' : ''; ?>" onclick="changeActive(this)"><img src="../src/icons/icon-media.png" data-default="../src/icons/icon-media.png" data-active="../src/icons/icon-media-active.png">Contenu du site</a>
            <p>SYSTÈME</p>
            <a href="#" onclick="changeActive(this)"><img src="../src/icons/icon-settings.png" data-default="../src/icons/icon-settings.png" data-active="../src/icons/icon-settings-active.png">Paramètres</a>
            <a href="#" onclick="changeActive(this)">Support</a>
            <a href="contact.php" class="<?php echo ($current == 'contact.php') ? 'active' : ''; ?>" onclick="changeActive(this)">Contactez-nous</a>
            <button class="btn-site" onclick="window.location.href='login.php'">Voir le site</button>
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
        <div class="title-page">
            <div class="description">
                <h1>Gestion du contenu</h1>
                <p>Gérez les descriptions et les links du site officiels du HCP</p>
            </div>
        </div>

        <div class="table-background" style="margin-top:30px;">
            <div class="title_table">
                <h1 style="color:#5e1d3e;font-size:23px;">Gestion des Directions Régionales du HCP</h1>
            </div>
            <!-- barre de recherche -->
            <div class="tab-search">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Rechercher une enquete..." onkeyup="filterUsers()">
                </div>
            </div>
            
            <!--tableaux-->
            <div class="table-container">
                <table class="table-login">
                    <thead>
                        <tr>
                            <th>ID Hcp</th>
                            <th>Image</th>
                            <th>Zone</th>
                            <th>Description</th>
                            <th>Presentation_hcp</th>
                            <th>Date de creation</th>
                            <th>Enquete link</th>
                            <th>Publication link</th>
                            <th>Donne regional link</th>
                            <th>Rapport link</th>
                            <th>Contact link</th>
                            <th>GPS link</th>
                            <th>Site link</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <?php if(count($users)>0): ?>
                        <?php foreach($users as $user): ?>    
                                <tr>
                                    <td><?= htmlspecialchars($user['ID_hcp']) ?></td>
                                    <td class="td-image">
                                        <?php if(!empty($user['Image_hcp'])): ?>
                                            <img src="data:image/png;base64,<?= base64_encode($user['Image_hcp']) ?>" 
                                                alt="Image_hcp">
                                        <?php else: ?>
                                        <span>—</span>
                                        <?php endif; ?>
                                    <td style="max-width:220px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['Zone']) ?></td>
                                    </td>
                                    <td style="max-width:380px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['description_hcp']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['presentation_hcp']) ?></td>
                                    <td><?= htmlspecialchars($user['creation_hcp']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['enquete_link']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['publication_link']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['donne_reg_link']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['rapp_hcp_link']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['contact_hcp_link']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['gps_link']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['site_link']) ?></td>
                                    <td class="actions-cell">
                                        <a href="#" class="btn-modifier" data-id="<?= htmlspecialchars($user['id']) ?>" data-zone="<?= htmlspecialchars($user['Zone']) ?>" data-description="<?= htmlspecialchars($user['description_hcp'] ?? '') ?>" data-presentation="<?= htmlspecialchars($user['presentation_hcp'] ?? '') ?>" data-creation="<?= htmlspecialchars($user['creation_hcp'] ?? '') ?>" data-enquete="<?= htmlspecialchars($user['enquete_link'] ?? '') ?>" data-publication="<?= htmlspecialchars($user['publication_link'] ?? '') ?>" data-donnereg="<?= htmlspecialchars($user['donne_reg_link'] ?? '') ?>" data-rapport="<?= htmlspecialchars($user['rapp_hcp_link'] ?? '') ?>" data-image="<?= !empty($user['Image_hcp']) ? 'data:image/png;base64,'.base64_encode($user['Image_hcp']) : '' ?>" data-contact="<?= htmlspecialchars($user['contact_hcp_link'] ?? '') ?>" data-site="<?= htmlspecialchars($user['site_link'] ?? '') ?>" data-gps="<?= htmlspecialchars($user['gps_link'] ?? '') ?>" onclick="openEditModalFromRow(this); return false;"><img src="../src/icons/edit-icon.png" alt="Modifier"></a>
                                    </td>
                                </tr>
                
                        <?php endforeach; ?>
                        <?php else: ?>
                    </tbody>
                    <?php endif; ?>
                </table>
            </div>   
        </div>         


        <!--card statique-->
        <div class="card-statique">
            <div class="card-st">
                <div class="title">
                   <h1 class="card-title">Modifier la description du site</h1> 
                   <p>Cette description apparaît dans le pied de page et sur les moteurs de recherche.</p>
                </div>
                <form action="utilisateurs_actions/contenu/modifier_description.php" method="POST">
                    <input type="hidden" id="id_hcp" name="id_hcp">

                    <div class="form-group" style="margin-bottom:-5px;">
                        <label>Title actuelle</label>
                        <input style="margin-left:0px;width:750px;" id="title" name="title" value="<?= htmlspecialchars($title_hcp) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Description actuelle</label>
                        <textarea id="description" name="description" required><?= $description_hcp ?></textarea>
                    </div>
                    <div class="modal-buttons">
                        <button type="submit" class="btn-enregistre">
                            Enregistrer la description
                        </button>
                    </div>
                </form>
                
            </div>
            <div class="card-st">
                <div class="title">
                   <h1 class="card-title">Liens des réseaux sociaux</h1> 
                   <p>Ajoutez ou modifiez les liens de vos réseaux sociaux officiels.</p>
                </div>
                <form action="utilisateurs_actions/contenu/modifier_link.php" method="POST">
                    <input type="hidden" id="id_hcp_link" name="id_hcp_link">
                    <div class="form-group" style="display:flex;flex-direction:row;">
                        <div class="image"><img src="../src/icons/facebook-icon.png"></div>
                        <label class="title_icon">Facebook</label>
                        <input id="facebook_link" name="facebook_link" value="<?= htmlspecialchars($facebook_link) ?>" required>
                    </div>

                    <div class="form-group" style="display:flex;flex-direction:row;">
                        <div class="image"><img src="../src/icons/twitter-icon.png"></div>
                        <label style="margin-right:85px;" class="title_icon">X</label>
                        <input id="x_link" name="x_link" required value="<?= htmlspecialchars($x_link) ?>">
                    </div>

                    <div class="form-group" style="display:flex;flex-direction:row;">
                        <div class="image"><img src="../src/icons/linkedin-icon.png"></div>
                        <label style="margin-right:30px;" class="title_icon">Linkedin</label>
                        <input id="linkedin_link" name="linkedin_link" required value="<?= htmlspecialchars($linkedin_link) ?>">
                    </div>

                    <div class="form-group" style="display:flex;flex-direction:row;">
                        <div class="image"><img src="../src/icons/youtube-icon.png"></div>
                        <label style="margin-right:33px;" class="title_icon">Youtube</label>
                        <input id="youtube_link" name="youtube_link" required value="<?= htmlspecialchars($youtube_link) ?>">
                    </div>

                    <div class="form-group" style="display:flex;flex-direction:row;">
                        <div class="image"><img src="../src/icons/instagram-icon.png"></div>
                        <label class="title_icon">Instagram</label>
                        <input id="instagram_link" name="instagram_link" required value="<?= htmlspecialchars($instagram_link) ?>">
                    </div>

                    <div class="modal-buttons">
                        <button type="submit" class="btn-enregistre">
                            Enregistrer la description
                        </button>
                    </div>
                </form>
                
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



    //modifier affiche 
    function openEditModalFromRow(link){
    openEditModal(
        link.dataset.id,
        link.dataset.zone,
        link.dataset.description,
        link.dataset.presentation,
        link.dataset.creation,
        link.dataset.enquete,
        link.dataset.publication,
        link.dataset.donnereg,
        link.dataset.rapport,
        link.dataset.image,
        link.dataset.contact,
        link.dataset.site,
        link.dataset.gps
    );
}
    function openEditModal(id,Zone,description_hcp,presentation_hcp,creation_hcp,enquete_link,publication_link,donne_reg_link,rapp_hcp_link,imageSrc,contact_hcp_link,site_link,gps_link){
        document.getElementById("id").value = id;
        document.getElementById("description_hcp").value = description_hcp;
        document.getElementById("Zone").value = Zone;
        document.getElementById("presentation_hcp").value = presentation_hcp;
        document.getElementById("creation_hcp").value = creation_hcp;
        document.getElementById("enquete_link").value = enquete_link;
        document.getElementById("publication_link").value = publication_link;
        document.getElementById("donne_reg_link").value = donne_reg_link;
        document.getElementById("rapp_hcp_link").value = rapp_hcp_link;
        document.getElementById("contact_hcp_link").value = contact_hcp_link;
        document.getElementById("gps_link").value = gps_link;
        document.getElementById("site_link").value = site_link;

        const preview = document.getElementById('preview_image');
        if(imageSrc){
            preview.src = imageSrc;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }


        document.getElementById('Image_hcp').value = "";

        document.getElementById("editModal_hcp").style.display = "flex";
    }

    function closeEditModal(){
        document.getElementById("editModal_hcp").style.display="none";
    }
    
    function previewImage(event){
        const file = event.target.files[0];
        const preview = document.getElementById('preview_image');
        if(file){
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    }


    function filterUsers() {
        const input = document.getElementById("searchInput").value.toLowerCase().trim();
        const rows = document.querySelectorAll("#usersTableBody tr");

        rows.forEach(row => {
            const ID_hcp = row.children[0]?.textContent.toLowerCase() || "";
            const Zone = row.children[2]?.textContent.toLowerCase() || "";
            const description_hcp = row.children[3]?.textContent.toLowerCase() || "";
            const presentation_hcp = row.children[4]?.textContent.toLowerCase() || "";
            const creation_hcp = row.children[5]?.textContent.trim() || "";
            const enquete_link = row.children[6]?.textContent.trim() || "";
            const publication_link = row.children[7]?.textContent.trim() || "";
            const donne_reg_link = row.children[8]?.textContent.trim() || "";
            const rapp_hcp_link = row.children[9]?.textContent.trim() || "";
            const contact_hcp_link = row.children[10]?.textContent.trim() || "";
            const gps_link = row.children[11]?.textContent.trim() || "";
            const site_link = row.children[12]?.textContent.trim() || "";

            const matchesText = ID_hcp.includes(input) || description_hcp.includes(input) || presentation_hcp.includes(input) || creation_hcp.includes(input) || enquete_link.includes(input) || creation_hcp.includes(input) || publication_link.includes(input) || donne_reg_link.includes(input) || rapp_hcp_link.includes(input) || contact_hcp_link.includes(input) || gps_link.includes(input) || site_link.includes(input) || Zone.includes(input);

            if (matchesText){
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
    });
    }
    
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctxMonthly = document.getElementById("monthlyChart");
    const monthlyData = <?= json_encode(array_values($mois)) ?>;
    const monthLabels = ["Jan","Fév","Mar","Avr","Mai","Juin","Juil","Août","Sep","Oct","Nov","Déc"];

    const gradient = ctxMonthly.getContext("2d").createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, "rgba(107, 18, 60, 0.35)");
    gradient.addColorStop(1, "rgba(107, 18, 60, 0)");

    new Chart(ctxMonthly, {
        type: "line",
        data: {
            labels: monthLabels,
            datasets: [{
                label: "Enquêtes",
                data: monthlyData,
                borderColor: "#6B123C",
                backgroundColor: gradient,
                pointBackgroundColor: "#fff",
                pointBorderColor: "#6B123C",
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
                borderWidth: 2,
                fill: true,
                tension: 0.35
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "#6B123C",
                    padding: 10,
                    displayColors: false
                }
            },
            scales: {
                y: { beginAtZero: true, grid: { color: "#f0f0f0" } },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
</body>
</html>