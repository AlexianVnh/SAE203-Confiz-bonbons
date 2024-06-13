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
        <!-- Carte ajouter une boutique -->
        <?php

            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] === 'admin') {
        ?>
            <article class="carte-boutique-ajout border-r-15">
                <h2 class="p-26">Ajouter une boutique</h2>
                <form action="ajouter_boutique.php" class="form-ajout-boutique" method="post">
                    <label for="nom-boutique">Nom de la boutique</label>
                    <input class="" type="text" id="nom-boutique" name="nom-boutique" placeholder="Ex : Confiz boutique" required>
                
                    <label for="id-gerant">Id du gérant</label>
                    <input class="" type="text" id="id-gerant" name="id-gerant" placeholder="Ex : 2" required>

                    <label for="name">Adresse (n° / nom de la rue / code postal / ville / pays)</label>
                    <div>
                        <input class="numero-rue" type="text" id="numero-rue" name="numero-rue" placeholder="123" required>
                        <input class="nom-rue" type="text" id="nom-rue" name="nom-rue" placeholder="RUE du chemin vert" required>
                        <input class="code-postal" type="text" id="code-postal" name="code-postal" placeholder="22300" required>
                        <input class="ville" type="text" id="ville" name="ville" placeholder="Lannion" required>
                        <input class="pays" type="text" id="pays" name="pays" placeholder="France" required>
                        <input class="" type="submit" value="Ajouter" required>              
                    </div>           
                    <?php
                        if (isset($_SESSION['ajout_boutique'])) {
                            echo '<p class="ajout-boutique-feedback">' . $_SESSION['ajout_boutique'] . "</p>";
                            unset($_SESSION['ajout_boutique']);
                        }
                    ?>    
                </form>        
            </article>
        <?php
            } /* fermer le if admin */
        }
        ?>
        
        
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