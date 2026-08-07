<?php
include "../dbconnect.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(!isset($_POST['id']) || !ctype_digit($_POST['id'])){
        header("Location: ../utilisateurs.php?error=notfound");
        exit;
    }

    $id = (int)$_POST['id'];
    $nom = trim($_POST['nom_complet'] ?? '');
    $email = trim($_POST['Email'] ?? '');
    $enteredPassword = trim($_POST['Password'] ?? '');
    $newPassword = trim($_POST['new_password'] ?? '');
    $region = trim($_POST['Region'] ?? '');
    $status = (int)($_POST['Status'] ?? 0);

    $stmt = $pdo->prepare("SELECT password FROM login WHERE id=?");
    $stmt->execute([$id]);
    $current = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$current){
        header("Location: ../utilisateurs.php?error=notfound");
        exit;
    }

    if($enteredPassword === ""){
        header("Location: ../utilisateurs.php?error=emptypassword");
        exit;
    }

    if(!password_verify($enteredPassword, $current['password'])){
        if($enteredPassword !== $current['password']){
            header("Location: ../utilisateurs.php?error=wrongpassword");
            exit;
        }
    }

    // Gestion du mot de passe final
    $finalPassword = $current['password'];
    if($newPassword !== ""){
        $finalPassword = $newPassword; 
    }

    $stmt = $pdo->prepare("
        UPDATE login SET
            nom_complet = ?,
            Email = ?,
            password = ?,
            Region = ?,
            Status = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $nom,
        $email,
        $finalPassword,
        $region,
        $status,
        $id
    ]);

    header("Location: ../utilisateurs.php?success=1");
    exit;

} else {
    header("Location: ../utilisateurs.php");
    exit;
}
?>