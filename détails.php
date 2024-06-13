<?php
    include_once("header.php")
?>

<!DOCTYPE html>
<html lang="fr">

<body>
    <main>
        <section class="details-container">
            <?php
                $confiserie = get_product_by_id($_GET['id_produit']);
                $boutique = get_shop_by_id($_GET['id_boutique']);
            ?>
            <div>
                <a href="<?=CHEMIN_URL_SERVER?>index.php">Accueil/</a><a href="<?=CHEMIN_URL_SERVER?>produits.php?id_boutique=<?=$boutique[0]['id']?>"><?=$boutique[0]['nom']?>/</a><a href=""><?=$confiserie[0]['nom']?></a>
                <img src="media/images/produits/1.png" height="400" alt="Image produit">
            </div>

            <article class="details-description">
                <div class="details-nom-bonbons">
                    <p>Catégorie : <?=  $confiserie[0]['type'] ?></p>

                    <h1 class="paytone-one p-60"><?=$confiserie[0]['nom']?></h1>
                    <p><?=$confiserie[0]['description']?></p>
                </div>

                <div class="details-prix-bonbons">
                    <h2 class="p-30"><?=$confiserie[0]['prix']?>€</h2>
                    <p>TVA incluse</p>
                    <button class="p-26">Ajouter au panier</button>
                </div>
            </article>
        </section>
    </main>
    






    <?php
        include_once("footer.php")
    ?>
</body>
</html>