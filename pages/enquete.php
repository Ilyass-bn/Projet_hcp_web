<?php
include "dbconnect.php";

$current = basename($_SERVER['PHP_SELF']);

$sql = $pdo->query("SELECT id,ID_enquete,Image_enquete,Titre,Type,Direction,date_debut,date_fin,link,Statut FROM enquete ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);
$totalenquete = $pdo->query("Select count(*) from enquete")->fetchColumn();
$total_en_cours = $pdo->query("Select count(*) from enquete where Statut='En cours'")->fetchColumn();
$total_Terminee = $pdo->query("Select count(*) from enquete where Statut='Terminée'")->fetchColumn();
$total_Brouillons = $pdo->query("Select count(*) from enquete where Statut='Brouillons'")->fetchColumn();

if ($totalenquete > 0) {
    $progression = round(($total_Terminee / $totalenquete) * 100);
} else {
    $progression = 0;
}
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<!--supprimer affiche-->
<div id="deleteenquete" class="modal" >
    <div class="modal-content">

        <div class="modal-icon"><img src="../src/icons/delete-icon.png"></div>

        <h2>Supprimer l'enquête</h2>

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
<div id="editModal" class="modal">
    <div class="modal-content modal-edit">

        <h2>Modifier l'enquêter</h2>

        <form action="utilisateurs_actions/modifier_enquete.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" id="id" name="id">

            <div class="form-group">
                <label>ID</label>
                <input type="text" id="ID_enquete" name="ID_enquete" required>
            </div>

            <div class="form-group">
                <label>Image de l'enquête</label>
                <img id="preview_image" src="" alt="" style="max-width:120px; display:none; margin-bottom:8px; border-radius:6px;">
                <input type="file" id="Image_enquete" name="Image_enquete" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="form-group">
                <label>Titre de l'enquête</label>
                <input type="text" id="Titre" name="Titre">
            </div>

            <div class="form-group">
                <label>Type</label>
                <input type="text" id="Type" name="Type">
            </div>

            <div class="form-group">
                <label>Direction/Region</label>
                <input type="text" id="Direction" name="Direction">
            </div>

            <div class="form-group">
                <label>Statut</label>

                <select id="Statut" name="Statut">
                    <option value="En cours">En cours</option>
                    <option value="Terminée">Terminée</option>
                    <option value="Brouillons">Brouillons</option>
                </select>

            </div>

            <div class="form-group">
                <label>date debut</label>
                <input type="date" id="date_debut" name="date_debut">
            </div>

            <div class="form-group">
                <label>date fin</label>
                <input type="date" id="date_fin" name="date_fin">
            </div>

            <div class="form-group">
                <label>Fichier / Document (PDF, etc.)</label>
                <span id="current_file_name"></span>
                <input type="file" id="link_file" name="link_file">
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

<!--Ajouter affiche--> 
<div id="ajout-Modal" class="modal">
    <div class="modal-content modal-edit">

        <h2>Modifier l'enquêter</h2>

        <form action="utilisateurs_actions/ajouter_enquete.php" method="POST" enctype="multipart/form-data">

            <input type="hidden" id="id" name="id">

            <div class="form-group">
                <label>ID</label>
                <input type="text" id="ID_enquete_aj" name="ID_enquete_aj" required>
            </div>

            <div class="form-group">
                <label>Image de l'enquête</label>
                <img id="preview_image_aj" src="" alt="" style="max-width:120px; display:none; margin-bottom:8px; border-radius:6px;">
                <input type="file" id="Image_enquete_aj" name="Image_enquete_aj" accept="image/*" onchange="previewImage(event)">
            </div>

            <div class="form-group">
                <label>Titre de l'enquête</label>
                <input type="text" id="Titre_aj" name="Titre_aj">
            </div>

            <div class="form-group">
                <label>Type</label>
                <input type="text" id="Type_aj" name="Type_aj">
            </div>

            <div class="form-group">
                <label>Direction/Region</label>
                <input type="text" id="Direction_aj" name="Direction_aj">
            </div>

            <div class="form-group">
                <label>Statut</label>

                <select id="Statut_aj" name="Statut_aj">
                    <option value="En cours">En cours</option>
                    <option value="Terminée">Terminée</option>
                    <option value="Brouillons">Brouillons</option>
                </select>

            </div>

            <div class="form-group">
                <label>date debut</label>
                <input type="date" id="date_debut_aj" name="date_debut_aj">
            </div>

            <div class="form-group">
                <label>date fin</label>
                <input type="date" id="date_fin_aj" name="date_fin_aj">
            </div>

            <div class="form-group">
                <label>Fichier / Document (PDF, etc.)</label>
                <span id="current_file_name"></span>
                <input type="file" id="link_file_aj" name="link_file_aj">
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
    document.addEventListener("DOMContentLoaded", function () {

        const ctx = document.getElementById("statusChart");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["En cours", "Terminée", "Brouillons"],
                datasets: [{
                    data: [
                        <?= $total_en_cours ?>,
                        <?= $total_Terminee ?>,
                        <?= $total_Brouillons ?>
                    ],
                    backgroundColor: [
                        "#3B82F6",
                        "#22C55E",
                        "#EC4899"
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
            <a href="#" onclick="changeActive(this)"><img src="../src/icons/statique-admin.png" data-default="../src/icons/statique-admin.png" data-active="../src/icons/statique-admin-active.png">Statistiques</a>
            <a href="publication.php" class="<?php echo ($current == 'publication.php') ? 'active' : ''; ?>" onclick="changeActive(this)" onclick="changeActive(this)"><img src="../src/icons/publication-admin.png" data-default="../src/icons/publication-admin.png" data-active="../src/icons/publication-admin-active.png">Publications</a>
            <a href="#" onclick="changeActive(this)"><img src="../src/icons/icon-actualite.png" data-default="../src/icons/icon-actualite.png" data-active="../src/icons/icon-actualite-active.png">Actualités</a>
            <a href="#" onclick="changeActive(this)"><img src="../src/icons/icon-media.png" data-default="../src/icons/icon-media.png" data-active="../src/icons/icon-media-active.png">Médias</a>
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
                <h1>Enquêtes</h1>
                <p>Gérez les enquêtes et le processus de collecte des données</p>
            </div>
            <div class="buttons">
                <button class="btn-add" onclick="openAddModal()">Créer une enquête</button>
                <button class="btn-exp" onclick="window.location.href='utilisateurs_actions/exporter_enquete.php'">Exporter</button>
            </div>
        </div>
        <div class="cards-cara">
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/clipboard-icon.png"></div>
                <div class="paragraphe">
                   <h2><?= $totalenquete ?></h2>
                    <p class="card-det"><b>Enquêtes totales</b><br><span>Toutes enquêtes</span></p> 
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/doc-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $total_en_cours ?></h2>
                    <p class="card-det"><b>En cours</b><br><span> du total</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/chart-icon-improved.png"></div>
                <div class="paragraphe">
                    <h2><?= $total_Terminee ?></h2>
                    <p class="card-det"><b>Terminées</b><br><span> du total</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/bruillet-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $total_Brouillons ?></h2>
                    <p class="card-det"><b>Brouillons</b><br><span>du total</span></p>
                </div>
                
            </div>
        </div>

        <div class="table-background">
            <!-- barre de recherche -->
            <div class="tab-search">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Rechercher une enquete..." onkeyup="filterUsers()">
                </div>
                <div class="search-act-blo">
                    <select id="filterStatus"  onchange="filterUsers()">
                        <option value="">Tous les statuts</option>
                        <option value="En cours">En cours</option>
                        <option value="Terminée">Terminée</option>
                        <option value="Brouillons">Brouillons</option>
                    </select>
                </div>
                <div class="search-calendrier">
                    <input type="date" id="searchcalendrier" onchange="filterUsers()">
                </div>
            </div>
            
            <!--tableaux-->
            <table class="table-login">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Titre de l'enquête</th>
                        <th>Type</th>
                        <th>Direction/Region</th>
                        <th>Statut</th>
                        <th>date debut</th>
                        <th>date fin</th>
                        <th>Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <?php if(count($users)>0): ?>
                    <?php foreach($users as $user): ?>    
                            <tr>
                                <td><?= htmlspecialchars($user['ID_enquete']) ?></td>
                                <td class="td-image">
                                    <?php if(!empty($user['Image_enquete'])): ?>
                                         <img src="data:image/png;base64,<?= base64_encode($user['Image_enquete']) ?>" 
                                                alt="Image enquête">
                                    <?php else: ?>
                                    <span>—</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($user['Titre']) ?></td>
                                <td><?= htmlspecialchars($user['Type']) ?></td>
                                <td><?= htmlspecialchars($user['Direction']) ?></td>
                                <td>
                                    <?php if($user['Statut']=="En cours"): ?>
                                        <span class="status-en-cours">En cours</span>
                                    <?php elseif($user['Statut']=="Terminée"): ?>
                                        <span class="status-termine">Terminée</span>
                                    <?php elseif($user['Statut']=="Brouillons"): ?>
                                        <span class="status-br">Brouillons</span>
                                    <?php else:?>
                                        <span class="status-br">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($user['date_debut']) ?></td>
                                <td><?= htmlspecialchars($user['date_fin']) ?></td>
                                <td class="link-cell">
                                    <a href="../<?= $user['link'] ?>" download="<?= $user['link'] ?>" class="btn-download" onclick="">
                                        <img src="../src/icons/download-icon.png" alt="Telecharger">
                                    </a>
                                </td>
                                <td class="actions-cell">
                                    <a href="#" class="btn-modifier" onclick="openEditModal('<?= $user['id'] ?>','<?= htmlspecialchars($user['ID_enquete'], ENT_QUOTES) ?>','<?= htmlspecialchars($user['Titre'], ENT_QUOTES) ?>','<?= htmlspecialchars($user['Type'], ENT_QUOTES) ?>','<?= htmlspecialchars($user['Direction'], ENT_QUOTES) ?>','<?= $user['date_debut'] ?>','<?= $user['date_fin'] ?>','<?= $user['Statut'] ?>','<?= !empty($user['Image_enquete']) ? "data:image/png;base64,".base64_encode($user['Image_enquete']) : "" ?>','<?= htmlspecialchars($user['link'], ENT_QUOTES) ?>'); return false;" title="Modifier">
                                        <img src="../src/icons/edit-icon.png" alt="Modifier">
                                    </a>
                                    <a href="utilisateurs_actions/supprimer_enquete.php" class="btn-supprimer" title="Supprimer" onclick="openDeleteModal(<?= $user['id'] ?>); return false;">
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


        <!--card statique-->
        <div class="card-statique">
            <div class="card-st">
                <h1 class="card-title">Enquêtes par statut</h1>
                <div class="statusChart">
                   <canvas  id="statusChart"></canvas> 
                </div>
                
            </div>
            <div class="card-st">
                <h1 class="card-title">Progression globale</h1>
                <div class="progression-container">
                    <canvas id="progressChart"></canvas>
                    <div class="progression-center">
                        <span class="progression-value" id="progressValue"></span>
                        <span class="progression-label">Progression moyenne</span>
                        <span class="progression-subtitle">Toutes enquêtes</span>
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


    //supprimer affiche
    let deleteId = null;

    function openDeleteModal(id){
        deleteId = id;
        document.getElementById("deleteenquete").style.display="flex";
    }

    function closeModal(){
        document.getElementById("deleteenquete").style.display="none";
        deleteId = null;
    }

    function deleteUser(){
        if(deleteId!=null){
            window.location.href =
            "utilisateurs_actions/supprimer_enquete.php?id="+deleteId;
        }
    }

    //modifier affiche 
    function openEditModal(id,ID_enquete,Titre,Type,Direction,date_debut,date_fin,Statut,imageSrc,linkName){
        document.getElementById("id").value = id;
        document.getElementById("ID_enquete").value = ID_enquete;
        document.getElementById("Titre").value = Titre;
        document.getElementById("Type").value = Type;
        document.getElementById("Direction").value = Direction;
        document.getElementById("date_debut").value = date_debut;
        document.getElementById("date_fin").value = date_fin;
        document.getElementById("Statut").value = Statut;

        const preview = document.getElementById('preview_image');
        if(imageSrc){
            preview.src = imageSrc;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }

        document.getElementById('current_file_name').textContent =
            linkName ? "Fichier actuel : " + linkName : "Aucun fichier";

        document.getElementById('Image_enquete').value = "";
        document.getElementById('link_file').value = "";

        document.getElementById("editModal").style.display = "flex";
    }

    function closeEditModal(){
        document.getElementById("editModal").style.display="none";
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

    //ajout affiche 
    function openAddModal() {
        document.getElementById("ID_enquete_aj").value = "";
        document.getElementById("Titre_aj").value ="";
        document.getElementById("Type_aj").value = "";
        document.getElementById("Direction_aj").value = "";
        document.getElementById("date_debut_aj").value = "";
        document.getElementById("date_fin_aj").value = "";
        document.getElementById("Statut_aj").value = "";

        const preview = document.getElementById('preview_image_aj');
        preview.style.display = 'none';
        preview.src = "";


        document.getElementById('Image_enquete_aj').value = "";
        document.getElementById('link_file_aj').value = "";

        document.getElementById("ajout-Modal").style.display = "flex";
    }

    function closeAddModal() {
        //document.getElementById("ajouter_error_msg").style.display = "none";
        document.getElementById("ajout-Modal").style.display = "none";
    }

    function filterUsers() {
        const input = document.getElementById("searchInput").value.toLowerCase().trim();
        const statusFilter = document.getElementById("filterStatus").value;
        const rows = document.querySelectorAll("#usersTableBody tr");
        const calendrier = document.getElementById("searchcalendrier").value;

        rows.forEach(row => {
            const ID = row.children[0]?.textContent.toLowerCase() || "";
            const Titre = row.children[2]?.textContent.toLowerCase() || "";
            const Type = row.children[3]?.textContent.toLowerCase() || "";
            const Direction = row.children[4]?.textContent.trim() || "";
            const Statut = row.children[5]?.textContent.trim() || "";
            const calendrier_1 = row.children[6]?.textContent.trim() || "";
            const calendrier_2 = row.children[7]?.textContent.trim() || "";

            const matchesText = ID.includes(input) || Titre.includes(input) || Direction.includes(input) || Type.includes(input);
            const matchesStatus = !statusFilter || Statut === statusFilter;
            const matchescalendrier = !calendrier || calendrier_1===calendrier || calendrier_2===calendrier;

            if (matchesText && matchesStatus && matchescalendrier) {
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

    const progress = <?= $totalenquete > 0 ? round(($total_Terminee / $totalenquete) * 100) : 0 ?>;

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