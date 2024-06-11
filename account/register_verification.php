<?php
include_once ("../functions.php");

// Récupérer les valeurs du formulaire
$nom_user = $_POST['name'];
$role = $_POST['role'];
$mot_de_passe = $_POST['password'];

// Vérifier si l'utilisateur peut être authentifier
$resultat = add_account($nom_user, $role, $mot_de_passe);

if ($resultat == true){
    $_SESSION['nom_user'] = $nom_user;
    $_SESSION['role'] = $role;
    $_SESSION['loggedin'] = true;
    header("Location: " . CHEMIN_URL_SERVER . "index.php");
    exit();
}
else{
    $_SESSION['error'] = "Mauvais login / mot de passe";
    header("Location: " . CHEMIN_URL_SERVER . "account/login.php");
    exit();
}
?>