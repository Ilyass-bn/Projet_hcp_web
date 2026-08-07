<?php
include "../dbconnect.php";

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM login WHERE id=?");
    $stmt->execute([$id]);
}

header("Location: ../utilisateurs.php");
exit;
?>