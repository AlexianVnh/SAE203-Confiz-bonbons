<?php
include_once ("../functions.php");

// Récupérer les valeurs du formulaire
$username = $_POST['name'];

$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$email = $_POST['email'] . '@example.com';
$ddn = $_POST['ddn'];

$role = $_POST['role'];
$mot_de_passe = $_POST['password'];

// Vérifier si l'utilisateur peut être authentifier
$resultat = add_account($username, $prenom, $nom, $email, $ddn, $role, $mot_de_passe);

if ($resultat == true){
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    $_SESSION['loggedin'] = true;
    $_SESSION['id_user'] = get_id_user_gerant($_SESSION['username']);
    header("Location: " . CHEMIN_URL_SERVER . "index.php");
    exit();
}
else{
    $_SESSION['error'] = "Mauvais login / mot de passe";
    header("Location: " . CHEMIN_URL_SERVER . "account/login.php");
    exit();
}
?>