<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$nom_produit = $_POST['nom-produit'];
$type_produit = $_POST['type-produit'];
$prix_produit = $_POST['prix-produit'];
$illustration_produit = $_POST['illustration-produit'];
$description_produit = $_POST['description-produit'];



$resultat = add_product($nom_produit, $type_produit, $prix_produit,
                $illustration_produit, $description_produit);

if ($resultat == true){
    $_SESSION['ajout_produit'] = "Produit : " . $nom_produit . " ajoutée avec succès !";
}
else {
    $_SESSION['ajout_produit'] = "Erreur lors de la suppression de la confiserie.";
}
header("Location:" . CHEMIN_URL_SERVER . "boutiques.php");
exit();
?>