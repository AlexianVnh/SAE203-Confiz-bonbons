<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$nom_produit = $_POST['nom-produit'];
$type_produit = $_POST['type-produit'];
$prix_produit = $_POST['prix-produit'];
$description_produit = $_POST['description-produit'];

$gerants = get_id_user_gerant();
$gerant_ids = array_column($gerants, 'id');

// Vérifier si le shop peut être créé avec le propriétaire
if (in_array($id_gerant, $gerant_ids)) {
    $resultat = add_shop($nom_boutique, $id_gerant, $numero_rue,
                     $nom_rue, $code_postal, $ville, $pays);

    if ($resultat == true){
        header("Location:" . CHEMIN_URL_SERVER . "boutiques.php");
        $_SESSION['ajout_boutique'] = "Boutique " . $nom_boutique . " ajoutée avec succès !";
        exit();
    }
}
else {
    header("Location:" . CHEMIN_URL_SERVER . "boutiques.php");
    $_SESSION['ajout_boutique'] = "L'utilisateur n'est pas gérant";
    exit();
}
?>