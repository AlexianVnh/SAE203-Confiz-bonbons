<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$id_boutique = $_POST['id-boutique'];

$resultat = delete_shop($id_boutique);

if ($resultat == true){
    $_SESSION['suppression_boutique'] = "Boutique supprimée avec succès !";
} 
else {
    $_SESSION['suppression_boutique'] = "Erreur lors de la suppression de la boutique.";
}
header("Location:" . CHEMIN_URL_SERVER . "admin.php");
exit();
?>