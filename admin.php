<?php
    include_once("header.php");
?>

<!DOCTYPE html>
<body>
    <h1 class="paytone-one p-60 w-70 padding-50y">Interface admin</h1>
    <p class="p-20 w-70">Vous pouvez ajouter et supprimer des boutiques et des produits</p>
    
    <section class="admin-modif-container w-70 padding-50y">
        <!-- 1 - Ajout de boutique -->
        <article class="carte-admin-modif">
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
                    <input class="admin-submit-buttons" type="submit" value="Ajouter" required>              
                </div>           
                <?php
                    if (isset($_SESSION['ajout_boutique'])) {
                        echo '<p class="ajout-boutique-feedback">' . $_SESSION['ajout_boutique'] . "</p>";
                        unset($_SESSION['ajout_boutique']);
                    }
                ?>    
            </form>        
        </article>

        <!-- 2 - Suppression de boutique -->
        <article class="carte-admin-modif">
            <h2 class="paytone-one p-26">Supprimer une boutique</h2>
            <form action="suppression_boutique.php" class="form-ajout-boutique" method="post">
                <label for="nom-boutique">Nom de la boutique</label>
                <select class="" type="text" id="nom-boutique" name="id-boutique" required>
                <?php
                    $shop = get_shop();
                    foreach ($shop as $boutique) {
                ?>
                    <option value="<?=$boutique['id']?>"><?=$boutique['nom']?></option>
                <?php
                    } /* fin foreach */
                ?>
                </select>
                <input class="admin-submit-buttons" type="submit" value="Supprimer" required>                       

                <?php
                    if (isset($_SESSION['suppression_boutique'])) {
                        echo '<p class="ajout-boutique-feedback">' . $_SESSION['suppression_boutique'] . "</p>";
                        unset($_SESSION['suppression_boutique']);
                    }
                ?>    
            </form>        
        </article>

        <!-- 3 - Ajout de produit -->
        <article class="carte-admin-modif">
            <h2 class="paytone-one p-26">Ajouter un produit</h2>
            <form action="ajouter_produit.php" class="form-ajout-boutique" method="post">
                <label for="nom-produit">Nom de la confiserie</label>
                <input class="" type="text" id="nom-produit" name="nom-produit" placeholder="Ex : Haribo Simpsons" required>
                
                <label for="type-produit">Type</label>
                <select class="" type="text" id="type-produit" name="type-produit" required>
                <?php
                    $types = get_product_type();
                    foreach ($types as $type) {
                ?>
                    <option value="<?=$type['type']?>"><?=$type['type']?></option>
                <?php
                    } /* fin foreach */
                ?>
                </select>

                <label for="prix-produit">Prix (€)</label>
                <input class="" type="text" id="prix-produit" name="prix-produit" placeholder="3.99" pattern="[0-9]*\.?[0-9]+" title="Seulements les chiffres et un point pour les décimales sont acceptées" required>

                <label for="illustration-produit">Chemin de l'image</label>
                <input class="" type="text" id="illustration-produit" name="illustration-produit" placeholder="nom_image.png" required>    
                
                <label for="description-produit">Description</label>
                <textarea class="description-produit" type="text" id="description-produit" name="description-produit" placeholder="Ecrivez votre description ici.." required></textarea>
                
                <input class="admin-submit-buttons" type="submit" value="Ajouter" required>              
                <?php
                    if (isset($_SESSION['ajout_produit'])) {
                        echo '<p class="ajout-boutique-feedback">' . $_SESSION['ajout_produit'] . "</p>";
                        unset($_SESSION['ajout_produit']);
                    }
                ?>    
            </form>         
        </article>

        <!-- 4 - Suppression de produit -->
        <article class="carte-admin-modif">
            <h2 class="paytone-one p-26">Supprimer un produit</h2>
            <form action="suppression_produit.php" class="form-ajout-boutique" method="post">
                <label for="nom-produit">Nom de la confiserie</label>
                <select class="" id="nom-produit" name="id-produit" required>
                <?php
                    $produits = get_product();
                    foreach ($produits as $produit) {
                ?>
                    <option value="<?=$produit['id']?>"><?=$produit['nom']?></option>
                <?php
                    } /* fin foreach */
                ?>
                </select>
                <input class="admin-submit-buttons" type="submit" value="Supprimer" required>                       

                <?php
                    if (isset($_SESSION['suppression_produit'])) {
                        echo '<p class="ajout-boutique-feedback">' . $_SESSION['suppression_produit'] . "</p>";
                        unset($_SESSION['suppression_produit']);
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