<?php
    include_once("header.php");
?>

<!DOCTYPE html>
<html lang="fr">

<body>
    <main>
        
        <nav class="produits-nav w-70 padding-50y">
            <h1>Nos produits</h1>
            <h2></h2>
            <div class="produits-nav-boutons">
                <button>Tous</button>
                <button>Sachet</button>
                <button>Boîte</button>
                <button>Haribo</button>
                <button>Carambar</button>
            </div>
        </nav>





        <section class="produits-container padding-50y">


        <?php
            $confiseries = get_products_and_their_stock($id_confiserie);
            foreach ($confiseries as $confiserie) {
        ?>


            <article class="produit">
                <img src="media/images/produits/<?=$confiserie['id']?>.jpg" alt="Mini Banan's">
                
                <h3> <?= $confiserie['nom'] ?> </h3>

                <p> <?= $confiserie['description'] ?> </p>

                <p id="produits-prix"> <?= $confiserie['prix'] ?> </p>

            </article>

                <?php } ?>

        </section>


    </main>

<?php
    include_once("footer.php");
?>

</body>
</html>