<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = filter_var(trim($_POST['email']),FILTER_SANITIZE_EMAIL);
    $objet = htmlspecialchars(trim($_POST['objet']));
    $message = htmlspecialchars(trim($_POST['message']));

    if(empty($nom)||empty($email)||empty($message)||!filter_var($email,FILTER_VALIDATE_EMAIL)||empty($objet)){
        die("remplir correctement toutes les champs");
    }
    $destinataire = "benhadiilyass2023@gmail.com";
    $sujet = "Sujet : ".$objet;
    $contenu = "Nom : $nom\nEmail :  $email\nObjet : $objet\nMessage :\n $message\n";
    $headers  = "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if(mail($destinataire,$sujet,$contenu,$headers)){
        header("Location: contact.php?status=success");
        exit();
    }else{
        header("Location: contact.php?status=error");
        exit();
    }
}else{
    header("Location: contact.php");
}

?>