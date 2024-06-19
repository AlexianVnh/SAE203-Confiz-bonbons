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
            <div>
                <a href="<?=CHEMIN_URL_SERVER?>index.php">Accueil</a>/<a href="<?=CHEMIN_URL_SERVER?>boutiques.php">Nos boutiques</a>/<a href="<?=CHEMIN_URL_SERVER?>produits.php?id_boutique=<?=$boutique[0]['id']?>"><?=$boutique[0]['nom']?></a>
            </div>

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

            if (isset($_SESSION['id_user'])):
                /* pour debugger et bien verifier que c'est des entiers comparables */
                $session_id_user_tab = $_SESSION['id_user'];
                $session_id_user = $session_id_user_tab[0]['id'];
                $boutique_utilisateur_id = (int) $boutique[0]['utilisateur_id'];

                if ($session_id_user == $boutique_utilisateur_id):
            ?>
                    <form class="produit produit-ajout" action="ajouter_produit_a_boutique.php" method="post">
                        <h3 class="paytone-one p-20">Ajoutez un produit à votre boutique</h3>
                    
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
                        <input type="number" id="quantite-produit" name="quantite-produit" placeholder="Ex : 30" pattern="[0-9]+" title="Seulements les chiffres sont acceptées" required>
                    
                        <input type="submit" value="Ajouter à la boutique">
                    
                        <?php
                            if (isset($_SESSION['ajout_produit'])) {
                                echo '<p>' . $_SESSION['ajout_produit'] . '</p>';
                                unset($_SESSION['ajout_produit']);
                            }
                        ?>
                    </form>

                <?php
                endif;
            endif;

            foreach ($confiseries as $confiserie) {
                // Initialiser la quantité du produit dans la session si non déjà fait
                if (!isset($_SESSION['quantite_' . $confiserie['id']])) {
                    $_SESSION['quantite_' . $confiserie['id']] = $confiserie['quantite'];
                }

                // Traiter les actions d'incrémentation et de décrémentation
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $action = $_POST['action'];
                    $id_produit = $_POST['id_produit'];
                
                    ajust_product_qty($action, $id_produit);
                }
                ?>

                <article class="produit" data-id="<?= $confiserie['type'] ?>" data-quantite="<?= $_SESSION['quantite_' . $confiserie['id']] ?>" id="produit-<?= $confiserie['id'] ?>">
                    <div class="produit-image-bouton">
                        <img src="media/images/produits/<?= $confiserie['id'] ?>.png" height="250" width="250" alt="<?= $confiserie['nom'] ?>" title="<?= $confiserie['nom'] ?>">
                        <a class="produit-savoir-plus p-20" href="details.php?id_produit=<?= $confiserie['id'] ?>&id_boutique=<?= $boutique[0]['id'] ?>">En savoir +</a>
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
                            if ($session_id_user == $boutique_utilisateur_id):
                            ?>        
                                <input type="hidden" name="id_produit" value="<?=$confiserie['id']?>">
                                <div class="admin-quantite">
                                    <input class="produit-quantite" type="number" name="quantite" id="quantite-<?=$confiserie['id']?>" value="<?=$_SESSION['quantite_' . $confiserie['id']]?>">
                                    
                                    <button class="validation-quantite" type="submit" name="action" value="valider">Valider</button>

                                    <!-- afficher le feedback s'il y en a -->
                                    <?php 
                                        if (isset($_SESSION['feedback_messages'][$confiserie['id']])) {
                                            echo '<p class="feedback-message">' . $_SESSION['feedback_messages'][$confiserie['id']] . '</p>';
                                            unset($_SESSION['feedback_messages'][$confiserie['id']]);
                                        }
                                    ?>
                                </div>
                            <?php
                            endif;
                        endif;
                        ?>
                    </form>
                </article>
                <?php
            }
            ?>
        </section>
    </main>

    <script>
        /* Griser les produits si la quantité est égale à 0 */
        document.addEventListener("DOMContentLoaded", function() {
            var produits = document.querySelectorAll(".produit"); 
            produits.forEach(function(produit) { // Pour chaque produit on vérifier si la quantité est égale à 0
                var quantite = parseInt(produit.getAttribute("data-quantite"));
                if (quantite === 0) {
                    produit.classList.add("produit-epuise"); // Ajout de la classe avec le style

                    var epuiseMessage = document.createElement("div");
                    epuiseMessage.classList.add("message-epuise");
                    epuiseMessage.innerText = "Produit épuisé";

                    produit.appendChild(epuiseMessage);
                }
            });
        });
    </script>

    <?php include_once("footer.php"); ?>
</body>
</html>