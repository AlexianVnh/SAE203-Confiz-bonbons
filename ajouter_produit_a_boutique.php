<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$id_produit = $_POST['id-produit'];
$id_boutique = $_POST['id-boutique'];
$quantite_produit = $_POST['quantite-produit'];

$resultat = add_product_to_shop($id_produit, $id_boutique, $quantite_produit);

if ($resultat == true) {
    $_SESSION['ajout_produit'] = "Produit ajouté avec succès!";
} else {
    $_SESSION['ajout_produit'] = "Erreur : le produit existe déjà dans cette boutique.";
}

header("Location:" . CHEMIN_URL_SERVER . "produits.php?id_boutique=" . $id_boutique);
exit();
?>