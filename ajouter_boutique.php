<?php
include_once ("functions.php");

// Récupérer les valeurs du formulaire
$nom_boutique = $_POST['nom-boutique'];
$id_gerant = $_POST['id-gerant'];
$numero_rue = $_POST['numero-rue'];
$nom_rue = $_POST['nom-rue'];
$code_postal = $_POST['code-postal'];
$ville = $_POST['ville'];
$pays = $_POST['pays'];

$gerants = get_id_user_gerant();
$gerant_ids = array_column($gerants, 'id');

// Vérifier si le shop peut être créé avec le propriétaire
if (in_array($id_gerant, $gerant_ids)) {
    $resultat = add_shop($nom_boutique, $id_gerant, $numero_rue,
                     $nom_rue, $code_postal, $ville, $pays);

    if ($resultat == true){
        header("Location:" . CHEMIN_URL_SERVER . "admin.php");
        $_SESSION['ajout_boutique'] = "Boutique " . $nom_boutique . " ajoutée avec succès !";
        exit();
    }
}
else {
    header("Location:" . CHEMIN_URL_SERVER . "admin.php");
    $_SESSION['ajout_boutique'] = "L'utilisateur n'est pas gérant";
    exit();
}
?>