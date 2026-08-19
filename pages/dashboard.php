<?php
session_start();
include "dbconnect.php";

$current = basename($_SERVER['PHP_SELF']);


$totalenquete = $pdo->query("Select count(*) from enquete")->fetchColumn();
$totalstatique = $pdo->query("Select count(*) from statique")->fetchColumn();
$totalpublication = $pdo->query("Select count(*) from publication")->fetchColumn();
$totalutilisateur = $pdo->query("Select count(*) from login")->fetchColumn();
$totalbruill_enquete = $pdo->query("Select count(*) from enquete where Statut='Brouillons'")->fetchColumn();
$totalbruill_statique = $pdo->query("Select count(*) from statique where Statut_stat='Brouillons'")->fetchColumn();
$totalbruill_publication = $pdo->query("Select count(*) from publication where Statut='Brouillons'")->fetchColumn();

$totalpub_enquete = $pdo->query("Select count(*) from enquete where Statut='Terminée'")->fetchColumn();
$totalpub_statique = $pdo->query("Select count(*) from statique where Statut_stat='Publié'")->fetchColumn();
$totalpub_publication = $pdo->query("Select count(*) from publication where Statut='Publié'")->fetchColumn();


$totalbruill = $totalbruill_enquete+$totalbruill_publication+$totalbruill_statique;
$totalpub = $totalpub_enquete+$totalpub_publication+$totalpub_statique;
if($totalbruill==0 && $totalpub==0){
    $totalpub_pourcentage=0;$totalbruill_pourcentage=0;
}else{
    $totalpub_pourcentage = round($totalpub/($totalbruill+$totalpub),2);
    $totalbruill_pourcentage = round($totalbruill/($totalbruill+$totalpub),2);
}



$totaltel_statique = $pdo->query("Select SUM(nbre_stat) from statique")->fetchColumn();
$totaltel_publication = $pdo->query("Select SUM(nbre_tel) from publication")->fetchColumn();
$totaltel = $totaltel_statique+$totaltel_publication;
?>

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
include "dbconnect.php";

$current = basename($_SERVER['PHP_SELF']);

$sql = $pdo->query("SELECT id,ID_stat,Image_stat,Titre_stat,description_stat,Categorie_stat,Statut_stat,date_stat_pub,link_files,nbre_stat FROM statique ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);
$totalstat = $pdo->query("Select count(*) from statique")->fetchColumn();
$totaleco = $pdo->query("Select count(*) from statique where Categorie_stat='Economie'")->fetchColumn();
$totaltrav = $pdo->query("Select count(*) from statique where Categorie_stat='Marché du travail'")->fetchColumn();
$totaldev = $pdo->query("Select count(*) from statique where Categorie_stat='Développement durable'")->fetchColumn();
$totalrev = $pdo->query("Select count(*) from statique where Categorie_stat='Revenu & conditions de vie'")->fetchColumn();
$totalautres = $pdo->query("Select count(*) from statique where Categorie_stat='Autres...'")->fetchColumn();
$totalpop = $pdo->query("Select count(*) from statique where Categorie_stat='Population & démographie'")->fetchColumn();
$totaltelech = $pdo->query("Select SUM(nbre_stat) from statique")->fetchColumn();
$totalpublie = $pdo->query("Select count(*) from statique where Statut_stat='Publié'")->fetchColumn();
$totalbr = $pdo->query("Select count(*) from statique where Statut_stat='Brouillons'")->fetchColumn();


//gestion_donne_economique 
$sql = $pdo->query("SELECT ID_eco,PIB,Population,PIB_dp,Inflation FROM gestion_donne_economique");
$economique = $sql->fetchAll(PDO::FETCH_ASSOC);

//gestion_reseau 
$sql = $pdo->query("SELECT ID_res,Direction_reg,Bureaux_prov,Donnees_coll FROM gestion_reseau ");
$reseau = $sql->fetchAll(PDO::FETCH_ASSOC);

//gestion_donn_dem 
$sql = $pdo->query("SELECT id,ID_hcp,Hcp,habitants,Taux_croiss,Superficie,Taux_chomage,Population,PIB_reg,Etablissements,Taux_emploi FROM gestion_donn_dem ");
$donne = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
include "dbconnect.php";

$current = basename($_SERVER['PHP_SELF']);

$sql = $pdo->query("SELECT id,ID_pub,Images,Titre_pub,Categorie,Statut,date_pub,description,link_pub,nbre_tel FROM publication ORDER BY id DESC");
$users = $sql->fetchAll(PDO::FETCH_ASSOC);
$totalrapp = $pdo->query("Select count(*) from publication where Categorie='Rapports et études'")->fetchColumn();
$totalnot = $pdo->query("Select count(*) from publication where Categorie='Notes et analyses'")->fetchColumn();
$totalautre = $pdo->query("Select count(*) from publication where Categorie='Autres documents'")->fetchColumn();
$totalbull = $pdo->query("Select count(*) from publication where Categorie='Bulletins et revues'")->fetchColumn();
$totalpublie = $pdo->query("Select count(*) from publication where Statut='Publié'")->fetchColumn();
$totalbr = $pdo->query("Select count(*) from publication where Statut='Brouillons'")->fetchColumn();

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

<?php
$sql_mois_1 = $pdo->query("
    SELECT MONTH(date_stat_pub) AS mois, COUNT(*) AS total
    FROM statique
    WHERE YEAR(date_stat_pub) = YEAR(CURDATE())
    GROUP BY MONTH(date_stat_pub)
    ORDER BY MONTH(date_stat_pub)
");

$mois_1 = array_fill(1, 12, 0);
while ($row = $sql_mois_1->fetch(PDO::FETCH_ASSOC)) {
    $mois_1[(int)$row['mois']] = (int)$row['total'];
}
?>


<?php
$sql_mois_2 = $pdo->query("
    SELECT MONTH(date_pub) AS mois, COUNT(*) AS total
    FROM publication
    WHERE YEAR(date_pub) = YEAR(CURDATE())
    GROUP BY MONTH(date_pub)
    ORDER BY MONTH(date_pub)
");

$mois_2 = array_fill(1, 12, 0);
while ($row = $sql_mois_2->fetch(PDO::FETCH_ASSOC)) {
    $mois_2[(int)$row['mois']] = (int)$row['total'];
}
?>

<?php
//month
$jours = [];
$sql_jours = $pdo->query("SELECT date_jour, nbre_tel FROM telechargement_jour_publication ORDER BY date_jour ASC");
while ($row = $sql_jours->fetch(PDO::FETCH_ASSOC)) {
    $jours[$row['date_jour']] = (int) $row['nbre_tel'];
}

$sql_autre = $pdo->query("SELECT date_jour, nbre_tel FROM telechargement_jour_statique ORDER BY date_jour ASC");
while ($row = $sql_autre->fetch(PDO::FETCH_ASSOC)) {
    if (isset($jours[$row['date_jour']])) {
        $jours[$row['date_jour']] += (int) $row['nbre_tel'];
    } else {
        $jours[$row['date_jour']] = (int) $row['nbre_tel'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <link rel="stylesheet" href="utilisateurs.css">
    <link rel="stylesheet" href="dashboard.css">
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
                <h1>Bienvenue, <?= htmlspecialchars($_SESSION["nom"] ?? '') ?> !</h1>
                <p>Voici un aperçu général des activités et des statistiques du HCP.</p>
            </div>
            <div class="buttons">
                <button class="btn-exp" onclick="window.location.href='utilisateurs_actions/exporter_enquete.php'">Exporter</button>
            </div>
        </div>
        <div class="cards-cara" style="margin-top: 30px;">
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/clipboard-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalenquete ?></h2>
                    <p class="card-det"><b>Enquêtes totales</b><br><span>Toutes enquêtes</span></p> 
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/economie-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalstatique ?></h2>
                    <p class="card-det"><b>Statistiques totales</b><br><span>Toutes statistiques</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/publication-icon-dash.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalpublication ?></h2>
                    <p class="card-det"><b>Publications</b><br><span>Toutes publications</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/card-people.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalutilisateur ?></h2>
                    <p class="card-det"><b>Utilisateurs totaux</b><br><span>Tous les comptes</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/chart-icon-improved.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalpub ?></h2>
                    <p class="card-det"><b>Publié</b><br><span><?= $totalpub_pourcentage*100  ?>% du total</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/bruillet-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $totalbruill ?></h2>
                    <p class="card-det"><b>Brouillons</b><br><span><?= $totalbruill_pourcentage*100 ?>% du total</span></p>
                </div>
                
            </div>
            <div class="card-cara">
                <div class="image-icon"><img src="../src/icons/download-icon.png"></div>
                <div class="paragraphe">
                    <h2><?= $totaltel ?></h2>
                    <p class="card-det"><b>Téléchargements</b><br><span>Tous les comptes</span></p>
                </div>
                
            </div>
        </div>



        <div class="card-statique-0" style="background-color: white;margin-bottom:-10px;margin-top:50px;">
            <div class="card-st">
                <h1 class="card-title" style="color:#5e1d3e;padding-top:8px;padding-left:20px;font-size:24px;font-family: 'Inter', 'Open Sans', -apple-system, sans-serif;">Téléchargements récents</h1>
                <div class="dailyChart">
                    <div class="dailyChart-scroll">
                        <canvas id="dailyChart" style="height:300px;"></canvas>
                    </div>
                </div>
            </div>
       
        </div>
        <div class="card-statique-1" style="margin-bottom:-10px;">
            <div class="card-st" >
                <h1 class="card-title">Enquêtes collectées</h1>
                <div class="monthlyChart">
                    <canvas id="monthlyChart" style="height:300px;"></canvas>
                </div>
            </div>
            <div class="card-st" >
                <h1 class="card-title">Statiques collectées</h1>
                <div class="monthlyChart_1">
                    <canvas id="monthlyChart_1" style="height:300px;"></canvas>
                </div>
            </div>
            <div class="card-st">
                <h1 class="card-title">Publications collectées</h1>
                <div class="monthlyChart_2">
                    <canvas id="monthlyChart_2" style="height:300px;"></canvas>
                </div>
            </div>
        </div>


        <div class="card-statique">
            <div class="card-st">
                <h1 class="card-title">Enquêtes par statut</h1>
                <div class="statusChart">
                   <canvas  id="statusChart"></canvas> 
                </div>
                
            </div>
            <div class="card-st" >
                <h1 class="card-title" style="font-size:22px;">Répartition des statistiques</h1>
                <div class="statusChart_1">
                   <canvas  id="statusChart_1"></canvas> 
                </div>
                
            </div>
            <div class="card-st">
                <h1 class="card-title" style="font-size:19px;">Publications par statut</h1>
                <div class="statusChart_2">
                   <canvas  id="statusChart_2"></canvas> 
                </div>
                
            </div>
            <div class="card-st">
                <h1 class="card-title" style="font-size:19px;">Publication globale</h1>
                <div class="progression-container">
                    <canvas id="progressChart"></canvas>
                    <div class="progression-center">
                        <span class="progression-value" id="progressValue"></span>
                        <span class="progression-label">Publication moyenne</span>
                        <span class="progression-subtitle">Publie</span>
                    </div>
                </div>
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
    links.forEach(link => {
        link.classList.remove('active');
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

<script>
    //publication par statut
    document.addEventListener("DOMContentLoaded", function () {

        const ctx = document.getElementById("statusChart_1");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["Economie", "Marché du travail", "Développement durable","Revenu & conditions de vie","Autres statiques","Population & démographie"],
                datasets: [{
                    data: [
                        <?= $totaleco ?>,
                        <?= $totaltrav ?>,
                        <?= $totaldev ?>,
                        <?= $totalrev ?>,
                        <?= $totalautres ?>,
                        <?= $totalpop ?>
                    ],
                    backgroundColor: [
                        "rgb(201, 136, 14)",
                        "rgb(30, 138, 76)",
                        "rgb(214, 41, 40)",
                        "rgb(232, 183, 29)",
                        "rgb(126, 126, 126)",
                        "rgb(0, 38, 255)"

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

<script>
    //publication par statut
    document.addEventListener("DOMContentLoaded", function () {

        const ctx = document.getElementById("statusChart_2");

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

<script>
//progression card
document.addEventListener("DOMContentLoaded", function () {

    const progress = <?= $totalpub_pourcentage * 100?>;

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


<script>
//mois 
document.addEventListener("DOMContentLoaded", function () {
    const ctxMonthly = document.getElementById("monthlyChart_1");
    const monthlyData = <?= json_encode(array_values($mois_1)) ?>;
    const monthLabels = ["Jan","Fév","Mar","Avr","Mai","Juin","Juil","Août","Sep","Oct","Nov","Déc"];

    const gradient = ctxMonthly.getContext("2d").createLinearGradient(0, 0, 0, 250);
    gradient.addColorStop(0, "rgba(107, 18, 60, 0.35)");
    gradient.addColorStop(1, "rgba(107, 18, 60, 0)");

    new Chart(ctxMonthly, {
        type: "line",
        data: {
            labels: monthLabels,
            datasets: [{
                label: "Statiques",
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


<script>
//mois 
document.addEventListener("DOMContentLoaded", function () {
    const ctxMonthly = document.getElementById("monthlyChart_2");
    const monthlyData = <?= json_encode(array_values($mois_2)) ?>;
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

<script>
//jour telechargement
document.addEventListener("DOMContentLoaded", function () {

    const canvas = document.getElementById("dailyChart");

    const dailyData = <?= json_encode(array_values($jours)) ?>;
    const dailyLabels = <?= json_encode(array_keys($jours)) ?>;

    /*
     * Largeur du graphique :
     * minimum 1200px
     * +80px pour chaque jour
     */
    const chartWidth = Math.max(1200, dailyLabels.length * 80);

    canvas.style.width = chartWidth + "px";
    canvas.style.height = "280px";

    const ctxDaily = canvas.getContext("2d");

    const gradient = ctxDaily.createLinearGradient(0, 0, 0, 250);

    gradient.addColorStop(
        0,
        "rgba(107, 18, 60, 0.35)"
    );

    gradient.addColorStop(
        1,
        "rgba(107, 18, 60, 0)"
    );

    new Chart(ctxDaily, {

        type: "line",

        data: {

            labels: dailyLabels,

            datasets: [{

                label: "Téléchargements",

                data: dailyData,

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

            responsive: false,

            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                },

                tooltip: {

                    backgroundColor: "#6B123C",

                    padding: 10,

                    displayColors: false

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    grid: {
                        color: "#f0f0f0"
                    }

                },

                x: {

                    grid: {
                        display: false
                    }

                }

            }

        }

    });

});
</script>
</body>
</html>