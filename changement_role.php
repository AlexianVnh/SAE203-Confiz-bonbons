<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$id_utilisateur = $_POST['id-utilisateur'];
$role_utilisateur = $_POST['role-utilisateur'];

$resultat = change_role($id_utilisateur, $role_utilisateur);

if ($resultat == true) {
    $_SESSION['changement_role'] = "L'utilisateur " . $id_utilisateur . " est maintenant : " . $role_utilisateur;
    
    // Vérifier si l'utilisateur change son propre rôle
    if ((int)$id_utilisateur === (int)$_SESSION['id_user'][0]['id']) {
        $_SESSION['role'] = $role_utilisateur;
        
        // Rediriger selon le nouveau rôle
        if ($role_utilisateur === 'gerant') {
            header("Location: " . CHEMIN_URL_SERVER . "index.php");
        } else {
            header("Location: " . CHEMIN_URL_SERVER . "admin.php");
        }
        exit();
    }
} else {
    $_SESSION['changement_role'] = "Erreur : l'utilisateur a déjà ce rôle";
}

header("Location:" . CHEMIN_URL_SERVER . "admin.php");
exit();
?>