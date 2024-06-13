<?php
    include_once("header.php");
?>

<!DOCTYPE html>
<body>
    <section class="herobanner-boutiques">
        <img src="media/images/fond-boutiques.png" width="100%" alt="">
        <article class="herobanner-boutiques-content w-70 padding-50y">
            <h1 class="paytone-one p-60">Nos boutiques</h1>
            <form class="barre-de-recherche" action="recherche_verification.php">
                <input type="text" id="recherche" name="recherche" required>
                <input type="submit" value="Chercher">
            </form>
        </article>
    </section>
    
    <section class="carte-boutiques-container w-70 padding-50y">
        <!-- Afficher toutes les boutiques -->
        <?php
            $shop = get_shop();
            $nombre_boutique = 0;
            foreach ($shop as $boutique) {
        ?>
        <article class="carte-boutique">
            <img src="media/images/boutiques/<?=$boutique['id']?>.jpg" width="300" height="300" alt="">
            <?php    
                echo "Nom : " . $boutique['nom'] . "<br>";
                echo "Adresse : " . $boutique['numero_rue'] . " " . $boutique['nom_adresse'] . ", " . $boutique['code_postal'] . ", "  . $boutique['ville'] . ", " . $boutique['pays'] . "<br>";
            ?>
            <a href="<?=CHEMIN_URL_SERVER?>produits.php?id_boutique=<?=$boutique['id']?>" class="boutique-voir-plus">Découvrir leurs produits ></a>
        </article>
        <?php        
                if ($nombre_boutique >= 8) {
                    /* afficher la séparation */
                    $nombre_boutique = 0; /* on réinitialise */
                }
            }
        ?>
    </section>
</body>
</html>


<?php
include_once("footer.php");
?>