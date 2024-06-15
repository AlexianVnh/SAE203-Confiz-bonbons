<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$nom_produit = $_POST['nom-produit'];
$type_produit = $_POST['type-produit'];
$prix_produit = $_POST['prix-produit'];
$illustration_produit = $_POST['illustration-produit'];
$description_produit = $_POST['description-produit'];


$extension_png = '.png';
$extension_jpg = '.jpg';
$extension_jpeg = '.jpeg';
if (str_ends_with($description_produit, $extension_png) || str_ends_with($description_produit, $extension_jpg) || str_ends_with($description_produit, $extension_jpeg)) {
    $resultat = add_product($nom_produit, $type_produit, $prix_produit,
                $illustration_produit, $description_produit);
} else {
    $_SESSION['ajout_produit'] = "L'image doit se terminer par les extensions suivantes : .png / .jpg / .jpeg";
    header("Location:" . CHEMIN_URL_SERVER . "admin.php");
    exit(); 
}


if ($resultat == true){
    $_SESSION['ajout_produit'] = "Produit : " . $nom_produit . " ajoutée avec succès !";
}
else {
    $_SESSION['ajout_produit'] = "Erreur lors de l'ajout de la confiserie.";
}
header("Location:" . CHEMIN_URL_SERVER . "admin.php");
exit();
?>