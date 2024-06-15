<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$id_produit = $_POST['id-produit'];
$id_boutique = $_POST['id-boutique'];
$quantite_produit = $_POST['quantite-produit'];



if ($resultat == true){
    $_SESSION['ajout_produit'] = "Produit : " . $nom_produit . " ajoutée avec succès !";
}
else {
    $_SESSION['ajout_produit'] = "Erreur lors de l'ajout de la confiserie.";
}
header("Location:" . CHEMIN_URL_SERVER . "produits.php?id_boutique=" . $id_boutique);
exit();
?>