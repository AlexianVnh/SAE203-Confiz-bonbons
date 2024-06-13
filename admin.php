<?php
    include_once("header.php");
?>

<!DOCTYPE html>
<body>
    <h1 class="paytone-one p-60 w-70 padding-50y">Paramètres admin</h1>
    <p class="p-20 w-70">Vous pouvez ajouter et supprimer des boutiques et des produits</p>
    
    <section class="admin-boutiques-container w-70 padding-50y">
        <article class="carte-boutique-ajout">
            <h2 class="paytone-one p-26">Ajouter une boutique</h2>
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

        <article class="carte-boutique-ajout">
            <h2 class="paytone-one p-26">Supprimer une boutique</h2>
            <form action="suppression_boutique.php" class="form-ajout-boutique" method="post">
                <label for="nom-boutique">Nom de la boutique</label>
                <select class="" type="text" id="nom-boutique" name="nom-boutique" required>
                <?php
                    $shop = get_shop();
                    foreach ($shop as $boutique) {
                ?>
                    <option value="<?=$boutique['id']?>"><?=$boutique['nom']?></option>
                <?php
                    } /* fin foreach */
                ?>
                </select>
                <input class="" type="submit" value="Supprimer" required>                       

                <?php
                    if (isset($_SESSION['suppression_boutique'])) {
                        echo '<p class="ajout-boutique-feedback">' . $_SESSION['suppression_boutique'] . "</p>";
                        unset($_SESSION['suppression_boutique']);
                    }
                ?>    
            </form>        
        </article>
    </section>
    

</body>
</html>




<?php
include_once("footer.php");
?>