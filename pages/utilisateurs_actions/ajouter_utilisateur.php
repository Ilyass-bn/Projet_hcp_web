<?php
include "../dbconnect.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom_complet = trim($_POST['ajouter_nom_complet'] ?? '');
    $email       = trim($_POST['ajouter_Email'] ?? '');
    $password    = $_POST['ajouter_Password'] ?? '';
    $region      = trim($_POST['ajouter_Region'] ?? '');
    $status      = isset($_POST['ajouter_Status']) ? (int)$_POST['ajouter_Status'] : 1;
    $role        = "Admin"; 

    if (empty($password)) {
        header("Location: ../utilisateurs.php?error=empty_password");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO login (nom_complet, Email, password, Role, Region, Status) 
                VALUES (:nom_complet, :email, :password, :role, :region, :status)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':nom_complet' => $nom_complet,
            ':email'       => $email,
            ':password'    => $hashed_password,
            ':role'        => $role,
            ':region'      => $region,
            ':status'      => $status
        ]);

        header("Location: ../utilisateurs.php?success=user_added");
        exit();

    } catch (PDOException $e) {
        header("Location: ../utilisateurs.php?error=db_error");
        exit();
    }

} else {
    header("Location: ../utilisateurs.php");
    exit();
}
?>