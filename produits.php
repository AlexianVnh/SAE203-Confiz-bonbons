<?php
include_once("header.php");
?>

<!DOCTYPE html>
<html lang="fr">
<body>
    <main>
        <?php
        /* Récupérer le nom de la boutique et son id */
        $boutique_id = $_GET['id_boutique'];
        $boutique = get_shop_by_id($boutique_id);
        ?>

        <section class="produits-nav w-70 padding-50y">
            <h1 class="paytone-one p-60"><?= $boutique[0]['nom'] ?></h1>
            <nav class="produits-nav-boutons">
                <?php
                $types = get_product_type();
                echo('<button class="categorie-button categorie-button-active p-20" data-id="all">Tous</button>');
                foreach ($types as $type) {
                    echo('<button class="categorie-button p-20" data-id="' . $type['type'] . '">' . $type['type'] . '</button>');
                }
                ?>
            </nav>
        </section>

        <section class="produits-container w-70 padding-50y">
            <?php
            $confiseries = get_products_and_their_stock($boutique[0]['id']);
            $feedback_messages = []; // tableau de feedback

            /* pour debugger et bien verifier que c'est des entiers comparables */
            $session_id_user = (int) $_SESSION['id_user'];
            $boutique_utilisateur_id = (int) $boutique[0]['utilisateur_id'];

            if (isset($_SESSION['id_user'])):
            ?>
                <form class="produit produit-ajout" action="ajouter_produit_a_boutique.php" method="post">
                    <h3 class="paytone-one p-20">Ajoutez un produit à votre boutique</h3>
                    <p>Retrouvez ci-dessous le catalogue global</p>
                
                    <label for="id-produit">Liste des produits</label>
                    <select class="" type="text" id="id-produit" name="id-produit" required>
                    <?php
                        $products = get_all_products(); 
                        foreach ($products as $product) {
                    ?>
                        <option value="<?=$product['id']?>"><?=$product['nom']?></option>
                    <?php
                        } /* fin foreach */
                    ?>
                    </select>

                    <input type="hidden" name="id-boutique" value="<?=$boutique[0]['id']?>">

                    <label for="quantite-produit">Quantité du produit</label>
                    <input class="" type="text" id="quantite-produit" name="quantite-produit" placeholder="Ex : 30" pattern="[0-9]" title="Seulements les chiffres sont acceptées" required>
                
                    <input type="submit" value="Ajouter à la boutique">
                </form>

                
            <?php
            endif;

            foreach ($confiseries as $confiserie) {
                // Initialiser la quantité du produit dans la session si non déjà fait
                if (!isset($_SESSION['quantite_' . $confiserie['id']])) {
                    $_SESSION['quantite_' . $confiserie['id']] = $confiserie['quantite'];
                }

                // Traiter les actions d'incrémentation et de décrémentation
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produit']) && $_POST['id_produit'] == $confiserie['id']) {
                    if (isset($_POST['action'])) {
                        ajust_product_qty($_POST['action'], $confiserie['id']);
                    } elseif (isset($_POST['valider'])) {
                        $quantite_finale = $_SESSION['quantite_' . $confiserie['id']];
                        update_product_qty($quantite_finale, $confiserie['id']);
                        $feedback_messages[$confiserie['id']] = 'Quantité validée!';
                    }
                }
                ?>

                <article class="produit" data-id="<?= $confiserie['type'] ?>">
                    <div class="produit-image-bouton">
                        <img src="media/images/produits/<?= $confiserie['id'] ?>.png" height="280px" width="280" alt="<?= $confiserie['nom'] ?>" title="<?= $confiserie['nom'] ?>">
                        <a class="produit-savoir-plus p-20" href="détails.php?id_produit=<?= $confiserie['id'] ?>&id_boutique=<?= $boutique[0]['id'] ?>">En savoir +</a>
                    </div>

                    <form class="produit-description" method="post">
                        <div class="produit-nom-description">
                            <h3 class="p-20"><?= $confiserie['nom']?></h3>
                            <p><?=$confiserie['description']?></p>
                        </div>

                        <div class="produit-prix-panier">
                            <p class="produit-prix p-20"><?= $confiserie['prix'] ?>€</p>
                        </div>

                        <?php
                        if (isset($_SESSION['id_user'])):
                        
                            if ($session_id_user == $boutique_utilisateur_id) {
                            ?>        
                                <input type="hidden" name="id_produit" value="<?=$confiserie['id']?>">
                                <div class="admin-quantite">
                                    <p class="produit-quantite"><?= $_SESSION['quantite_' . $confiserie['id']] ?></p>

                                    <div class="produit-quantite-boutons">
                                        <button class="ajouter-quantite" type="submit" name="action" value="incrementer">+</button>
                                        <button class="supprimer-quantite" type="submit" name="action" value="decrementer">-</button>
                                    </div>

                                    <button class="validation-quantite" type="submit" name="valider">Valider</button>

                                    <!-- afficher le feedback s'il y en a -->
                                    <?php 
                                    if (isset($feedback_messages[$confiserie['id']])) {
                                    ?>
                                        <p class="feedback-message"><?= $feedback_messages[$confiserie['id']] ?></p>
                                    <?php 
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                        endif;
                        ?>
                        
                        
                    </form>
                </article>
                <?php
            }
            ?>
        </section>
    </main>

    <?php include_once("footer.php"); ?>
</body>
</html>