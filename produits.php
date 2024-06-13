<?php
    include_once("header.php");
?>

<!DOCTYPE html>
<html lang="fr">

<body>
    <main>
        <?php
            /* récupérer le nom de la boutique et son id */
            $boutique_id = $_GET['id_boutique'];
            $boutique = get_shop_by_id($boutique_id);

            /* récupérer ses produits */
            
        ?>


        <section class="produits-nav w-70 padding-50y">
            <h1 class="paytone-one p-60"><?=$boutique[0]['nom']?></h1>
            
            <nav class="produits-nav-boutons">
                <?php
                    $types = get_product_type();
                    echo('<button class="categorie-button categorie-button-active p-20" data-id="all">Tous</button>');
                    foreach ($types as $type) {
                        echo('<button class="categorie-button p-20" data-id="'. $type['type'] .'">' . $type['type'] . '</button>');
                    }
                ?>
            </nav>
        </section>


        <section class="produits-container w-70 padding-50y">         
            <article class="produit-ajout border-r-15">
                <h2 class="p-26">Ajouter un produit</h2>
                <form action="ajouter_produit.php" class="form-ajout-produit" method="post">
                    <label for="nom-produit">Nom de la boutique</label>
                    <input class="" type="text" id="nom-produit" name="nom-produit" placeholder="Ex : Haribo choco's" required>
                
                    <label for="name">Type / prix / description</label>
                    <div>
                        <input class="numero-rue" type="text" id="type-produit" name="type-produit" placeholder="Type :" required>
                        <input class="nom-rue" type="text" id="prix-produit" name="prix-produit" placeholder="RUE du chemin vert" required>
                        <input class="code-postal" type="text" id="description-produit" name="description-produit" placeholder="22300" required>
                        <input class="" type="submit" value="Ajouter" required>              
                    </div>           
                    <?php
                        if (isset($_SESSION['ajout_produit'])) {
                            echo '<p class="ajout-boutique-feedback">' . $_SESSION['ajout_boutique'] . "</p>";
                            unset($_SESSION['ajout_boutique']);
                        }
                    ?>    
                </form>
            </article>
                    
        <?php
            $confiseries = get_products_and_their_stock($boutique[0]['id']);
            foreach ($confiseries as $confiserie) {
                $compteur = 0;
        ?>

            <article class="produit border-r-15" data-id="<?=$confiserie['type']?>">
                <img src="media/images/produits/<?=$confiserie['id']?>.png" height="280px" alt="<?=$confiserie['nom']?>" title="<?=$confiserie['nom']?>">
                
                <h3> <?= $confiserie['nom'] ?> </h3>
                <p> <?= $confiserie['description'] ?> </p>
                <p id="produits-prix"> <?= $confiserie['prix'] ?> </p>

                <a href="détails.php?id_produit=<?=$confiserie['id']?>&id_boutique=<?=$boutique[0]['id']?>">En savoir +</a>
            </article>

        <?php   
            } /* end foreach */
        ?>

        </section>


    </main>

<?php
    include_once("footer.php");
?>

</body>
</html>