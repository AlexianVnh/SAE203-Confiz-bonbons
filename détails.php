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
            ?>


            <img src="media/images/produits/1.png" height="400" alt="Image produit">

            <div class="details-description">

                <div class="details-nom-bonbons">

                    <p>Catégorie : <?=  $confiserie[0]['type'] ?></p>

                    <h1>Nom Bonbons  <?= $confiserie[0]['nom']  ?></h1>
                    <p> <?=  $confiserie[0]['description']?> </p>

                </div>

                <div class="details-prix-bonbons">

                    <h2><?= $confiserie[0]['prix']?>€</h2>
                    <p>TVA incluse</p>
                    <button>Ajouter au panier</button>

                </div>
                
            </div>
        </section>
    </main>
    






    <?php
        include_once("footer.php")
    ?>
</body>
</html>