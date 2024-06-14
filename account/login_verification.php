<?php
include_once ("../functions.php");

// Récupérer les valeurs du formulaire
$username = $_POST['name'];
$role = $_POST['role'];
$mot_de_passe = $_POST['password'];


// Vérifier si l'utilisateur peut être authentifier
$resultat = check_login($username, $role, $mot_de_passe);


if ($resultat == true){
    $_SESSION['username'] = $username;
    $_SESSION['role'] = $role;
    $_SESSION['loggedin'] = true;
    $_SESSION['id_user'] = get_id_user_gerant($_SESSION['username']);
    header("Location:" . CHEMIN_URL_SERVER . "index.php");
    exit();
}
else{
    $_SESSION['error'] = "Mauvais login ou mot de passe " . $username . " / " . $role . " / " . $mot_de_passe . " / ";
    header("Location: " . CHEMIN_URL_SERVER . "account/login.php");
    exit();
}
?>