<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$id_boutique = $_POST['id-produit'];

$resultat = delete_product($id_produit);

if ($resultat == true){
    $_SESSION['suppression_produit'] = "Produit supprimé avec succès !";
} 
else {
    $_SESSION['suppression_produit'] = "Erreur lors de la suppression de la confiserie.";
}
header("Location:" . CHEMIN_URL_SERVER . "admin.php");
exit();
?>