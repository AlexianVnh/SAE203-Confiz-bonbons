<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$nom_produit = $_POST['nom-produit'];
$type_produit = $_POST['type-produit'];
$prix_produit = $_POST['prix-produit'];
$illustration_produit = $_POST['illustration-produit'];
$description_produit = $_POST['description-produit'];

// Extensions autorisées
$extensions_permises = ['png', 'jpg', 'jpeg'];

$extension = pathinfo($illustration_produit, PATHINFO_EXTENSION);

if (!in_array($extension, $extensions_permises)) {
    $_SESSION['ajout_produit'] = "L'image doit avoir une extension parmi : .png, .jpg, .jpeg";
    header("Location: admin.php");
    exit(); 
}

$resultat = add_product($nom_produit, $type_produit, $prix_produit,
                        $illustration_produit, $description_produit);

// Vérifier le résultat de l'ajout
if ($resultat === true) {
    $_SESSION['ajout_produit'] = "Produit : " . $nom_produit . " ajouté avec succès !";
} else {
    $_SESSION['ajout_produit'] = "Erreur lors de l'ajout du produit.";
}

header("Location: admin.php");
exit();
?>