<?php
include "../dbconnect.php"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //$id = $_POST['id'];
    $ID_enquete = $_POST['ID_enquete_aj'];
    $Titre = $_POST['Titre_aj'];
    $Type = $_POST['Type_aj'];
    $Direction = $_POST['Direction_aj'];
    $date_debut = $_POST['date_debut_aj'];
    $date_fin = $_POST['date_fin_aj'];
    $Statut = $_POST['Statut_aj'];


    $uploadDir = __DIR__ . "/../../uploads/";
    if(!is_dir($uploadDir)){
        mkdir($uploadDir, 0755, true);
    }

    $imageData = null;
    if(isset($_FILES['Image_enquete_aj']) && $_FILES['Image_enquete_aj']['error'] === UPLOAD_ERR_OK){
        $imageData = file_get_contents($_FILES['Image_enquete_aj']['tmp_name']);
    }

    $linkPath = null;
    if(isset($_FILES['link_file_aj']) && $_FILES['link_file_aj']['error'] === UPLOAD_ERR_OK){
        $originalName = basename($_FILES['link_file_aj']['name']);
        $safeName = time() . "_" . preg_replace('/[^A-Za-z0-9._-]/', '_', $originalName);
        $targetPath = $uploadDir . $safeName;

    if(move_uploaded_file($_FILES['link_file_aj']['tmp_name'], $targetPath)){
        $linkPath = "uploads/" . $safeName;
    }
}
    


    try {
        $sql = "INSERT INTO enquete (ID_enquete,Titre,Type,Direction,date_debut,date_fin,Statut,Image_enquete,link) 
                VALUES (:ID_enquete, :Titre, :Type, :Direction, :date_debut, :date_fin, :Statut, :Image_enquete, :link)";
        
        $stmt = $pdo->prepare($sql);
        
        $stmt->execute([
            ':ID_enquete'  => $ID_enquete,
            ':Titre'       => $Titre,
            ':Type'        => $Type,
            ':Direction'   => $Direction,
            ':date_debut'  => $date_debut,
            ':date_fin'    => $date_fin,
            ':Statut'    => $Statut,
            ':Image_enquete'    => $imageData,
            ':link'    => $linkPath
        ]);

        header("Location: ../enquete.php?success=enquete_added");
        exit();

    } catch (PDOException $e) {
        header("Location: ../enquete.php?error=db_error");
        exit();
    }

} else {
    header("Location: ../enquete.php");
    exit();
}
?>