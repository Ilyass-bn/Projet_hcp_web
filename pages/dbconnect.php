<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "Hcp";

$conn = mysqli_connect($host, $user, $password, $dbname);

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}
//echo "Connexion réussie";
?>