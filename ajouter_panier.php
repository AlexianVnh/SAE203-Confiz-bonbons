<?php
session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

if (isset($_POST['produit_id'])) {
    $produit_id = $_POST['produit_id'];

    if (!in_array($produit_id, $_SESSION['panier'])) {
        $_SESSION['panier'][] = $produit_id;
    }
}

header("Location: produits.php");
exit();
?>

