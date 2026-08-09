<?php
include "../../dbconnect.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    //$id = $_POST['id'];
    $ID_pub = $_POST['ID_pub'];
    $Titre_pub = $_POST['Titre_pub'];
    $Categorie = $_POST['Categorie'];
    $Statut = $_POST['Statut'];
    $date_pub = $_POST['date_pub'];
    $description = $_POST['Description'];


    $uploadDir = __DIR__ . "/../../../uploads/";
    if(!is_dir($uploadDir)){
        mkdir($uploadDir, 0755, true);
    }

    $imageData = null;
    if(isset($_FILES['Image_pub']) && $_FILES['Image_pub']['error'] === UPLOAD_ERR_OK){
        $imageData = file_get_contents($_FILES['Image_pub']['tmp_name']);
    }

    $linkPath = null;
    if(isset($_FILES['link_pub']) && $_FILES['link_pub']['error'] === UPLOAD_ERR_OK){
        $originalName = basename($_FILES['link_pub']['name']);
        $safeName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $targetPath = $uploadDir . $safeName;

    if(move_uploaded_file($_FILES['link_pub']['tmp_name'], $targetPath)){
        $linkPath = "uploads/" . $safeName;
    }
}
    


    try {
        $sql = "INSERT INTO publication (ID_pub,Titre_pub,Categorie,Statut,date_pub,description,Images,link_pub) 
                VALUES (:ID_pub, :Titre_pub, :Categorie, :Statut, :date_pub, :description, :Image_pub, :link_pub)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':ID_pub'          => $ID_pub,
            ':Titre_pub'       => $Titre_pub,
            ':Categorie'       => $Categorie,
            ':Statut'          => $Statut,
            ':date_pub'        => $date_pub,
            ':description'     => $description,
            ':Image_pub'       => $imageData,
            ':link_pub'        => $linkPath
        ]);

        header("Location: ../../publication.php?success=publication_added");
        exit();

    } catch (PDOException $e) {
        header("Location: ../../publication.php?error=db_error");
        exit();
    }

} else {
    header("Location: ../../publication.php");
    exit();
}
?>