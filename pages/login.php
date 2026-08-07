<?php
session_start();
require "dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];   // ← corrigé, correspond au name="username" du form
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM login WHERE nom_complet = ?");
    $stmt->execute([$username]);      // on compare $username avec la colonne nom_complet en base
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["id"] = $user["id"];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>

    <div class="logo-hpc"><img src="../src/img/hcp_logo.png"></div>
    <div class="home-body-login">
        <form method="POST" action="">
            <div class="text">
                <h1>Connexion</h1>
                <p>Accédez à votre espace sécurisé</p>
            </div>
            <div class="form-group">
                <span class="input-icon">
                    <img src="../src/icons/user-icon.png" alt="">    
                </span>
                <input type="text" placeholder="Entrez votre nom d'utilisateur" name="username">
            </div>
            <div class="form-group">
                <span class="input-icon">
                    <img src="../src/icons/lock.png" alt="">    
                </span>
                <input type="password" placeholder="Entrez votre mot passe" name="password">
            </div>
            <div class="options">
                <label>
                    <input type="checkbox" placeholder="Entrez votre mot de passe">Se souvenir de moi
                </label>
                <a href="#" class="forgot">Mot de passe oublié ?</a>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        
        <div class="text-bottom">
            <p>Vous n'avez pas de compte ?</p>
            <a href="#">Contacter l'administrateur</a>
        </div>
    </div>
    <div class="image-body"><img src="../src/img/hcp-img.png"></div>


    <!--les caracteistiques-->
    <div class="card-special">
        <div class="card-special-0">
            <div class="image"><img src="../src/icons/securite.png"></div>
            <div class="paragraphe">
                <p class="title">Données fiables</p>
                <p class="description">Des statistiques de qualité</p>
            </div>
        </div>
        <div class="card-special-0">
            <div class="image"><img src="../src/icons/statique-icon.png"></div>
            <div class="paragraphe">
                <p class="title">Vision du Maroc</p>
                <p class="description">Aujourd'hui et demain</p>
            </div>
        </div>
        <div class="card-special-0">
            <div class="image"><img src="../src/icons/societe.png"></div>
            <div class="paragraphe">
                <p class="title">Développement durable</p>
                <p class="description">Des décisions éclairées</p>
            </div>
        </div>
        <div class="card-special-0">
            <div class="image-lock"><img src="../src/icons/lock.png"></div>
            <div class="paragraphe">
                <p class="title">Sécurité garantie</p>
                <p class="description">Vos données protégées</p>
            </div>
        </div>
    </div>





    <div class="bar-bottom">
        <p>© 2026 Haut-Commissariat au Plan - Tous droits réservés</p>
        <p class="center">Aide <span class="bar">|</span> Confidentialité <span class="bar">|</span> Conditions d'utilisation</p>
        <a href="home.php"><p>hcp.site</p></a>
    </div>


</body>
</html>