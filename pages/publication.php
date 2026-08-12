<?php
include "dbconnect.php";

$current = basename($_SERVER['PHP_SELF']);

$sql = $pdo->query("SELECT id,ID_pub,Images,Titre_pub,Categorie,Statut,date_pub,description,link_pub,nbre_tel FROM publication ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);
$totalpub = $pdo->query("Select count(*) from publication")->fetchColumn();
$totalrapp = $pdo->query("Select count(*) from publication where Categorie='Rapports et études'")->fetchColumn();
$totalnot = $pdo->query("Select count(*) from publication where Categorie='Notes et analyses'")->fetchColumn();
$totalautre = $pdo->query("Select count(*) from publication where Categorie='Autres documents'")->fetchColumn();
$totalbull = $pdo->query("Select count(*) from publication where Categorie='Bulletins et revues'")->fetchColumn();
$totalpublie = $pdo->query("Select count(*) from publication where Statut='Publié'")->fetchColumn();
$totalbr = $pdo->query("Select count(*) from publication where Statut='Brouillons'")->fetchColumn();

?>

<?php
$sql_mois = $pdo->query("
    SELECT MONTH(date_pub) AS mois, COUNT(*) AS total
    FROM publication
    WHERE YEAR(date_pub) = YEAR(CURDATE())
    GROUP BY MONTH(date_pub)
    ORDER BY MONTH(date_pub)
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
    <link rel="stylesheet" href="publication.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>


<!--supprimer affiche-->
<div id="deletepub" class="modal" >
    <div class="modal-content">

        <div class="modal-icon"><img src="../src/icons/delete-icon.png"></div>

        <h2>Supprimer la publication</h2>

        <p>
            Êtes-vous sûr de vouloir supprimer cet enquete ?
            <br>
            Cette action est irréversible.
        </p>

        <div class="modal-buttons">
            <button class="btn-cancel" onclick="closeModal()">
                Annuler
            </button>

            <button class="btn-delete" onclick="deleteUser()">
                Supprimer
            </button>
        </div>

    </div>
</div>

<!--modifier affiche-->
<div id="edit_publication" class="modal">
    <div class="modal-content modal-edit">

        <h2>Modifier la publication</h2>

        <form action="utilisateurs_actions/publication/modifier_pub.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" id="id" name="id">

            <div class="form-group">
                <label>ID</label>
                <input type="text" id="ID_pub" name="ID_pub" required>
            </div>

            <div class="form-group">
                <label>Image de la publication</label>
                <img id="preview_image" src="" alt="" style="max-width:120px; display:none; margin-bottom:8px; border-radius:6px;">
                <input type="file" id="Image_pub" name="Image_pub" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="form-group">
                <label>Titre de la publication</label>
                <input type="text" id="Titre_pub" name="Titre_pub">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea id="Description" name="Description"></textarea>
            </div>

            <div class="form-group">
                <label>Categorie</label>
                <select id="Categorie" name="Categorie">
                    <option value="Notes et analyses">Notes et analyses</option>
                    <option value="Rapports et études">Rapports et études</option>
                    <option value="Bulletins et revues">Bulletins et revues</option>
                    <option value="Autres documents">Autres documents</option>
                </select>
            </div>

            <div class="form-group">
                <label>Statut</label>
                <select id="Statut" name="Statut">
                    <option value="Publié">Publié</option>
                    <option value="Brouillons">Brouillons</option>
                </select>
            </div>

            <div class="form-group">
                <label>date de publication</label>
                <input type="date" id="date_pub" name="date_pub">
            </div>

            <div class="form-group">
                <label>Fichier / Document (PDF, etc.)</label>
                <span id="current_file_name"></span>
                <input type="file" id="link_pub" name="link_pub">
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


<!--ajouter affiche-->
<div id="ajouter_publication" class="modal">
    <div class="modal-content modal-edit">

        <h2>Ajouter la publication</h2>

        <form action="utilisateurs_actions/publication/ajouter_pub.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" id="id" name="id">

            <div class="form-group">
                <label>ID</label>
                <input type="text" id="ID_pub" name="ID_pub" required>
            </div>

            <div class="form-group">
                <label>Image de la publication</label>
                <img id="preview_image" src="" alt="" style="max-width:120px; display:none; margin-bottom:8px; border-radius:6px;">
                <input type="file" id="Image_pub" name="Image_pub" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="form-group">
                <label>Titre de la publication</label>
                <input type="text" id="Titre_pub" name="Titre_pub">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea id="Description" name="Description"></textarea>
            </div>

            <div class="form-group">
                <label>Categorie</label>
                <select id="Categorie" name="Categorie">
                    <option value="Notes et analyses">Notes et analyses</option>
                    <option value="Rapports et études">Rapports et études</option>
                    <option value="Bulletins et revues">Bulletins et revues</option>
                    <option value="Autres documents">Autres documents</option>
                </select>
            </div>

            <div class="form-group">
                <label>Statut</label>
                <select id="Statut" name="Statut">
                    <option value="Publié">Publié</option>
                    <option value="Brouillons">Brouillons</option>
                </select>
            </div>

            <div class="form-group">
                <label>date de publication</label>
                <input type="date" id="date_pub" name="date_pub">
            </div>

            <div class="form-group">
                <label>Fichier / Document (PDF, etc.)</label>
                <span id="current_file_name"></span>
                <input type="file" id="link_pub" name="link_pub">
            </div>
            

            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeAddModal()">
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
<script>
    //publication par statut
    document.addEventListener("DOMContentLoaded", function () {

        const ctx = document.getElementById("statusChart");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["Rapports et études", "Notes et analyses", "Bulletins et revues","Autres documents"],
                datasets: [{
                    data: [
                        <?= $totalrapp ?>,
                        <?= $totalnot ?>,
                        <?= $totalbull ?>,
                        <?= $totalautre ?>
                    ],
                    backgroundColor: [
                        "#329549",
                        "#2975c5",
                        "#e88322",
                        "#2596be"

                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: "65%"
            }
        });


});
</script>
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
            <a href="#" onclick="changeActive(this)"><img src="../src/icons/icon-media.png" data-default="../src/icons/icon-media.png" data-active="../src/icons/icon-media-active.png">Contenu du site</a>
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
                <h1>Publications</h1>
                <p>Gérez les publications et documents officiels du HCP</p>
            </div>
            <div class="buttons">
                <button class="btn-add" onclick="openAddModal()">Créer une enquête</button>
                <button class="btn-exp" onclick="window.location.href='utilisateurs_actions/publication/exporter_publication.php'">Exporter</button>
            </div>
        </div>
        <div class="cards-cara">
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/publication-icon-dash.png"></div>
                <div class="paragraphe">
                   <h2><?= $totalpub ?></h2>
                    <p class="card-det"><b>Publications totales</b><br><span>Toutes catégories</span></p> 
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/rapport-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalrapp ?></h2>
                    <p class="card-det"><b>Rapports et études</b><br><span><?= ($totalrapp/$totalpub)*100 ?>% du total</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/analyse-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalnot ?></h2>
                    <p class="card-det"><b>Notes et analyses</b><br><span><?= ($totalnot/$totalpub)*100 ?>% du total</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/revu-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalautre ?></h2>
                    <p class="card-det"><b>Bulletins et revues</b><br><span><?= ($totalautre/$totalpub)*100 ?>% du total</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/bruillet-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalbull ?></h2>
                    <p class="card-det"><b>Autres documents</b><br><span><?= ($totalbull/$totalpub)*100 ?>% du total</span></p>
                </div>
                
            </div>
        </div>
        
        <div class="table-background">
            <!-- barre de recherche -->
            <div class="tab-search">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Rechercher une publication..." onkeyup="filterUsers()">
                </div>
                <div class="search-act-blo">
                    <select id="filterStatus"  onchange="filterUsers()">
                        <option value="">Tous les statuts</option>
                        <option value="Publié">Publié</option>
                        <option value="Brouillons">Brouillons</option>
                    </select>
                </div>
                <div class="search-calendrier">
                    <input type="date" id="searchcalendrier" onchange="filterUsers()">
                </div>
                <div class="search-act-cat">
                    <select id="filterCategorie"  onchange="filterUsers()">
                        <option value="">Tous les categorie</option>
                        <option value="Rapports et études">Rapports et études</option>
                        <option value="Notes et analyses">Notes et analyses</option>
                        <option value="Bulletins et revues">Bulletins et revues</option>
                        <option value="Autres documents">Autres documents</option>
                    </select>
                </div>
            </div>
            
            <!--tableaux-->
            <div class="table-container">
                <table class="table-login">
                    <thead>
                        <tr>
                            <th>ID publication</th>
                            <th>Image</th>
                            <th>Titre de la publication</th>
                            <th>Description</th>
                            <th>Categorie</th>
                            <th>Statut</th>
                            <th>date de publication</th>
                            <th>Link</th>
                            <th>Telechargement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        <?php if(count($users)>0): ?>
                        <?php foreach($users as $user): ?>    
                                <tr>
                                    <td style="max-width:100px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['ID_pub']) ?></td>
                                    <td class="td-image">
                                        <?php if(!empty($user['Images'])): ?>
                                            <img src="data:image/png;base64,<?= base64_encode($user['Images']) ?>" 
                                                alt="Image publication">
                                        <?php else: ?>
                                        <span>—</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($user['Titre_pub']) ?></td>
                                    <td style="max-width:200px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($user['description']) ?></td>
                                    <td>
                                        <?php if($user['Categorie']=="Rapports et études"): ?>
                                            <span class="status-termine">Rapports et études</span>
                                        <?php elseif($user['Categorie']=="Notes et analyses"): ?>
                                            <span class="status-en-cours">Notes et analyses</span>
                                        <?php elseif($user['Categorie']=="Bulletins et revues"): ?>
                                            <span class="status-bull">Bulletins et revues</span>
                                        <?php elseif($user['Categorie']=="Autres documents"): ?>
                                            <span class="status-autre">Autres documents</span>
                                        <?php else:?>
                                            <span class="status-br">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($user['Statut']=="Publié"): ?>
                                            <span class="status-termine">Publié</span>
                                        <?php elseif($user['Statut']=="Brouillons"): ?>
                                            <span class="status-br">Brouillons</span>
                                        <?php else:?>
                                            <span class="status-br">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($user['date_pub']) ?></td>
                                    <td style="max-width:100px;overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" class="link-cell">
                                        <a href="../<?= $user['link_pub'] ?>" download="<?= $user['link_pub'] ?>" class="btn-download" onclick="">
                                            <img src="../src/icons/download-icon.png" alt="Telecharger">
                                        </a>
                                    </td>
                                    <td><?= htmlspecialchars($user['nbre_tel']) ?></td>
                                    <td class="actions-cell">
                                        <a href="#" class="btn-modifier" title="Modifier" onclick="openEditModal('<?= $user['id'] ?>','<?= htmlspecialchars($user['ID_pub'], ENT_QUOTES) ?>','<?= htmlspecialchars($user['Titre_pub'], ENT_QUOTES) ?>','<?= !empty($user['Images']) ? "data:image/png;base64,".base64_encode($user['Images']) : "" ?>','<?= htmlspecialchars($user['Categorie'], ENT_QUOTES) ?>','<?= htmlspecialchars($user['Statut'], ENT_QUOTES) ?>','<?= htmlspecialchars($user['date_pub'], ENT_QUOTES) ?>','<?= htmlspecialchars(str_replace(["\r\n","\n","\r"], ' ', $user['description']), ENT_QUOTES) ?>','<?= htmlspecialchars($user['link_pub'], ENT_QUOTES) ?>'); return false;">
                                            <img src="../src/icons/edit-icon.png" alt="Modifier">
                                        </a>
                                        <a href="utilisateurs_actions/publication/supprimer_pub.php" class="btn-supprimer" title="Supprimer" onclick="openDeleteModal(<?= $user['id'] ?>); return false;">
                                            <img src="../src/icons/delete-icon.png" alt="Supprimer">
                                        </a>
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
                <h1 class="card-title">Publications par statut</h1>
                <div class="statusChart">
                   <canvas  id="statusChart"></canvas> 
                </div>
                
            </div>
            <div class="card-st">
                <h1 class="card-title">Publication globale</h1>
                <div class="progression-container">
                    <canvas id="progressChart"></canvas>
                    <div class="progression-center">
                        <span class="progression-value" id="progressValue"></span>
                        <span class="progression-label">Publication moyenne</span>
                        <span class="progression-subtitle">Publie</span>
                    </div>
                </div>
            </div>
            <div class="card-st">
                <h1 class="card-title">Réponses collectées</h1>
                <div class="monthlyChart">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
            <div class="card-st">
                <h1 class="card-title">Activités récentes</h1>
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
    //supprimer publication 
    let deleteId = null;

    function openDeleteModal(id){
        deleteId = id;
        document.getElementById("deletepub").style.display="flex";
    }

    function closeModal(){
        document.getElementById("deletepub").style.display="none";
        deleteId = null;
    }

    function deleteUser(){
        if(deleteId!=null){
            window.location.href =
            "utilisateurs_actions/publication/supprimer_pub.php?id="+deleteId;
        }
    }

    //modifier affiche 
    function openEditModal(id,ID_pub,Titre_pub,Image_pub,Categorie,Statut,date_pub,description,link_pub){
        document.getElementById("id").value = id;
        document.getElementById("ID_pub").value = ID_pub;
        document.getElementById("Titre_pub").value = Titre_pub;
        document.getElementById("Categorie").value = Categorie;
        document.getElementById("Statut").value = Statut;
        document.getElementById("date_pub").value = date_pub;
        document.getElementById("Description").value = description;

        const preview = document.getElementById('preview_image');
        if(Image_pub){
            preview.src = Image_pub;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }

        document.getElementById('current_file_name').textContent =
            link_pub ? "Fichier actuel : " + link_pub : "Aucun fichier";

        document.getElementById('Image_pub').value = "";
        document.getElementById('link_pub').value = "";

        document.getElementById("edit_publication").style.display = "flex";
    }

    function closeEditModal(){
        document.getElementById("edit_publication").style.display="none";
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

    //ajouter publication 
    //ajout affiche 
    function openAddModal() {
        document.getElementById("ID_pub").value = "";
        document.getElementById("Titre_pub").value ="";
        document.getElementById("Categorie").value = "";
        document.getElementById("Statut").value = "";
        document.getElementById("date_pub").value = "";
        document.getElementById("Description").value = "";

        const preview = document.getElementById('preview_image');
        preview.style.display = 'none';
        preview.src = "";


        document.getElementById('Image_pub').value = "";
        document.getElementById('link_pub').value = "";

        document.getElementById("ajouter_publication").style.display = "flex";
    }

    function closeAddModal() {
        //document.getElementById("ajouter_error_msg").style.display = "none";
        document.getElementById("ajouter_publication").style.display = "none";
    }

    //search by filterCategorie
    function filterUsers() {
        const input = document.getElementById("searchInput").value.toLowerCase().trim();
        const statusFilter = document.getElementById("filterStatus").value;
        const rows = document.querySelectorAll("#usersTableBody tr");
        const calendrier = document.getElementById("searchcalendrier").value;
        const categorie = document.getElementById("filterCategorie").value;

        rows.forEach(row => {
            const ID = row.children[0]?.textContent.toLowerCase() || "";
            const Titre = row.children[2]?.textContent.toLowerCase() || "";
            const Description = row.children[3]?.textContent.toLowerCase() || "";
            const Categorie = row.children[4]?.textContent.trim() || "";
            const Statut = row.children[5]?.textContent.trim() || "";
            const Calendrier = row.children[6]?.textContent.trim() || "";

            const matchesText = ID.includes(input) || Titre.includes(input) || Description.includes(input);
            const matchesStatus = !statusFilter || Statut === statusFilter;
            const matchescalendrier = !calendrier || Calendrier===calendrier;
            const matchescategorie = !categorie || Categorie===categorie;

            if (matchesText && matchesStatus && matchescalendrier && matchescategorie) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
    });
    }
</script>

<script>
//progression card
document.addEventListener("DOMContentLoaded", function () {

    const progress = <?= $totalpublie > 0 ? round(($totalpublie / $totalpub) * 100) : 0 ?>;

    document.getElementById("progressValue").textContent = progress + "%";

    const ctx = document.getElementById("progressChart");

    new Chart(ctx, {
        type: "doughnut",
        data: {
            datasets: [{
                data: [progress, 100 - progress],
                backgroundColor: [
                    "#6B123C",
                    "#EDEAF3"
                ],
                borderWidth: 0
            }]
        },
        options: {
        responsive: false,

        rotation: -90,
        circumference: 360,

        cutout: "70%",

        plugins: {
            legend: {
                display: false
            },

            tooltip: {
                enabled: false
            }
        }
    }
    });

});
</script>

<script>
//mois 
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
                label: "publications",
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