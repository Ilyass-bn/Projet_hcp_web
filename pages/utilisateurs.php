<?php
include "dbconnect.php";

$errorMsg = "";
if(isset($_GET['error']) && $_GET['error'] === 'wrongpassword'){
    $errorMsg = "Mot de passe incorrect. La modification a été annulée.";
}

$current = basename($_SERVER['PHP_SELF']);

$sql = $pdo->query("SELECT id,nom_complet,Email,Role,Region,Status,password FROM login ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);
$totalusers = $pdo->query("Select count(*) from login")->fetchColumn();
$totalactive = $pdo->query("Select count(*) from login where Status=1")->fetchColumn();
$totalbloque = $pdo->query("Select count(*) from login where Status=0")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <link rel="stylesheet" href="utilisateurs.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>

<!--supprimer affiche-->
<div id="deleteModal" class="modal">
    <div class="modal-content">

        <div class="modal-icon"><img src="../src/icons/delete-icon.png"></div>

        <h2>Supprimer l'utilisateur</h2>

        <p>
            Êtes-vous sûr de vouloir supprimer cet utilisateur ?
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

        <h2>Modifier l'utilisateur</h2>

        <form action="utilisateurs_actions/modifier_utilisateur.php" method="POST">

            <input type="hidden" id="edit_id" name="id">

            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" id="edit_nom" name="nom_complet" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" id="edit_email" name="Email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" id="edit_password" name="Password">
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="text" id="new_password" name="new_password">
            </div>

            <div class="form-group">
                <label>Région</label>
                <input type="text" id="edit_region" name="Region">
            </div>

            <div class="form-group">
                <label>Statut</label>

                <select id="edit_status" name="Status">
                    <option value="1">Actif</option>
                    <option value="0">Bloqué</option>
                </select>

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
<div id="ajouter-Modal" class="modal ajouter-modal" style="display: none;">
    <div class="modal-content modal-ajouter">

        <h2>Ajouter Admin</h2>

        <form action="utilisateurs_actions/ajouter_utilisateur.php" method="POST" onsubmit="return validateAddForm()">

            <div class="form-group">
                <label>Nom complet</label>
                <input type="text" id="ajouter_nom" name="ajouter_nom_complet" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" id="ajouter_email" name="ajouter_Email" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" id="ajouter_password" name="ajouter_Password">
            </div>

            <div class="form-group">
                <label>Région</label>
                <input type="text" id="ajouter_region" name="ajouter_Region">
            </div>

            <div class="form-group">
                <label>Statut</label>
                <select id="ajouter_status" name="ajouter_Status">
                    <option value="1">Actif</option>
                    <option value="0">Bloqué</option>
                </select>
            </div>

            <!-- Message d'erreur JavaScript -->
            <p id="ajouter_error_msg" style="color: #e74c3c; font-weight: bold; display: none; margin-top: 10px;"></p>

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
            <a href="#" onclick="changeActive(this)"><img src="../src/icons/publication-admin.png" data-default="../src/icons/publication-admin.png" data-active="../src/icons/publication-admin-active.png">Publications</a>
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
                <h1>Utilisateurs</h1>
                <p>Gérez les utilisateurs et leurs permissions</p>
            </div>
            <div class="buttons">
                <button class="btn-add" onclick="openAddModal()">Ajouter un utilisateur</button>
                <button class="btn-exp" onclick="window.location.href='utilisateurs_actions/exporter_utilisateurs.php'">Exporter</button>
            </div>
        </div>
        <div class="cards-cara">
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/card-people.png"></div>
                <div class="paragraphe">
                   <h2><?= $totalusers ?></h2>
                    <p class="card-det"><b>Utilisateurs totaux</b><br><span>Tous les comptes</span></p> 
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/card-active.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalactive ?></h2>
                    <p class="card-det"><b>Actifs</b><br><span>Comptes actifs</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/card-lock.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalbloque ?></h2>
                    <p class="card-det"><b>Bloqués</b><br><span>Comptes bloqués</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/card-admin.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalusers ?></h2>
                    <p class="card-det"><b>Admins</b><br><span>Administrateurs</span></p>
                </div>
                
            </div>
        </div>

        <div class="table-background">
            <!-- barre de recherche -->
            <div class="tab-search">
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Rechercher un utilisateur..." onkeyup="filterUsers()">
                </div>
                <div class="search-act-blo">
                    <select id="filterStatus" onchange="filterUsers()">
                        <option value="">Tous les statuts</option>
                        <option value="1">Actif</option>
                        <option value="0">Bloqué</option>
                    </select>
                </div>
            </div>
            
            <!--tableaux-->
            <table class="table-login">
                     
                <thread>
                    <tr>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Direction/Region</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thread>
                <tbody id="usersTableBody">
                    <?php if(count($users)>0): ?>
                    <?php foreach($users as $user): ?>    
                            <tr>
                                <td><?= htmlspecialchars($user['nom_complet']) ?></td>
                                <td><?= htmlspecialchars($user['Email']) ?></td>
                                <td><?= htmlspecialchars($user['Role']) ?></td>
                                <td><?= htmlspecialchars($user['Region']) ?></td>
                                <td>
                                    <?php if($user['Status']=="1"): ?>
                                        <span class="status-actif">Actif</span>
                                    <?php else: ?>
                                        <span class="Status-bloque">Bloqué</span>
                                    <?php endif; ?>
                                </td>
                                <td class="actions-cell">
                                    <a href="#" class="btn-modifier" onclick="openEditModal('<?= $user['id'] ?>','<?= htmlspecialchars($user['nom_complet'], ENT_QUOTES) ?>','<?= htmlspecialchars($user['Email'], ENT_QUOTES) ?>','<?= htmlspecialchars($user['Region'], ENT_QUOTES) ?>','<?= $user['Status'] ?>'); return false;" title="Modifier">
                                        <img src="../src/icons/edit-icon.png" alt="Modifier">
                                    </a>
                                    <a href="utilisateurs_actions/supprimer_utilisateur.php" class="btn-supprimer" title="Supprimer" onclick="openDeleteModal(<?= $user['id'] ?>); return false;">
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


    
    <?php if($errorMsg): ?>
        <div class="alert-error"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>
    
   




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
        document.getElementById("deleteModal").style.display="flex";
    }

    function closeModal(){
        document.getElementById("deleteModal").style.display="none";
        deleteId = null;
    }

    function deleteUser(){
        if(deleteId!=null){
            window.location.href =
            "utilisateurs_actions/supprimer_utilisateur.php?id="+deleteId;
        }
    }
    
    //modifier affiche 
    function openEditModal(id, nom, email, region, status){
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_nom").value = nom;
    document.getElementById("edit_email").value = email;
    document.getElementById("edit_password").value = "";
    document.getElementById("new_password").value = "";
    document.getElementById("edit_region").value = region;
    document.getElementById("edit_status").value = status;

    document.getElementById("editModal").style.display = "flex";
    }

    function closeEditModal(){

    document.getElementById("editModal").style.display="none";

    }
    

    //ajouter 
    function openAddModal() {
        document.getElementById("ajouter_nom").value = "";
        document.getElementById("ajouter_email").value = "";
        document.getElementById("ajouter_password").value = "";
        document.getElementById("ajouter_region").value = "";
        document.getElementById("ajouter_status").value = "1";

    
        document.getElementById("ajouter_error_msg").style.display = "none";

        document.getElementById("ajouter-Modal").style.display = "flex";
    }

    function closeAddModal() {
        document.getElementById("ajouter_error_msg").style.display = "none";
        document.getElementById("ajouter-Modal").style.display = "none";
    }

    function validateAddForm() {
        const passwordInput = document.getElementById("ajouter_password").value.trim();
        const errorMsgElement = document.getElementById("ajouter_error_msg");

        if (passwordInput === "") {
            errorMsgElement.innerText = "Veuillez saisir un mot de passe pour le nouvel administrateur !";
            errorMsgElement.style.display = "block";
            return false;
        }

        errorMsgElement.style.display = "none";
        return true;
    }

    //function chercher 
    function filterUsers() {
        const input = document.getElementById("searchInput").value.toLowerCase().trim();
        const statusFilter = document.getElementById("filterStatus").value;
        const rows = document.querySelectorAll("#usersTableBody tr");

        rows.forEach(row => {
            const nom = row.children[0]?.textContent.toLowerCase() || "";
            const email = row.children[1]?.textContent.toLowerCase() || "";
            const direction = row.children[3]?.textContent.toLowerCase() || "";
            const statutCell = row.children[4]?.textContent.trim() || "";

            const matchesText = nom.includes(input) || email.includes(input) || direction.includes(input);

            let matchesStatus = true;
            if (statusFilter === "1") {
                matchesStatus = statutCell === "Actif";
            } else if (statusFilter === "0") {
                matchesStatus = statutCell === "Bloqué";
            }

            if (matchesText && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
    });
    }
    
</script>
</body>
</html>