<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre panier</title>
</head>
<body>
    
    <h1>Votre panier</h1>
    <?php if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])): ?>
        <ul>
            <?php foreach ($_SESSION['panier'] as $produit_id): ?>
                <li>Produit ID: <?php echo($produit_id); ?> </li>
            <?php endforeach; ?>
        </ul> 
    <?php else: ?>
        <p>Votre panier est vide.</p>
    <?php endif; ?>
   
</body>
</html>


