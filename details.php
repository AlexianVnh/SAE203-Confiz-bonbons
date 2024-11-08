<?php
    include_once("header.php")
?>

<!DOCTYPE html>
<html lang="fr">

<body>
    <main>
        <section class="details-container w-70">
            <?php
                $confiserie = get_product_by_id($_GET['id_produit']);
                $boutique = get_shop_by_id($_GET['id_boutique']);
            ?>
            <div class="detail_chemin">
                <a href="<?=CHEMIN_URL_SERVER?>index.php">Accueil</a>/<a href="<?=CHEMIN_URL_SERVER?>produits.php?id_boutique=<?=$boutique[0]['id']?>"><?=$boutique[0]['nom']?></a>/<a href=""><?=$confiserie[0]['nom']?></a>
            </div>

            <img src="media/images/produits/<?=$confiserie[0]['illustration']?>" height="400" alt="Image produit">

            <article class="details-description">
                <div class="details-nom-bonbons">
                    <p>Catégorie : <?=  $confiserie[0]['type'] ?></p>

                    <h1 class="paytone-one p-60"><?=$confiserie[0]['nom']?></h1>
                    <p><?=$confiserie[0]['description']?></p>
                </div>

                <div class="details-prix-bonbons">
                    <h2 class="p-30"><?= $confiserie[0]['prix'] ?>€</h2>
                    <p>TVA incluse</p>

                    <form class="add-to-cart-form" data-nom="<?= htmlspecialchars($confiserie[0]['nom']) ?>" data-prix="<?= htmlspecialchars($confiserie[0]['prix']) ?>" data-id="<?= $confiserie[0]['id'] ?>">
                        <input type="hidden" name="produit_id" value="<?= $confiserie[0]['id'] ?>">
                        <button type="submit" class="p-26">Ajouter au panier</button>
                    </form>
                </div>
            </article>
        </section>
    </main>
    






    <?php
        include_once("footer.php")
    ?>
</body>
</html>