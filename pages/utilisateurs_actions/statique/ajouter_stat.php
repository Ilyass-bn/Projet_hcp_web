<?php
include "../../dbconnect.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    //$id = $_POST['id'];
    $ID_pub = $_POST['ID_stat_aj'];
    $Titre_pub = $_POST['Titre_stat_aj'];
    $Categorie = $_POST['Categorie_stat_aj'];
    $Statut = $_POST['Statut_stat_aj'];
    $date_pub = $_POST['date_stat_pub_aj'];
    $description = $_POST['Description_aj'];


    $uploadDir = __DIR__ . "/../../../uploads/";
    if(!is_dir($uploadDir)){
        mkdir($uploadDir, 0755, true);
    }

    $imageData = null;
    if(isset($_FILES['Image_stat_aj']) && $_FILES['Image_stat_aj']['error'] === UPLOAD_ERR_OK){
        $imageData = file_get_contents($_FILES['Image_stat_aj']['tmp_name']);
    }

    $linkPath = null;
    if(isset($_FILES['link_files_aj']) && $_FILES['link_files_aj']['error'] === UPLOAD_ERR_OK){
        $originalName = basename($_FILES['link_files_aj']['name']);
        $safeName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $targetPath = $uploadDir . $safeName;

    if(move_uploaded_file($_FILES['link_files_aj']['tmp_name'], $targetPath)){
        $linkPath = "uploads/" . $safeName;
    }
}
    


    try {
        $sql = "INSERT INTO statique (ID_stat,Titre_stat,Categorie_stat,Statut_stat,date_stat_pub,description_stat,Image_stat,link_files) 
                VALUES (:ID_stat, :Titre_stat, :Categorie_stat, :Statut_stat, :date_stat_pub, :description_stat, :Image_stat, :link_files)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':ID_stat'          => $ID_pub,
            ':Titre_stat'       => $Titre_pub,
            ':Categorie_stat'       => $Categorie,
            ':Statut_stat'          => $Statut,
            ':date_stat_pub'        => $date_pub,
            ':description_stat'     => $description,
            ':Image_stat'       => $imageData,
            ':link_files'        => $linkPath
        ]);

        header("Location: ../../statiques.php?success=statique_added");
        exit();

    } catch (PDOException $e) {
        header("Location: ../../statiques.php?error=db_error");
        exit();
    }

} else {
    header("Location: ../../statiques.php");
    exit();
}
?>